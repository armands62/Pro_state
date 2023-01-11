<?php
include_once('mail.php');
include_once('dbconn.php');
include_once('userinfo.php');
$dbconn = new dbconn();
$con = $dbconn->db();


if (!isset($_POST['name'], $_POST['surname'], $_POST['birthday'], $_POST['gender'], $_POST['email'], $_POST['password'])) {
    header('Location: /signup');
    exit();
}

# Validation

# E-mail address
# - Must be in a valid e-mail address format
if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $_SESSION['login_err_msg'] = 'Nepareizi ievadīta e-pasta adrese!';
    header('Location: /signup');
    exit();
}

# Name, surname
# - Can only store characters
# - Can't be longer than 60 characters
if(preg_match('/[\p{L}-]+/u', $_POST['name']) == 0 || strlen($_POST['name']) > 60) {
    $_SESSION['login_err_msg'] = 'Nepareizi ievadīts vārds!';
    header('Location: /signup');
    exit();
}
if(preg_match('/[\p{L}-]+/u', $_POST['surname']) == 0 || strlen($_POST['surname']) > 60) {
    $_SESSION['login_err_msg'] = 'Nepareizi ievadīts uzvārds!';
    header('Location: /signup');
    exit();
}

# Password
# - Can't be shorter than 4 characters, can't be longer than 25 characters
# - Regular expressions aren't necessary, since the database receives only the password crypt
if (strlen($_POST['password']) > 25 || strlen($_POST['password']) < 4) {
    $_SESSION['login_err_msg'] = 'Parolei jābūt no 4 līdz 25 simbolu garai!';
    header('Location: /signup');
    exit();
}

# Birthday
# - Must be 18 years old
# - TODO: Can't be more than 120 years old
if (time() < strtotime('+18 years', strtotime($_POST['birthday']))) {
    $_SESSION['login_err_msg'] = 'Jums nav 18 gadu!';
    header('Location: /signup');
    exit();
}

# Social number
# - Must contain numbers only
# - First field must contain 6 numbers, second field - 5 numbers
# - First field must match a valid date
# - First field must match the given birthday
if(preg_match('/[0-9]+/', $_POST['soc-num-first']) == 0 || strlen($_POST['soc-num-first']) != 6) {
    $_SESSION['login_err_msg'] = 'Nepareizi ievadīta personas koda 1 daļa!';
    header('Location: /signup');
    exit();
}
if(preg_match('/[0-9]+/', $_POST['soc-num-last']) == 0 || strlen($_POST['soc-num-last']) != 5) {
    $_SESSION['login_err_msg'] = 'Nepareizi ievadīta personas koda 2 daļa!';
    header('Location: /signup');
    exit();
}

$date = substr($_POST['soc-num-first'], 0, 2);
$month = substr($_POST['soc-num-first'], 2, 2);
$year = substr($_POST['soc-num-first'], 4, 2);
$century = substr($_POST['birthday'], 0, 2);
$sn_date = $century . $year . '-' . $month . '-' . $date;

if($sn_date != $_POST['birthday']) {
    $_SESSION['login_err_msg'] = 'Ievadītā personas koda pirmā daļa nesakrīt ar dzimšanas dienu!';
    header('Location: /signup');
    exit();
}

# Database queries
# - Checking if profile with the entered email already exists
# - Inserting values into the database
if($stmt = $con->prepare('SELECT `id` FROM `user` WHERE `email` = ? OR `social_number` = ?;')) {
    $social_number = $_POST['soc-num-first'] . '-' . $_POST['soc-num-last'];
    $stmt->bind_param('ss', $_POST['email'], $social_number);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['login_err_msg'] = 'Lietotājs ar šādu e-pasta adresi vai personas kodu jau ir reģistrēts!';
        header('Location: /signup');
        exit();
    }


    mysqli_report(MYSQLI_REPORT_ALL);
    // Creating auth code
    $auth = mt_rand(100000, 999999);

    if ($stmt = $con->prepare('INSERT INTO `user` (`name`, `surname`, `email`, `password`, `social_number`, `birth_date`, `gender`, `auth`) VALUES (?, ?, ?, ?, ?, ?, ?, ?);')) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $birthday = date('Y-m-d', strtotime($_POST['birthday']));
        $stmt->bind_param('sssssssi', $_POST['name'], $_POST['surname'], $_POST['email'], $password, $social_number, $birthday, $_POST['gender'], $auth);
        $stmt->execute();

        // To get new user ID
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        if ($stmt = $con->prepare('SELECT `id` FROM `user` WHERE `email` = ?;')) {
            $stmt->bind_param('s', $_POST['email']);
            $stmt->execute();
            $stmt->store_result();
            $id = 0;
            $stmt->bind_result($id);
            $stmt->fetch();

            // Mailing
            UserInfo::send_auth($id);

            // Starting new session
            session_regenerate_id();
            $_SESSION['logged'] = true;
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['id'] = $id;
            $_SESSION['auth'] = $auth;
            $_SESSION['last_activity'] = time();
            UserInfo::send_activity_registry($id, 'register', 2);
            header('Location: /profile');
            exit();
        }
        header('Location: /login');
        $stmt->close();
        exit();
    }
}