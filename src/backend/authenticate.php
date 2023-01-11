<?php
session_start();
include_once('dbconn.php');
include_once('userinfo.php');
$dbconn = new dbconn();
$con = $dbconn->db();

if(!isset($_POST['email'], $_POST['password'])) {
    header('Location: /login');
    exit();
}

# E-mail address
# - Must be in a valid e-mail address format
if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $_SESSION['login_err_msg'] = 'Nepareizi ievadīta e-pasta adrese!';
    header('Location: /login');
    exit();
}

mysqli_report(MYSQLI_REPORT_STRICT);
if($stmt = $con->prepare('SELECT `id`, `password`, `admin` FROM `user` WHERE `email` = ?;')) {
    $stmt->bind_param('s', $_POST['email']);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows > 0){
        $id = 0;
        $password = '';
        $admin = 0;
        $stmt->bind_result($id, $password, $admin);
        $stmt->fetch();

        if(password_verify($_POST['password'], $password)) {
            session_regenerate_id();
            $_SESSION['logged'] = true;
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['id'] = $id;
            $_SESSION['auth'] = UserInfo::get_auth($id);
            $_SESSION['last_activity'] = time();
            $_SESSION['admin'] = $admin;
            UserInfo::send_activity_registry($id, 'login', 1);
            header('Location: /');
        }
        else {
            $_SESSION['login_err_msg'] = 'Nepareiza e-pasta adrese vai parole!';
            header('Location: /login');
            exit();
        }
    }
    else {
        $_SESSION['login_err_msg'] = 'Nepareiza e-pasta adrese vai parole!';
        header('Location: /login');
        exit();
    }

    $stmt->close();
}
else {
    exit();
}