<div id="content">
	<?php
		require("PHPMailer/PHPMailerAutoload.php"); 
		require("func_ratings.php");
		
		// if from the contact page, send to admin
		// else, send custom
		//$sendto_addr = "mikemurphytest@gmail.com";
		//$sendto_name = "MPM Administrator";
		//$sendreply_addr = "mmurph22@terpmail.umd.edu";
		//$sendreply_name = "Mike Murphy";
		$sendto_addr = get_ADMIN_EMail('primary');
		$sendto_name = get_ADMIN_Name('primary');
		$sendreply_addr = get_ADMIN_EMail('replyto');
		$sendreply_name = get_ADMIN_Name('replyto');
		
		// posted mail info
		$sendfrom_addr = "";
		$sendfrom_name = "";
		$sendfrom_subject = "";
		$sendfrom_msg = "";
		if (isset($_POST['txtEmail']))	$sendfrom_addr = $_POST['txtEmail'];
		if (isset($_POST['txtName']))	$sendfrom_name = $_POST['txtName'];
		if (isset($_POST['txtSubject']))	$sendfrom_subject = $_POST['txtSubject'];
		if (isset($_POST['txtMessage']))	$sendfrom_msg = $_POST['txtMessage'];
		
		/*
		print($sendto_addr . '<br>');
		print($sendto_name . '<br>');
		print($sendreply_addr . '<br>');
		print($sendreply_name . '<br>');
		print($sendfrom_addr . '<br>');
		print($sendfrom_name . '<br>');
		print($sendfrom_subject . '<br>');
		print($sendfrom_msg . '<br>');
		*/
		
		// to info may be given, or if not given, it is admin
		if (isset($_POST['txtEmailTo']))
			$sendto_addr = $_POST['txtEmailTo'];
		if (isset($_POST['txtNameTo']))
			$sendto_name = $_POST['txtNameTo'];
		if (isset($_POST['txtEmailReply']))
			$sendto_addr = $_POST['txtEmailReply'];
		if (isset($_POST['txtNameTo']))
			$sendto_name = $_POST['txtNameReply'];
		
		if (!empty($sendfrom_addr) && !empty($sendfrom_name) && !empty($sendfrom_subject) && !empty($sendfrom_msg)
			&& !empty($sendto_addr) && !empty($sendto_name) && !empty($sendreply_addr) && !empty($sendreply_name))
		{
			send_mail($sendfrom_addr, $sendfrom_name, $sendfrom_subject, $sendfrom_msg, 
						$sendto_addr, $sendto_name, $sendreply_addr, $sendreply_name);
		}
		else
		{
			print("<p>Mailer Error: Inputs for mail send Incomplete.</p>");
		}	
		
		function send_mail($fromEmail, $fromName, $subject, $message, $toEmail, $toName, $replyEmail, $replyName)
		{
			$mailer = new PHPMailer;
			try
			{
				//$mailer->SMTPDebug = 2;                                 // Enable verbose debug output
				$mailer->isSMTP();
				$mailer->Host = 'smtp.gmail.com';
				//$mailer->Host = 'localhost';
				$mailer->Port = 587;
				$mailer->SMTPSecure = 'tls';
				$mailer->SMTPAuth = true;
				$mailer->Username="mikemurphytest@gmail.com"; // USERNAME TBD
				$mailer->Password = "4rfvCDE#2wsxZAQ!"; /// PASSWORD TBD
		
				// get content from inputs
				$mailer->Subject = $subject;
				$mailer->Body = $message;
				$mailer->setFrom($fromEmail, $fromName);
				$mailer->addAddress($toEmail, $toName);
				$mailer->addReplyTo($replyEmail, $replyName); // form global
				//$mailer->addAddress("m.p.m@comcast.net", "MPM Tester"); // TO ADDRESS TBD
				//$mailer->addReplyTo("mmurph22@terpmail.umd.edu", "Mike Murphy"); // form global
				$mailer->isHTML(true);
				
				// send and give status
				if (!$mailer->send()) {
					$h = "Mailer Error: " . $mailer->ErrorInfo;
					$m = "Mailer Error: Mail was not sent";
					print ("<h1>$h</h>");
					print ("<pre>$m</pre>");
					
				} else {
					print ("<h1>Mail Sent</h1>");
					print ("<p>Message sent successfully.</p>");
				}
			} catch (Exception $e) {
    			print ('Message could not be sent. Mailer Exception: ' . $mail->ErrorInfo);
			}
		}
	?>
</div>