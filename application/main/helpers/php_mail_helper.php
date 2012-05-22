<?php

/**
 * Simple email via php mail function
 *
 * @author	AgLiAn
 * @since	November 25,  2010
 */
function simplePHPMail($fromEmail, $fromName, $toEmail, $toName, $subject, $body) {
	if(function_exists('mail')) {

		$headers = "From: {$fromEmail}\r\n" .
			"Reply-To: {$fromEmail}\r\n" .
			'X-Mailer: PHP/' . phpversion();

		$from = "From: ".$fromName." ".$fromEmail;
			
		if(mail($toEmail, $subject, $body, $from)) {
			return true;
		} else {
			return false;
		}
	}
}
?>
