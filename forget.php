<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
	$mail->SMTPDebug = 2;									 
	$mail->isSMTP();										 
	$mail->Host	 = 'sandbox.smtp.mailtrap.io';				 
	$mail->SMTPAuth = true;							 
	$mail->Username = 'f8e08ed4155b95';				 
	$mail->Password = '6e2a89d59d59a0';					 
	$mail->SMTPSecure = 'tls';							 
	$mail->Port	 = 2525; 

    $mail->setFrom('info@mailtrap.io', 'Mailtrap');
    $mail->addReplyTo('info@mailtrap.io', 'Mailtrap');
    $mail->addAddress('recipient1@mailtrap.io', 'Tim');
    $mail->addCC('cc1@example.com', 'Elena');
    $mail->addBCC('bcc1@example.com', 'Alex');
	
	$mail->isHTML(true);								 
	$mail->Subject = 'Subject';
	$mail->Body = 'HTML message body in <b>bold</b> ';
	$mail->AltBody = 'Body in plain text for non-HTML mail clients';
	$mail->send();
	echo "Mail has been sent successfully!";
} catch (Exception $e) {
	echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}




?>
