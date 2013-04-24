<?php

EmbedHelper::parseParams($_GET);

class EmbedHelper {

	static function parseParams($params) {
		$params = array();
		foreach ($_GET as $key=>$param) {
			$params[urldecode($key)] = urldecode($param);
		}
		
		$type = "none";
		$id = "";
		
		foreach($params as $k=>$v) {
			if (strpos($k, "youtu") !== false && $v !== "1") {
				$type = "youtube";
				$id = $v;
			} else if (strpos($k, "youtu") !== false && $v === "1") {
				$url_id = array_pop(explode("/", $k));
				$type = "youtube";
				$id = $url_id;
			} else if (strpos($k, "vimeo") !== false && $v !== "1") {
				$type = "vimeo";
				$id = $v;
			} else if (strpos($k, "vimeo") !== false && $v === "1") {
				$url_id = array_pop(explode("/", $k));
				$type = "vimeo";
				$id = $url_id;
			}
		}
		
		if ($type != "none" && !empty($id)) {
			self::$type($id);
		} else {
			echo "Invalid embedding url or code.";
		}
		
	}

	static function youtube($id) {
		$location = "http://www.youtube-nocookie.com/embed/{$id}?rel=0";
		header("Location: " . $location);
	}

	static function vimeo($id) {
		$location = "http://player.vimeo.com/video/".$id;
		header("Location: " . $location);
	}

}
