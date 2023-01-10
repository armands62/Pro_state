<?php
include_once('./backend/mail.php');
include_once('./backend/userinfo.php');
$request = UserInfo::get_request($_GET['id']);
$profile = UserInfo::get_profile($request['user_id']);
$admin_profile = UserInfo::get_profile($_SESSION['id']);
$mail = new Mailer();
$mail->set_recipient($profile['email'], $profile['email']);
$mail->set_subject('Atbilde uz ziņojumu: ' . $request['title']);
$mail->set_content('Administrators ' . $admin_profile['name'] . ' ' . $admin_profile['surname'] . ' ir atbildējis uz jūsu ziņojumu: ' . $_POST['answer']);

try {
    $mail->send();
} catch (\PHPMailer\PHPMailer\Exception $e) {
    echo $e . " phpmailewtf";
}

header('Location: /delete_request?id=' . $request['id']);
exit();
