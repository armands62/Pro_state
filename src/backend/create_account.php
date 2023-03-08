<?php
include_once('dbconn.php');
include_once('userinfo.php');
$dbconn = new dbconn();
$con = $dbconn->db();

if(!isset($_POST['name'])) {
    header('Location: /login');
    exit();
}

# Account name
# - Must contain only letters and numbers
if(preg_match('/[\p{L}\p{N} ]+/u', $_POST['name']) == 0 || strlen($_POST['name']) > 60) {
    $_SESSION['login_err_msg'] = 'Nepareizi ievadīts konta nosaukums!';
    header('Location: /add_account');
    exit();
}
# Limits
# - Daily limit must be between 10 and 300
# - Monthly limit must be between 100 and 5000
if($_POST['daily-limit'] < 10 || $_POST['daily-limit'] > 300 || $_POST['monthly-limit'] < 100 || $_POST['monthly-limit'] > 5000) {
    $_SESSION['login_err_msg'] = 'Nepareizi ievadīti konta limiti!';
    header('Location: /add_account');
    exit();
}

mysqli_report(MYSQLI_REPORT_STRICT);
if($stmt = $con->prepare('SELECT `id` FROM `account` WHERE `name` = ? AND `user_id` = ?;')) {
    $stmt->bind_param('ss', $_POST['name'], $_SESSION['id']);
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows == 0){
        if($stmt = $con->prepare('INSERT INTO `account` (`number`, `name`, `user_id`, `available`, `reserved`, `daily_limit`, `monthly_limit`) VALUES (?, ?, ?, 300, 0, ?, ?);')) {
            $number = generate_account_number($con);
            $stmt->bind_param('ssiii', $number, $_POST['name'], $_SESSION['id'], $_POST['daily-limit'], $_POST['monthly-limit']);
            $stmt->execute();
        }
        UserInfo::send_activity_registry($_SESSION['id'], 'create_account', 2);
        header('Location: /accounts');
        $stmt->close();
    }
    else {
        $_SESSION['login_err_msg'] = 'Jums jau ir konts ar šādu nosaukumu!';
        header('Location: /add_account');
        exit();
    }
    $stmt->close();
}
else {
    exit();
}

function generate_account_number($con) {
    $number = 'LV';
    $number .= mt_rand(10, 99) . 'PRST';
    for($i = 0; $i < 13; $i++) {
        $number .= mt_rand(0, 9);
    }
    if($stmt = $con->prepare('SELECT `id` FROM `account` WHERE `number` = ?;')) {
        $stmt->bind_param('s', $number);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
            return $number;
        }
        else {
            return generate_account_number($con);
        }
    }
    exit();
}