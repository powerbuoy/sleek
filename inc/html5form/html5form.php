<?php
	require_once 'form.php';
	require_once 'validEmail.php';
	require_once 'phpmailer/PHPMailerAutoload.php';

	function sendMail ($to, $subject, $html, $files = false) {
		$mail = new PHPMailer;

		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl'; # ssl / tls
		$mail->Port = '465'; # 465 / 587
		$mail->Username = MAILUSER;
		$mail->Password = MAILPASS;

		$mail->CharSet = 'UTF-8';

		$mail->From = 'no-reply@lagerkvist.eu';
		$mail->FromName = 'Lagerkvist.eu';

		$mail->addAddress('powerbuoy@gmail.com');
		$mail->addAddress($to);

		$mail->isHTML(true);

		$mail->Subject = $subject;
		$mail->Body = $html;
		$mail->AltBody = strip_tags($html);

		if (is_array($files) and count($files)) {
			foreach ($files as $path => $name) {
				$mail->addAttachment($path, $name);
			}
		}

		if ($mail->send()) {
			return true;
		}
		else {
			return $mail->ErrorInfo;
		}
	}
?>

