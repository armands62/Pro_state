<?php
session_start();
if (isset($_SESSION['last_activity'])) {
    if (time() - $_SESSION['last_activity'] > 1200) {
        header('Location: /logout');
    } else {
        $_SESSION['last_activity'] = time();
        echo '<script type="text/javascript" src="/src/js/session_expire.js"></script>';
    }
}
$request_method = $_SERVER['REQUEST_METHOD'];
$requested_url = $_SERVER['REQUEST_URI'];
$requested_url = strtok($requested_url, '?');

if ($request_method == 'POST') {
    process_post_request($requested_url);
} else {
    // Routing for all pages where the user must be logged in
    if ($requested_url == '/profile' || $requested_url == '/accounts' || $requested_url == '/money_transfer'
        || $requested_url == '/view_account' || $requested_url == '/history' || $requested_url == '/logout'
        || $requested_url == '/edit_profile' || $requested_url == '/add_account' || $requested_url == '/edit_account'
        || $requested_url == '/authorize' || $requested_url == '/send_auth') {
        if (!empty($_SESSION["logged"])) {

            // Links with larger priorities
            if ($requested_url == '/profile') {
                include 'profile.php';
                exit();
            }
            if($requested_url == '/logout') {
                include 'backend/logout.php';
                exit();
            }
            if($requested_url == '/edit_profile') {
                include 'edit_profile.php';
                exit();
            }
            if($requested_url == '/send_auth') {
                include 'backend/send_auth.php';
                exit();
            }
            if($requested_url == '/authorize') {
                include 'authorize.php';
                exit();
            }
            if ($_SESSION['auth'] != 0) {
                $_SESSION['login_err_msg'] = 'Lai piekļūtu šai lapai, ir nepieciešams aktivizēt kontu! Pārbaudiet savu e-pastu!';
                include 'authorize.php';
                exit();
            }

            // Regular logged in links
            switch ($requested_url) {
                case '/accounts':
                    include 'accounts.php';
                    break;
                case '/money_transfer':
                    include 'money_transfer.php';
                    break;
                case '/view_account':
                    include 'view_account.php';
                    break;
                case '/history':
                    include 'history.php';
                    break;
                case '/add_account':
                    include 'add_account.php';
                    break;
                case '/edit_account':
                    include 'edit_account.php';
                    break;
                default:
                    include 'home.php';
            }
            exit();
        } else {
            header('Location: /login');
            exit();
        }
    }
    // Common page routes
    switch ($requested_url) {
        case '/home':
            include 'home.php';
            break;
        case '/login':
            include 'login.php';
            break;
        case '/signup':
            include 'signup.php';
            break;
        case '/fiscles':
            include 'fiscles.php';
            break;
        default:
            include '404.php';
    }
    exit();
}

// Routing with POST request
function process_post_request($requested_url) {
    $form_data = $_POST;
    switch ($requested_url) {
        case '/authenticate':
            include 'backend/authenticate.php';
            break;
        case '/register':
            include 'backend/register.php';
            break;
        case '/signup':
            include 'signup.php';
            break;
        case '/account_table':
            include 'blocks/account_table.php';
            break;
        case '/transaction_table':
            include 'blocks/transaction_table.php';
            break;
        case '/update_account':
            include 'backend/update_account.php';
            break;
        case '/update_profile':
            include 'backend/update_profile.php';
            break;
        case '/create_account':
            include 'backend/create_account.php';
            break;
        case '/transfer':
            include 'backend/transfer.php';
            break;
        case '/check_auth':
            include 'backend/check_auth.php';
            break;
        default:
            echo('POST');
            include '404.php';
            break;
    }
}

