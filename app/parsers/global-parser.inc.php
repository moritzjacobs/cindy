<?php

class GlobalParser {


	/**
	 * parse function.
	 * 
	 * @access public
	 * @static
	 * @param mixed $html
	 * @return void
	 */
	static function parse($html) {

		$plugin_regex = "@\[([\s-=\:\.\/\?\w]+)\]";
		if (preg_match('/(<p>'.$plugin_regex.'<\/p>)[\S\s]*/', $html, $plugin_matches)) {
			$html = self::parse_plugins($html, $plugin_matches);
		}

		if (preg_match('/('.$plugin_regex.')[\S\s]*/', $html, $plugin_matches)) {
			$html = self::parse_plugins($html, $plugin_matches);
		}

		# asset injection default -> <head>
		if(preg_match('/inject[\s]+?["\']\/?(.*?)\/?["\']([\S\s]+?)/', $html)) {
			$html = self::parse_inject($html, "");
		}

		# asset injection <head>
		if(preg_match('/inject_head[\s]+?["\']\/?(.*?)\/?["\']([\S\s]+?)/', $html)) {
			$html = self::parse_inject($html, "head");
		}

		# asset injection <body> (end)
		if(preg_match('/inject_body[\s]+?["\']\/?(.*?)\/?["\']([\S\s]+?)/', $html)) {
			$html = self::parse_inject($html, "body");
		}
		return $html;
	}



	/**
	 * parse_plugins function.
	 * 
	 * @access public
	 * @static
	 * @param mixed $html
	 * @param mixed $matches
	 * @return void
	 */
	static function parse_plugins($html, $matches) {
		$plugin_tag = $matches[1];
		$plugin_name = $matches[2];
		$params_str = explode(" ", $plugin_name);
		$plugin_name = array_shift($params_str);

		$params = array();
		foreach($params_str as $param_str) {

			$val = true;
			if (strpos($param_str, "=") > 0) {
				$pts = explode("=", $param_str);
				$key = $pts[0];
				$val = $pts[1];
			} else {
				$key = trim($param_str);
			}

			$params[$key] = $val;
		}

		$class_name_pts = explode("-", $plugin_name);
		foreach($class_name_pts as &$cn) { $cn = ucfirst($cn); }
		$class_name = implode("", $class_name_pts);

		if(class_exists($class_name)) {
			$plugin_instance = new $class_name($params);
			$plugin_instance->setConfig($plugin_instance->settings);
			ob_start();
			$plugin_instance->run();
			$plugin_output  = ob_get_contents();
			ob_end_clean();

			$html = str_replace($plugin_tag, $plugin_output, $html);
		} else {
			$html = str_replace($plugin_tag, "<p>Error: Plugin ".$plugin_name." not found!</p>", $html);
		}

		$html = self::parse($html);
		return $html;
	}



	/**
	 * parse_inject function.
	 * 
	 * @access public
	 * @static
	 * @param mixed $html
	 * @param mixed $whereto
	 * @return void
	 */
	static function parse_inject($html, $whereto) {

		$modifier = "";
		if (empty($whereto)) {
			$whereto = "head";
		} else {
			$modifier = "_".$whereto;
		}
		
		preg_match('/(inject'.$modifier.'[\s]+?["\'](\/?.*?\/?)["\'])([\S\s]*)$/', $html, $inject_matches);

		$whereto = "</".$whereto.">";
		$asset_path = $inject_matches[2];
		$inject_str = self::make_inject_str($asset_path, $whereto);

		$html = str_replace($inject_matches[1], "", $html);
		$html = str_replace($whereto, $inject_str, $html);
		$html = self::parse($html);
		return $html;
	}


	/**
	 * make_inject_str function.
	 	helper function: get html-injection from filename and add suffix for injection
	 * 
	 * @access public
	 * @static

	 * @param mixed $asset_path
	 * @param mixed $suffix
	 * @return void
	 */
	static function make_inject_str($asset_path, $suffix) {
		$inject_str = $suffix;
		$asset_type = array_pop(explode(".", $asset_path));
		if ($asset_type == "css") {
			$inject_str = '<link rel="stylesheet" href="'.$asset_path.'" type="text/css">'."\n".$inject_str;
		} elseif ($asset_type == "js") {
			$inject_str = '<script src="'.$asset_path.'"></script>'."\n".$inject_str;
		}
		return $inject_str;
	}


}

?>