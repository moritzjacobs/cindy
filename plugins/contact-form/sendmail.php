<?php

	/* -----------
	   PREFERENCES
	   ----------- */
	$your_email = "mail@moritzjacobs.de";
	
	$ok_message = "Thanks for your message!";

	$fail_message = "Oops, there's something wrong with the system! Please email us directly: <a href=\"mailto:".$your_email."\">".$your_email."</a>";

	/* -----------
	   APP
	   ----------- */
	   
	if (isset($_POST['submit'])) {
		$msg = $_POST['name'] . " <" . $_POST['email'] . "> " . "\n\nReferral: " . $_POST['refer'] . "\n\nMessage:\n" . $_POST['text'] ;
			mail($your_email, 'WEBSITE USER FORM', $msg);
		echo $ok_message;
	} else {
		echo $fail_message;	
	}
?>