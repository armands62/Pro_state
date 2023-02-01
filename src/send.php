<?php
include "backend/mail.php";

$mail = new Mailer();
$mail->set_recipient("reebux123@gmail.com", "name");
$mail->set_subject("ziņojums");
$mail->set_content("Jauns ziņojums sakarā ar aizdomīgu maksājumu veikšanu 1000 FISC apmērā.");

try {
    $mail->send();
} catch (\PHPMailer\PHPMailer\Exception $e) {
    echo $e;
}
?>