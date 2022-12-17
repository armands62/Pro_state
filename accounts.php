<?php
include_once("blocks/header.phtml");
if(empty($_SESSION['logged'])) {
    header("Location: login.php");
    exit();
}
include_once("backend/userinfo.php");
?>
    <main class="accounts-main">
        <div class="account-list-container">
            <?php include_once('blocks/account_table.php'); ?>
            <a href="add_account.php" class="account-add-button">Pievienot kontu</a>
        </div>
    </main>
<?php
include_once("blocks/footer.phtml");