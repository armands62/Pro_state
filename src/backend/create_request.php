<?php
include_once('dbconn.php');
include_once('userinfo.php');
$dbconn = new dbconn();
$con = $dbconn->db();

if(!isset($_POST['title'], $_POST['description'])) {
    header('Location: /login');
    exit();
}

# Title
# - Must contain only letters and numbers
if(preg_match('/[\p{L}\p{N} ]+/u', $_POST['title']) == 0) {
    $_SESSION['login_err_msg'] = 'Virsrakstam jāsastāv tikai no burtiem un cipariem!';
    header('Location: /request');
    exit();
}

# - Mustn't contain more than 60 characters
if(strlen($_POST['title']) > 60) {
    $_SESSION['login_err_msg'] = 'Virsraksts nevar būt garāks par 60 simboliem!';
    header('Location: /request');
    exit();
}

# Description
# - Mustn't contain more than 1200 characters
if(strlen($_POST['description']) > 1200) {
    $_SESSION['login_err_msg'] = 'Apraksts nevar būt garāks par 1200 simboliem!';
    header('Location: /request');
    exit();
}

if($stmt = $con->prepare('INSERT INTO `request` (`user_id`, `title`, `description`, `date`) VALUES (?, ?, ?, ?);')) {
    $date = date("Y-m-d H:i:s");
    $stmt->bind_param('isss', $_SESSION['id'], $_POST['title'], $_POST['description'], $date);
    $stmt->execute();
}
UserInfo::send_activity_registry($_SESSION['id'], 'create_request', 2);
header('Location: /home');
$stmt->close();