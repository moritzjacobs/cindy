<?php
class ContactForm extends Plugin {
	public $settings = array(

	"base" => "http://localhost/stacey_admin",
	
	/* *********************************
     *  PLUGIN SETTINGS, NON-OPTIONAL! *
	 ********************************* */
	   
		#must be the same as the folder this is in
		"folder_name" => "contact-form",
		
		# location of the content file
		"template_file" => "content.php",
		
		# list of assets in this folder
		# NOTICE: these apply to the plugin container,
		# not to the plugin content!
		"assets" => array(
			"contact-form.js",
			"contact-form.css",
		),
		
		# iframe recommended
		"type" => "iframe",
		
		# as big as possible
		"width" => "100%",
		"height" => "*",
	);	
}