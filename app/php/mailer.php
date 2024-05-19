<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require_once getRoot() . "/vendor/autoload.php";

function sendMail($mailInfo, $isHtml = false)
{
    $output = "";

    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();

        // config
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = "zaidpatel121121@gmail.com";
        $mail->Password = '';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom("zaidpatel121121@gmail.com", "MyCloud");
        $mail->addAddress($mailInfo['to'], $mailInfo['toName'] ?? '');

        // Content
        $mail->isHTML($isHtml);
        $mail->Subject = $mailInfo['sub'];
        $mail->Body = $mailInfo['msg'];

        // send mail
        $mail->send();
        $output = "success";
    } catch (Exception $e) {
        $output = $e->getMessage();
    }

    return $output;
}
