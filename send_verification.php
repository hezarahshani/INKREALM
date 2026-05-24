<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function sendVerification($email, $token){

    $mail = new PHPMailer(true);

    try{

        $mail->isSMTP();

        $mail->Host = 'smtp.gmail.com';

        $mail->SMTPAuth = true;

        $mail->Username = 'xyliaawrights@hotmail.com';

        $mail->Password = '#Nasrullah1738';

        $mail->SMTPSecure = 'tls';

        $mail->Port = 587;

        $mail->setFrom(
            'xyliaawrights@hotmail.com',
            'INKREALM'
        );

        $mail->addAddress($email);

        $mail->isHTML(true);

        $mail->Subject =
        'Verify Your INKREALM Account';

        $verify_link =
        "http://localhost/INKREALM/verify.php?token=$token";

        $mail->Body = "

        <h2>Welcome to INKREALM</h2>

        <p>Click below to verify your account:</p>

        <a href='$verify_link'>

        Verify Account

        </a>

        ";

        $mail->send();

        return true;

    }catch(Exception $e){

        return false;
    }
}
?>