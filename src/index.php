<?php
session_start();
$request_method = $_SERVER['REQUEST_METHOD'];
$requested_url = $_SERVER['REQUEST_URI'];
$requested_url = strtok($requested_url, '?');

if ($request_method == 'POST') {
    process_post_request($requested_url);
} else {
    // Routing for all pages where the user must be logged in
    if ($requested_url == '/profile' || $requested_url == '/accounts' || $requested_url == '/money_transfer'
        || $requested_url == '/view_account' || $requested_url == '/history' || $requested_url == '/logout'
        || $requested_url == '/edit_profile' || $requested_url == '/add_account' || $requested_url == '/edit_account') {
        if (is_logged()) {
            switch ($requested_url) {
                case '/profile':
                    include 'profile.php';
                    break;
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
                case '/logout':
                    include 'backend/logout.php';
                    break;
                case '/edit_profile':
                    include 'edit_profile.php';
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
        default:
            echo('POST');
            include '404.php';
            break;
    }
}

function is_logged(): bool
{
    if(!empty($_SESSION["logged"])) {
        return true;
    }
    return false;
}
