<?php
ob_start();
# let people know if they are running an unsupported version of PHP
if(phpversion() < 5) {

	die('<h3>Cindy requires PHP/5.0 or higher.<br>You are currently running PHP/'.phpversion().'.</h3><p>You should contact your host to see if they can upgrade your version of PHP.</p>');

} else {

	# require helpers class so we can use rglob
	require_once './app/helpers.inc.php';
	# include any php files which sit in the app folder
	include_once("config.php");
	foreach(Helpers::rglob('./app/**.inc.php') as $include) include_once $include;
	foreach(Helpers::rglob('./plugins/**config.php') as $include) include_once $include;

	# start the app
	new Stacey($_GET);

}
ob_flush();
?>