<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">

<html>
<head>
    <meta http-equiv="Content-type" content="text/html; charset=iso-8859-1">
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
    <script src="/js/jquery-1.3.2.js" type="text/javascript" charset="utf-8"></script>
</head>

<body onload='parent.resizeIframe(document.body.scrollHeight)'>
    <div id="content">
       <h2>Contact form:</h2>
<div id="contact-form">
	<div id="contact-form-response">&nbsp;</div>
	 <form>	
	 	<fieldset id="contact-form-contact">
			
			<label for="name">Name: <em>*</em> </label><br />
			<input class="contact-form-req" type="text" name="name" id="contact-form-name" value=""><br /><br />
			
			<label for="email">Email:</label><br />
			<input type="text" name="email" id="contact-form-email" value=""><br /><br />
				
		</fieldset>
		<fieldset id="contact-form-message">
			<label for="text">Your message: </label><br />
			<textarea name="text" id="contact-form-text"></textarea><br /><br />
			
			<label for="refer">How I found this website<em>*</em></label><br />
			<select name="refer" size="1" id="contact-form-refer" class="contact-form-req">
				<option value="">(please choose!)</option>
				<option value="Google">Google</option>
				<option value="Other">Other</option>
		    </select>
		    
		</fieldset>
		<br><br>
			<input type="submit" id="contact-form-submit" name="submit" />
			<p><em>*</em> = compulsory<br /><small>Javascript must be enabled!</small></p>

	</form></div>

<script type="text/javascript">
	$(document).ready(function() {

		$("form").bind("keypress", function(e) {
             if (e.keyCode == 13) {
                 e.preventDefault();
            }
         });
	
		$("#contact-form-submit").click(function(e) {
			e.preventDefault();
			var checked = true;
			$("input.contact-form-req, select.contact-form-req").removeClass("contact-form-recheck");
			$("input.contact-form-req, select.contact-form-req").each(function(index, value) {
				if ($(this).val() == null || $(this).val() == "") {
					checked = false;
					$(this).addClass("contact-form-recheck");
					$("#contact-form-response").text("Please check your input.");
				}
			});
			
			if (checked) {
				$("#contact-form-response").text("Please wait...");
				$("#contact-form-response").load("/plugins/contact-form/sendmail.php", {							
					submit: true,
					name: $("#contact-form-name").val(),
					email: $("#contact-form-email").val(),
					text: $("#contact-form-text").val(),
					refer: $("#contact-form-refer").val(),
				});
				
				$("#contact-form form").remove();
				
			} else {
			
			}
		});		
	});
</script>
    </div>
</body>
</html>
