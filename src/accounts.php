<?php
include_once("blocks/header.phtml");
if(empty($_SESSION['logged'])) {
    header("Location: login.php");
    exit();
}
include_once("backend/userinfo.php");
?>
<link rel="stylesheet" href="src/css/accounts.css" type="text/css">
    <div class="accounts-main">
        <div class="accounts-container">
            <?php include_once('blocks/account_table.php'); ?>
            <div class="adding-button">
                <a href="/add_account" class="account-add-button">Pievienot kontu</a>
            </div>
        </div>
    </div>
<?php
include_once("blocks/footer.phtml");
