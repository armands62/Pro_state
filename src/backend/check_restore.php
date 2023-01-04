<?php
include_once('userinfo.php');
if ($_POST['code'] < 100000 || $_POST['auth'] > 999999) {
    $_SESSION['login_err_msg'] = 'Nepareizi ievadīts kods! Kodam jāsastāv no 6 cipariem!';
    header('Location: /input_restore');
    exit();
}
if(UserInfo::check_restore($_POST['code'])) {
    $_SESSION['restore_correct'] = true;
    header('Location: /change_password');
    exit();
} else {
    $_SESSION['login_err_msg'] = 'Kods ir nepareizs vai ir beidzies tā derīguma termiņš!';
    header('Location: /input_restore');
}