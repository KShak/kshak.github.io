<?php
	if (!isset($_POST['submit'])) {
		//This page should not be accessed directly. Need to submit the form.
		echo "Error; you need to submit the form!";
	}
	function IsInjected($str) {
    	$injections = array('(\n+)',
           '(\r+)',
           '(\t+)',
           '(%0A+)',
           '(%0D+)',
           '(%08+)',
           '(%09+)'
           );       
    	$inject = join('|', $injections);
    	$inject = "/$inject/i";    
    	if(preg_match($inject,$str)){
      		return true;   		}
    		else    	{
      		return false;
   		 }
	}
	header('Location: ../sent.html');
	require('PHPMailer/PHPMailerAutoload.php');
	$mail=new PHPMailer();
	$mail->CharSet = 'UTF-8';
	$name = $_POST['name'];
	$association = $_POST['assoc'];
	$visitor_email = $_POST['email'];
	$mess = $_POST['message'];
	$body = "Message - $mess from $name with $association (Email - $visitor_email)";
	if(IsInjected($visitor_email)){
    	echo "Bad email value!";
    	exit();
	}
	if (empty($name) || empty($visitor_email)) {
		header('Location: ../contact_me.html');
		echo "Name and email are required!";
		exit();
	}
	$mail->IsSMTP();
	$mail->Host       = 'localhost';
	$mail->SMTPSecure = 'tls';
	$mail->Port       = 25;
	$mail->SMTPDebug  = 1;
	$mail->SMTPAuth   = true;
	$mail->Username   = 'contactme@james-lee.io';
	$mail->Password   = 'nx%ty-(!]17-';
	$mail->SetFrom('contactme@james-lee.io', 'Website - Contact Me');
	$mail->AddReplyTo('no-reply@james-lee.io','no-reply');
	$mail->Subject    = "$name contacted you through james-lee.io";
	$mail->MsgHTML($body);
	$mail->AddAddress('james.lee.fall16@gmail.com', 'Khalid Shakur');
	$mail->AddAddress('khalidshakur@berkeley.edu', 'Khalid Shakur (Berkeley)');
	$mail->send();
	exit();
?>
