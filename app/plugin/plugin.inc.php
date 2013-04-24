<?php

abstract class Plugin {

	private $template_file;
	private $width;
	private $height;
	private $params;
	private $assets;

	function __construct($params) {
		$this->params = $params;
		$this->userParams();
	}

	private function userParams() {
		foreach($this->params as $key=>$val) {
			$this->$key = $val;
		}
	}

	public function setConfig($config) {
		$this->plugin_name = $config["folder_name"];
		$this->assets = "";
		if (!empty($config["assets"])) {
			foreach ($config["assets"] as $asset) {
				$this->assets .= 'inject "@root_path/plugins/'.$config["folder_name"].'/'.$asset."\"\n";
			}
		}
		$this->template_file = "/plugins/".$config["folder_name"]."/".$config["template_file"];
		$this->type = $config["type"];
		$this->width = $config["width"];
		$this->height = $config["height"];
		$this->userParams();
	}

	public function run() {
		echo $this->assets;
		if ($this->type === "iframe") {
			echo "<iframe id='".$this->plugin_name."' ";
			echo "width='".$this->width."' ";
			echo "height='".$this->height."' ";

			$get_data = Helpers::serialize_get_string($this->params);

			echo "src='".$this->template_file.$get_data."' ";
			echo ">";
			echo "</iframe>";
		} else {
			$this->getContent();
		}
	}

	private function getContent() {
		$tpl = file_get_contents($this->template_file);
		eval(' ?>'.$tpl.'<?php ');
	}

}

?>