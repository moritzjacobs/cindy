<?php
class Embed extends Plugin {
	public $settings = array(

		# change this!
		"folder_name" => "embed",
		"width" => "100%",
		"height" => "300",
		
		
		# leave this!
		"template_file" => "content.php",
		"type" => "iframe",
		"assets" => array(
			"embed.css",
		),		
	);	
}