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

    if($stmt = $con->prepare('SELECT * FROM `account` WHERE `user_id` = ?;')) {
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();
        if($result->num_rows > 0) {
            $account_info = [];
            $i = 0;
            while ($row = $result->fetch_array(MYSQLI_NUM)) {
                $account_info[$i] = $row;
                $i++;
            }
            return $account_info;
        }
        else {
            return '';
        }
    }
    return '';
}