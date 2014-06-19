<?php

include 'phpmailer/class.phpmailer.php';

function email($from, $from_name, $to, $to_name, $subject, $message, $attachments=false)
{
	global $config;
	
	$mail = new PHPMailer();
	$mail->CharSet = 'UTF-8';
	if (strtolower($config['email_protocol']) == 'smtp') {
		$mail->IsSMTP();
		$mail->Host = $config['smtp_host']; // sets the SMTP server
		
		if (!empty($config['smtp_user'])) {
			$mail->SMTPAuth   = true;                 // enable SMTP authentication
			$mail->Port       = $config['smtp_port']; // set the SMTP port for the GMAIL server
			$mail->Username   = $config['smtp_user']; // SMTP account username
			$mail->Password   = $config['smtp_pass']; // SMTP account password
			
			if (!empty($config['smtp_secure']))
				$mail->SMTPSecure = $config['smtp_secure'] == 'ssl' ? 'ssl': 'tls'; // sets the prefix to the server
		}
	
	}
	else if (strtolower($config['email_protocol']) == 'sendmail') {
		$mail->IsSendmail(); // telling the class to use SendMail transport
	}
	
	$mail->SetFrom($from, $from_name);
	
	$mail->AddReplyTo($from, $from_name);
	
	if (is_array($to))
		foreach($to as $t)
			$mail->AddAddress($t, $to_name);
	else
		$mail->AddAddress($to, $to_name);
	
	$mail->Subject = $subject;
	
	$mail->MsgHTML($message);
	
	if ($attachments)
		if (is_array($attachments))
			foreach ($attachments as $attachment)
				$mail->AddAttachment($attachment);
		else
			$mail->AddAttachment($attachments);
	
	$mail->Send();
}