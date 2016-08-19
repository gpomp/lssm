<?php
require $_SERVER["DOCUMENT_ROOT"]."/../vendor/phpmailer/phpmailer/PHPMailerAutoload.php";

$mail = new PHPMailer;

$mail->SMTPDebug = 0;
$mail->Debugoutput = "html";

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->SMTPSecure = "tls";                            // Enable TLS encryption, `ssl` also accepted
$mail->Host = "smtp.gmail.com";  // Specify main and backup SMTP servers
$mail->Port = 587;                                    // TCP port to connect to
$mail->Username = "lessoeurs.senmelent@gmail.com";    // SMTP username
$mail->Password = "8636entreprise";                      // SMTP password
$mail->setFrom("lessoeurs.senmelent@gmail.com", "Les soeurs s'en mèlent");
