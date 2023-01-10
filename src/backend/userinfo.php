<?php
include_once('dbconn.php');
include_once('mail.php');

class UserInfo {
    public static function get_profile($id): array
    {
        $dbconn = new dbconn();
        $con = $dbconn->db();

        if($stmt = $con->prepare("SELECT `name`, `surname`, `email`, `auth` FROM `user` WHERE `id` = ?;")) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->store_result();

            if($stmt->num_rows > 0) {
                $user_info = [
                    'name' => '',
                    'surname' => '',
                    'email' => '',
                    'auth' => '',
                ];
                $stmt->bind_result($user_info['name'], $user_info['surname'], $user_info['email'], $user_info['auth']);
                $stmt->fetch();
                return $user_info;
            }
            else {
                return [];
            }
        }
        return [];
    }

    public static function get_accounts($id): array
    {
        $dbconn = new dbconn();
        $con = $dbconn->db();

        if($stmt = $con->prepare('SELECT * FROM `account` WHERE `user_id` = ?;')) {
            $stmt->bind_param('i', $id);
            return self::get_result_arr($stmt);
        }
        return [];
    }

    public static function get_transaction_history($account_id): array
    {
        $dbconn = new dbconn();
        $con = $dbconn->db();
        if($stmt = $con->prepare('SELECT * FROM `transaction_history` WHERE `account_from` = ? OR account_to = ? ORDER BY `date` DESC;')) {
            $stmt->bind_param('ii', $account_id, $account_id);
            return self::get_result_arr($stmt);
        }
        return [];
    }

    public static function get_all_transaction_history(): array
    {
        $dbconn = new dbconn();
        $con = $dbconn->db();
        if($stmt = $con->prepare('SELECT * FROM `transaction_history` ORDER BY `date` DESC;')) {
            return self::get_result_arr($stmt);
        }
        return [];
    }

    public static function get_all_activity_registry(): array
    {
        $dbconn = new dbconn();
        $con = $dbconn->db();
        if($stmt = $con->prepare('SELECT * FROM `activity_registry` ORDER BY `date` DESC;')) {
            return self::get_result_arr($stmt);
        }
        return [];
    }

    public static function send_activity_registry($id, $message, $significance) {
        $dbconn = new dbconn();
        $con = $dbconn->db();
        if($stmt = $con->prepare('INSERT INTO `activity_registry` (`user_id`, `activity`, `significance`, `date`, `ip_client`) VALUES (?, ?, ?, ?, ?);')) {
            $date = date("Y-m-d H:i:s");
            $stmt->bind_param("isiss", $id, $message, $significance, $date, self::get_client_ip());
            $stmt->execute();
        }
    }
    /**
     * @param $stmt
     * @return array
     */
    public static function get_result_arr($stmt): array
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
            return [];
        }

    }

    public static function get_account($account_id): array
    {
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

                $profile_info = self::get_profile($account_info['user_id']);
                $account_info['user_name'] = $profile_info['name'];
                $account_info['user_surname'] = $profile_info['surname'];
                return $account_info;
            }
            else {
                return [];
            }
        }
        return [];
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
    public static function get_relative_account_id($account_id, $user_id): int
    {
        $account_info = self::get_accounts($user_id);
        $i = 0;
        foreach($account_info as $value) {
            if($value[0] == $account_id) {
                return $i;
            }
            else $i++;
        }
        return -1;
    }

    public static function send_auth($id) {
        $user_info = self::get_profile($id);

        $mail = new Mailer();
        $mail->set_recipient($user_info['email'], $user_info['name'] . ' ' . $user_info['surname']);
        $mail->set_subject('Reģistrācijas apstiprināšanas kods');
        $mail->set_content('Zemāk ir norādīts reģistrācijas apstiprinājuma kods. Ievadiet kodu Pro State Bank reģistrācijas apstiprinājuma lapā.</br><span style="color: red;"> ' . self::get_auth($id) . '</span>');

        try {
            $mail->send();
        } catch (\PHPMailer\PHPMailer\Exception $e) {
            echo $e;
        }
    }
    public static function check_auth($id, $auth): bool
    {
        $dbconn = new dbconn();
        $con = $dbconn->db();
        $auth_db = self::get_auth($id);
        if ($auth_db == 0) {
            return true;
        }
        if($auth == $auth_db) {
            if ($stmt = $con->prepare('UPDATE `user` SET `auth` = 0 WHERE `id` = ?;')) {
                $stmt->bind_param('i', $id);
                $stmt->execute();
                $stmt->store_result();
                return true;
            }
        }
        return false;
    }
    public static function get_auth($id): int
    {
        $dbconn = new dbconn();
        $con = $dbconn->db();
        $auth_db = '';
        if ($stmt = $con->prepare('SELECT `auth` FROM `user` WHERE `id` = ?;')) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($auth_db);
            $stmt->fetch();
        }
        return $auth_db;
    }

    // Password restoration functions
    // Sends a new password restoration number everytime a code is requested by user
    public static function send_restore($email) {
        self::create_restore();
        $mail = new Mailer();
        $mail->set_recipient($email, $email);
        $mail->set_subject('Paroles atjaunošanas kods');
        $mail->set_content('Zemāk ir norādīts paroles atjaunošanas kods. Ievadiet kodu Pro State Bank paroles atjaunošanas lapā.</br><span style="color: red;"> ' . $_SESSION['restore_code'] . '</span> Koda darbības laiks ir 5 minūtes.');

        try {
            $mail->send();
        } catch (\PHPMailer\PHPMailer\Exception $e) {
            echo $e;
        }
    }
    public static function check_restore($restore_code): bool {
        if(isset($_SESSION['restore_code'])) {
            if ($restore_code == $_SESSION['restore_code']) {
                unset($_SESSION['restore_code']);
                unset($_SESSION['restore_time']);
                return true;
            }
        }
        return false;
    }
    // Creates a password restoration number and time of creation
    private static function create_restore() {
        $restore = mt_rand(100000, 999999);
        $_SESSION['restore_code'] = $restore;
        $_SESSION['restore_time'] = time();
    }

    private static function get_client_ip() {
        if(!empty($_SERVER['SERVER_ADDR'])) {
            return filter_var($_SERVER['SERVER_ADDR'], FILTER_VALIDATE_IP);
        }
        else return '-';
    }
}


