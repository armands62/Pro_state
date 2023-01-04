<?php
if(!isset($_POST['email'])) {
    header('Location: /login');
    exit();
}
include_once('dbconn.php');
include_once('userinfo.php');

# E-mail address
# - Must be in a valid e-mail address format
if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $_SESSION['login_err_msg'] = 'Nepareizi ievadīta e-pasta adrese!';
    header('Location: /restore');
    exit();
}

$dbconn = new dbconn();
$con = $dbconn->db();
if ($stmt = $con->prepare('SELECT `id` FROM `user` WHERE `email` = ?;')) {
    $stmt->bind_param('s', $_POST['email']);
    $stmt->execute();
    $stmt->store_result();
    $id = 0;
    $stmt->bind_result($id);
    $stmt->fetch();

    if ($stmt->num_rows > 0) {
        $_SESSION['id'] = $id;
        $_SESSION['restore'] = true;
        UserInfo::send_restore($_POST['email']);
        header('Location: /input_restore');
    }
    else {
        $_SESSION['login_err_msg'] = 'Profils ar šādu e-pastu neeksistē!';
        header('Location: /restore');
        exit();
    }
}
