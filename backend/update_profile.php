<?php
session_start();
include_once('dbconn.php');
$dbconn = new dbconn();
$con = $dbconn->db();

if (!isset($_POST['name'], $_POST['surname'], $_POST['email'])) {
    header("Location: ../profile.php");
    exit();
}

# Validation

# E-mail address
# - Must be in a valid e-mail address format
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $_SESSION['login_err_msg'] = 'Nepareizi ievadīta e-pasta adrese!';
    header('Location: ../update_profile.php');
    exit();
}

# Name, surname
# - Can only store characters
# - Can't be longer than 60 characters
if (preg_match('/[\p{L}-]+/u', $_POST['name']) == 0 || strlen($_POST['name']) > 60) {
    $_SESSION['login_err_msg'] = 'Nepareizi ievadīts vārds!';
    header('Location: ../update_profile.php');
    exit();
}
if (preg_match('/[\p{L}-]+/u', $_POST['surname']) == 0 || strlen($_POST['surname']) > 60) {
    $_SESSION['login_err_msg'] = 'Nepareizi ievadīts uzvārds!';
    header('Location: ../update_profile.php');
    exit();
}

# Database queries
# - Checking if profile with the entered email already exists
# - Inserting values into the database

if($stmt = $con->prepare('SELECT `id` FROM `user` WHERE `email` = ?;')) {
    $stmt->bind_param('s', $_POST['email']);
    $stmt->execute();
    $stmt->store_result();

    $id = 0;
    $stmt->bind_result($id);
    $stmt->fetch();
    if ($stmt->num_rows > 0 && $id != $_SESSION['id']) {
        $_SESSION['login_err_msg'] = 'Lietotājs ar šādu e-pasta adresi jau ir reģistrēts!';
        header('Location: ../edit_profile.php');
        exit();
    }
    if ($stmt = $con->prepare("UPDATE `user` SET `name`= ?,`surname`= ?,`email`= ? WHERE `id` = ?")) {
        $stmt->bind_param('sssi', $_POST['name'], $_POST['surname'], $_POST['email'], $_SESSION['id']);
        $stmt->execute();
    }
    header('Location: ../profile.php');
    $stmt->close();
    exit();
}
