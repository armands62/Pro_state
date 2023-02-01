<?php
include_once("blocks/header.phtml");
if(empty($_SESSION['logged']) || empty($_GET['id'])) {
    header("Location: /login");
    exit();
}
?>
<main class="view-acc-main">
    <?php
    include_once("backend/userinfo.php");
    $account_info = UserInfo::get_account($_GET['id']);
    if($_SESSION['id'] != $account_info['user_id']) {
        header("Location: /accounts");
        exit();
    }
    include("blocks/account_info.php");
    ?>
</main>
<?php
include_once("blocks/footer.phtml");
?>