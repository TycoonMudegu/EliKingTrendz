<?php

include 'app/emails/templates/orderconfirmed.php';
include 'app/emails/templates/orderdeclined.php';
include 'app/emails/templates/verificationemail.php';
include 'app/emails/templates/welcomeemail.php';





// Include PHPMailer autoload file
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';
require 'vendor/phpmailer/phpmailer/src/Exception.php'; // Make sure to include this line


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;




function sendEmail($email, $subject, $body) {
    // ... (Logic for sending the email, setting Content-Type based on $isHtml)

    require 'vendor/autoload.php';


    // Create a new PHPMailer instance
    $mail = new PHPMailer(true); // Enable exceptions
    $mail->SMTPDebug = SMTP::DEBUG_OFF; // Enable verbose debug output
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
    $mail->Port = 465; // TCP port to connect to for SSL
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable SSL encryption
    $mail->Username = 'tycoonmudegu1@gmail.com';
    $mail->Password = 'pxem ykun mulq rzge';

    // Set additional headers
    $mail->setFrom('tycoonmudegu1@gmail.com', 'Apple Junction'); // Set sender of the email
    // $mail->addAddress('tycoonmudegu@gmail.com', 'Tycoon'); // Add a recipient
    $mail->addCustomHeader('MIME-Version', '1.0');
    $mail->addCustomHeader('Content-type', 'text/html;charset=UTF-8');

    // Add a recipient
    $mail->addAddress($email,);
    // Set email subject
    $mail->Subject = $subject;
    // Set email body
    $mail->Body = $body;

    $mail->send();

    // // Send the email
    // if (!$mail->send()) {
    //     echo 'Mailer Error: ' . $mail->ErrorInfo;
    // } else {
    //     echo 'Message sent successfully!';
    // }
}


function  SendDeclinedEmail($email, $username) {
    global $OrderDeclined;
    $subject = "Order Declined, $username!";
    $body = str_replace('{{userName}}', $username, $OrderDeclined);;
    sendEmail($email, $subject, $body); 
}

function sendVerificationEmail($email, $verificationCode){
    global $VerificationEmail;
    $subject = "Verify Your Apple Junction Account";
    $body = str_replace('{{verificationCode}}', $verificationCode, $VerificationEmail);
    sendEmail($email, $subject, $body);
}

function sendRegistrationEmail($email, $username){
    global $WelcomeEmail;
    $subject = "Welcome to Apple Junction";
    $body = str_replace('{{username}}', $username, $WelcomeEmail);
    sendEmail($email, $subject, $body);
}