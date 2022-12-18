<?php
session_start();
include_once('dbconn.php');
$dbconn = new dbconn();
$con = $dbconn->db();

if(!isset($_POST['name'], $_POST['daily-limit'], $_POST['monthly-limit'])) {
    header("Location: /edit_account?id={$_GET['id']}");
    exit();
}

# Validation

# Account name
# - Must contain only letters and numbers
if(preg_match('/[\p{L}\p{N} ]+/u', $_POST['name']) == 0 || strlen($_POST['name']) > 60) {
    $_SESSION['login_err_msg'] = 'Nepareizi ievadīts konta nosaukums!';
    header("Location: /edit_account?id={$_GET['id']}");
    exit();
}
# Limits
# - Daily limit must be between 10 and 300
# - Monthly limit must be between 100 and 5000
if($_POST['daily-limit'] < 10 || $_POST['daily-limit'] > 300 || $_POST['monthly-limit'] < 100 || $_POST['monthly-limit'] > 5000) {
    $_SESSION['login_err_msg'] = 'Nepareizi ievadīti konta limiti!';
    header("Location: /edit_account?id={$_GET['id']}");
    exit();
}

# Database queries
# - Checking if profile with the entered email already exists
# - Inserting values into the database

mysqli_report(MYSQLI_REPORT_ALL);
if ($stmt = $con->prepare("UPDATE `account` SET `name`= ?,`daily_limit`= ?,`monthly_limit`= ? WHERE `id` = ?")) {
    $stmt->bind_param('sssi', $_POST['name'], $_POST['daily-limit'], $_POST['monthly-limit'], $_GET['id']);
    $stmt->execute();
}
header("Location: /view_account?id={$_GET['id']}");
$stmt->close();
exit();
