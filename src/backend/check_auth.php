<?php
include_once('sendauth.php');
if ($_POST['auth'] < 100000 || $_POST['auth'] > 999999) {
    return;
}
if(Authorization::check_auth($_SESSION['id'], $_POST['auth'])) {
    $_SESSION['auth'] = 0;
    header('Location: /profile');
    exit();
} else {
    header('Location: /authorize');
}