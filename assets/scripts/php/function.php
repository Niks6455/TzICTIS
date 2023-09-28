<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once './../../../vendor/phpmailer/phpmailer/src/Exception.php';
require_once './../../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once './../../../vendor/phpmailer/phpmailer/src/SMTP.php';


function send_mail(array $mail_settings, string $to, string $subject, string $body,  $file, $filename)
{
    $mail = new PHPMailer(true);
    try {
        // Настройки SMTP
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->SMTPAuth = $mail_settings['auth'];
        $mail->Host = $mail_settings['host'];
        $mail->Port = $mail_settings['port'];
        $mail->Username = $mail_settings['username'];
        $mail->SMTPSecure = $mail_settings['secure'];
        $mail->Password = $mail_settings['password'];
        $mail->CharSet = $mail_settings['charset'];
        $mail->setFrom($mail_settings['from_email'], $mail_settings['from_name']);
        $mail->addAddress($to,$to);
        $mail->isHTML = $mail_settings['is_html'];
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->addAttachment($file, $filename);

       
        return $mail->send();
    } catch (Exception $e) {
        return false;
    }
}

?>