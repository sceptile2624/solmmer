<?php
$string = htmlentities($string, ENT_QUOTES,'UTF-8');
	$correo = $_POST['correo'];
	if ($correo=="") {
		header ("location: http://www.google.com");
	} else {
	$sendTo = "contacto@bamobel.com";
	$subject = "Suscrito bamobel.com";

	$headers = "From: Web<" . $correo .">\r\n";
	$headers .= "Reply-To: " . $correo . "\r\n";
	$headers .= "Return-path: " . $correo;
    $header .= "Content-Type: text/plain; charset=UTF-8";  
	$message = $message = utf8_decode ( 
	"Correo: ".$correo."\n");
	
  
	mail( $sendTo, $subject, $message, $headers );
	header ("location: http://www.bamobel.com/thank-you-page.html");
	}


?>
