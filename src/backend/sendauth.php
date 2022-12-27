<?php
include_once('mail.php');
include_once('dbconn.php');
include_once('userinfo.php');

class Authorization {
    public static function send_auth($id) {
        $user_info = get_profile($id);

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
    public static function check_auth($id, $auth)
    {
        $dbconn = new dbconn();
        $con = $dbconn->db();
        $auth_db = self::get_auth($id);
        if ($auth_db == 0) {
            return;
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
    public static function get_auth($id)
    {
        $dbconn = new dbconn();
        $con = $dbconn->db();
        if ($stmt = $con->prepare('SELECT `auth` FROM `user` WHERE `id` = ?;')) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->store_result();
            $auth_db = '';
            $stmt->bind_result($auth_db);
            $stmt->fetch();
            return $auth_db;
        }
    }
}
