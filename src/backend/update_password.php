<?php
include_once('dbconn.php');

$logged = false;

if(!isset($_SESSION['restore'])) {
    if(!isset($_SESSION['logged'])) {
        header('Location: /login');
        exit();
    }
    $logged = true;
}
if (!isset($_POST['password'], $_POST['password_repeat'])) {
    header('Location: /change_password');
    exit();
}

if (strlen($_POST['password']) > 25 || strlen($_POST['password']) < 4 ||
    strlen($_POST['password_repeat']) > 25 || strlen($_POST['password_repeat']) < 4) {
    $_SESSION['login_err_msg'] = 'Parolei jābūt no 4 līdz 25 simbolu garai!';
    header('Location: /change_password');
    exit();
}

if ($_POST['password'] != $_POST['password_repeat']) {
    $_SESSION['login_err_msg'] = 'Paroles nesakrīt!';
    header('Location: /change_password');
    exit();
}

$dbconn = new dbconn();
$con = $dbconn->db();

// Check if old password matches for logged users
if($logged) {
    if($stmt = $con->prepare('SELECT `password` FROM `user` WHERE `id` = ?;')) {
        $stmt->bind_param('i', $_SESSION['id']);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $id = 0;
            $password = '';
            $stmt->bind_result($password);
            $stmt->fetch();

            if (!password_verify($_POST['password_old'], $password)) {
                $_SESSION['login_err_msg'] = 'Pašreizējā parole ievadīta nepareizi!';
                header('Location: /change_password');
                exit();
            }
        }
        else {
            $_SESSION['login_err_msg'] = 'Sistēmas kļūda!';
            header('Location: /change_password');
            exit();
        }
    }
    else {
        $_SESSION['login_err_msg'] = 'Datu bāzes kļūda!';
        header('Location: /change_password');
        exit();
    }
}

if ($stmt = $con->prepare("UPDATE `user` SET `password`= ? WHERE `id` = ?")) {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt->bind_param('si', $password, $_SESSION['id']);
    $stmt->execute();
}

if($_SESSION['restore']) {
    header("Location: /login");
    unset($_SESSION['restore']);
}
else if ($_SESSION['logged']) {
    header("Location: /profile");
}
$stmt->close();
exit();