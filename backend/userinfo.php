<?php
include_once('dbconn.php');

function get_profile($id) {
    $dbconn = new dbconn();
    $con = $dbconn->db();

    if($stmt = $con->prepare("SELECT `name`, `surname`, `email` FROM `user` WHERE `id` = ?;")) {
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
        return get_result_arr($stmt);
    }
    return '';
}

function get_transaction_history($account_id) {
    $dbconn = new dbconn();
    $con = $dbconn->db();
    if($stmt = $con->prepare('SELECT * FROM `transaction_history` WHERE `account_from` = ? OR account_to = ?;')) {
        $stmt->bind_param('ii', $account_id, $account_id);
        return get_result_arr($stmt);
    }
    return '';
}

/**
 * @param $stmt
 * @return array|string
 */
function get_result_arr($stmt)
{
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $transaction_info = [];
        $i = 0;
        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            $transaction_info[$i] = $row;
            $i++;
        }
        return $transaction_info;
    } else {
        return '';
    }

}

function get_account($account_id) {
    $dbconn = new dbconn();
    $con = $dbconn->db();

    if($stmt = $con->prepare('SELECT `number`, `name`, `user_id`, `daily_limit`, `monthly_limit` FROM `account` WHERE `id` = ?;')) {
        $stmt->bind_param('i', $account_id);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows > 0) {
            $account_info = [
                'number' => '',
                'name' => '',
                'user_id' => 0,
                'user_name' => '',
                'user_surname' => '',
                'daily_limit' => 0,
                'monthly_limit' => 0,
            ];
            $stmt->bind_result($account_info['number'], $account_info['name'], $account_info['user_id'], $account_info['daily_limit'], $account_info['monthly_limit']);
            $stmt->fetch();

            $profile_info = get_profile($account_info['user_id']);
            $account_info['user_name'] = $profile_info['name'];
            $account_info['user_surname'] = $profile_info['surname'];
            return $account_info;
        }
        else {
            return '';
        }
    }
    return '';
}

/**
 * Used to receive the relative account identification of a user
 * This is necessary for the transaction table, as only relative id is requested
 * @param $account_id
 * Account identification
 * @param $user_id
 * User identification
 * @return int Relative account identification
 */
function get_relative_account_id($account_id, $user_id)
{
    $account_info = get_accounts($user_id);
    $i = 0;
    foreach($account_info as $value) {
        if($value[0] == $account_id) {
            return $i;
        }
        else $i++;
    }
    return -1;
}
