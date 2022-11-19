<?php
include_once('dbconn.php');

function get_profile($id) {
    $dbconn = new dbconn();
    $con = $dbconn->db();

    if($stmt = $con->prepare('SELECT `name`, `surname`, `email` FROM `user` WHERE `id` = ?;')) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows > 0) {
            $user_info = [
                'name' => '',
                'surname' => '',
                'email' => '',
            ];
            $stmt->bind_result($user_info['name'], $user_info['surname'], $user_info['email']);
            $stmt->fetch();
            return $user_info;
        }
        else {
            return '';
        }
    }
    return '';
}

function get_accounts($id) {
    $dbconn = new dbconn();
    $con = $dbconn->db();

    if($stmt = $con->prepare('SELECT `number`, `money` FROM `account` WHERE `id` = ?;')) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();

        $con->close();

        if($stmt->num_rows > 0) {
            $account_info = [
                'number' => '',
                'money' => '',
            ];
            $stmt->bind_result($account_info['number'], $account_info['money']);
            $stmt->fetch();
            return $account_info;
        }
        else {
            return '';
        }
    }
    return '';
}