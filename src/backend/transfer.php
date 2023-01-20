<?php
if(empty($_SESSION['logged'])) {
    header('Location: /login');
    exit();
}
include_once('userinfo.php');
include_once('dbconn.php');
$dbconn = new dbconn();
$con = $dbconn->db();

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


if (!isset($_POST['account-from'], $_POST['account-to'], $_POST['amount'], $_POST['description'])) {
    header('Location: /transfer');
    exit();
}

# Validation
$account_info = UserInfo::get_accounts($_SESSION['id']);
$account_from_info = UserInfo::get_account($_POST['account-from']);

# ACCOUNT (TO)
# - Must be formatted correctly
# - Must be a valid account
# - Mustn't be the same account
if (preg_match('/(LV[0-9]{2}PRST[0-9]{13})/', $_POST['account-to']) == 0 || strlen($_POST['account-to']) != 21) {
    $_SESSION['login_err_msg'] = 'Nepareizi ievadīts saņēmēja konta numurs! Formāts: [LV12 PRST 1234 1234 1234 1]!';
    header('Location: /transfer');
    exit();
}
if ($account_from_info['number'] == $_POST['account-to']) {
    $_SESSION['login_err_msg'] = 'Kontu numuri nedrīkst sakrist!';
    header('Location: /transfer');
    exit();
}
$account_to = 0;
if ($stmt = $con->prepare('SELECT id FROM account WHERE number = ?')) {
    $stmt->bind_param('s', $_POST['account-to']);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows == 0) {
        $_SESSION['login_err_msg'] = 'Saņēmēja konts ar šādu numuru' . $_POST['account-to'] .'neeksistē!';
        header('Location: /transfer');
        exit();
    }
    $stmt->bind_result($account_to); # Assigning identification for later use in query
    $stmt->fetch();
    $stmt->close();
}

# Amount
# - Must be a valid amount (above 0)
# - Must be equal or less than current available funds
# - TODO: Sum of all money transfer amounts must be less than account daily or monthly limit
if ($_POST['amount'] < 0) {
    $_SESSION['login_err_msg'] = 'Nepareizi ievadīts pārskaitījuma daudzums!';
    header('Location: /money_transfer');
    exit();
}

# Available funds check
if($_POST['amount'] > $account_from_info['available']) {
    $_SESSION['login_err_msg'] = 'Nepietiek līdzekļu!';
    header('Location: /money_transfer');
    exit();
}

# Daily limit check
$spent_daily = UserInfo::get_spent_daily($_POST['account-from']);
if($spent_daily + $_POST['amount'] > $account_from_info['daily_limit']) {
    $_SESSION['login_err_msg'] = 'Tiek pārsniegts dienas limits!';
    header('Location: /money_transfer');
    exit();
}

# Monthly limit check
$spent_monthly = UserInfo::get_spent_monthly($_POST['account-from']);

if($spent_monthly + $_POST['amount'] > $account_from_info['monthly_limit']) {
    $_SESSION['login_err_msg'] = 'Tiek pārsniegts mēneša limits!';
    header('Location: /money_transfer');
    exit();
}

# Assigning identification for later use in query
$account_from = $_POST['account-from'];

# Database queries
# - Updating both profile accounts
# - Inserting transfer information into transfer history table


if ($stmt = $con->prepare('UPDATE account SET available = available - ? WHERE id = ?;')) {
    $stmt->bind_param('di', $_POST['amount'], $account_from);
    $stmt->execute();
    $stmt->close();
}

if ($stmt = $con->prepare('UPDATE account SET available = available + ? WHERE id = ?;')) {
    $stmt->bind_param('di', $_POST['amount'], $account_to);
    $stmt->execute();
    $stmt->close();
}

if ($stmt = $con->prepare('INSERT INTO transaction_history (account_from, account_to, amount, description, date) VALUES (?, ?, ?, ?, ?);')) {
    $date = date("Y-m-d H:i:s");
    $stmt->bind_param('iidss', $account_from, $account_to, $_POST['amount'], $_POST['description'], $date);
    $stmt->execute();
    $stmt->close();
    UserInfo::send_activity_registry($_SESSION['id'], 'transaction', 1);
    header('Location: /history');
    exit();
}