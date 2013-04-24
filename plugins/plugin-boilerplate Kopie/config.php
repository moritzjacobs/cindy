<?php
class PluginBoilerplate extends Plugin {
	public $settings = array(
	
	/* *********************************
     *  PLUGIN SETTINGS, NON-OPTIONAL! *
	 ********************************* */
	   
		#must be the same as the folder this is in
		"folder_name" => "plugin-boilerplate",
		
		# location of the content file
		"template_file" => "content.php",
		
		# list of assets in this folder
		# NOTICE: these apply to the plugin container,
		# not to the plugin content!
		"assets" => array(
			"plugin-bp.js",
			"plugin-bp.css",
		),
		
		# iframe recommended
		"type" => "iframe",
		
		# as big as possible
		"width" => "100%",
		"height" => "*",
		
	);	
}