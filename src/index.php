<?php
session_start();

// Session expiration check
if (isset($_SESSION['last_activity'])) {
    if (time() - $_SESSION['last_activity'] > 1200) {
        header('Location: /logout');
    } else {
        $_SESSION['last_activity'] = time();
        echo '<script type="text/javascript" src="/src/js/session_expire.js"></script>';
    }
}

// Password restoration code expiration check
if (isset($_SESSION['restore_time'])) {
    if(time() - $_SESSION['restore_time'] > 300) {
        unset($_SESSION['restore_code']);
        unset($_SESSION['restore_time']);
    }
}

$request_method = $_SERVER['REQUEST_METHOD'];
$requested_url = $_SERVER['REQUEST_URI'];
$requested_url = strtok($requested_url, '?');

$login_urls = ['/profile', '/accounts', '/money_transfer', '/view_account', '/history', '/logout', '/edit_profile', '/add_account', '/edit_account', '/authorize', '/send_auth'];
$admin_urls = ['/admin', '/admin_registry', '/admin_requests', '/admin_history', '/admin_view_profile', '/admin_view_account'];

if ($request_method == 'POST') {
    process_post_request($requested_url);
} else {
    // Routing for all pages where the user must have admin privileges
    if(in_array($requested_url, $admin_urls)) {
        if(!isset($_SESSION['admin'])) {
            header('Location: /home');
            exit();
        }
        if($_SESSION['admin'] < 1) {
            header('Location: /home');
            exit();
        }
        switch ($requested_url) {
            case '/admin':
                include('admin/home.php');
                break;
            case '/admin_requests':
                include('admin/requests.php');
                break;
            case '/admin_registry':
                if($_SESSION['admin'] >= 3) {
                    include('admin/registry.php');
                } else {
                    $_SESSION['err_msg'] = 'Nepietiekams administratora līmenis! Lai piekļūtu reģistram, ir nepieciešams vismaz 3 administratora līmenis!';
                    include('admin/home.php');
                }
                break;
            case '/admin_history':
                if($_SESSION['admin'] >= 2) {
                include('admin/history.php');
                } else {
                    $_SESSION['err_msg'] = 'Nepietiekams administratora līmenis! Lai piekļūtu lietotāju maksājumu vēsturei, ir nepieciešams vismaz 2 administratora līmenis!';
                    include('admin/home.php');
                }
                break;
            case '/admin_view_profile':
                if($_SESSION['admin'] >= 2) {
                    include('admin/admin_view_profile.php');
                } else {
                    $_SESSION['err_msg'] = 'Nepietiekams administratora līmenis! Lai piekļūtu lietotāju maksājumu vēsturei, ir nepieciešams vismaz 2 administratora līmenis!';
                    include('admin/home.php');
                }
                break;
            case '/admin_view_account':
                if($_SESSION['admin'] >= 2) {
                    include('admin/admin_view_account.php');
                } else {
                    $_SESSION['err_msg'] = 'Nepietiekams administratora līmenis! Lai piekļūtu lietotāju maksājumu vēsturei, ir nepieciešams vismaz 2 administratora līmenis!';
                    include('admin/home.php');
                }
                break;
            default:
                include('404.php');
                break;
        }
        exit();
    }

    // Routing for all pages where the user must be logged in
    if (in_array($requested_url, $login_urls)) {
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
        } else {
            header('Location: /login');
        }
        exit();
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
        case '/restore':
            include 'restore.php';
            break;
        case '/input_restore':
            if(!isset($_SESSION['logged'])) {
                if(!isset($_SESSION['restore'])) {
                    header('Location: /login');
                    exit();
                }
            }
            include 'input_restore.php';
            break;
        case '/change_password':
            if(!isset($_SESSION['logged'])) {
                if(!isset($_SESSION['restore'])) {
                    header('Location: /login');
                    exit();
                }
                if(!isset($_SESSION['restore_correct'])) {
                    header('Location: /login');
                    exit();
                }
            }
            include 'change_password.php';
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
        case '/send_restore':
            include 'backend/send_restore.php';
            break;
        case '/check_restore':
            if(!isset($_SESSION['logged'])) {
                if(!isset($_SESSION['restore'])) {
                    header('Location: /login');
                    exit();
                }
            }
            include 'backend/check_restore.php';
            break;
        case '/update_password':
            if(!isset($_SESSION['logged'])) {
                if(!isset($_SESSION['restore'])) {
                    header('Location: /login');
                    exit();
                }
                if(!isset($_SESSION['restore_correct'])) {
                    header('Location: /login');
                    exit();
                }
            }
            include 'backend/update_password.php';
            break;
        default:
            echo('POST');
            include '404.php';
            break;
    }
}

