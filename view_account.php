<?php
include_once("blocks/header.phtml");
if(empty($_SESSION['logged']) || empty($_GET['id'])) {
    header("Location: login.php");
    exit();
}
include_once("backend/userinfo.php");
$account_info = get_account($_GET['id']);
if($_SESSION['id'] != $account_info['user_id']) {
    header("Location: login.php");
    exit();
}
?>
<script src="js/money_transfer.js"></script>
<div class="main-content">
    <div class="info-container">
        <div class="general-info">
            <ul class="info-text">
                <?php
                $account_info = get_account($_GET['id']);

                echo "<li>Konts: {$account_info['number']} {$account_info['name']}</li>";
                echo "<li>Dienas limits: {$account_info['daily_limit']}</li>";
                echo "<li>Mēneša limits: {$account_info['monthly_limit']}</li>";
                ?>
            </ul>
            <?php
            echo "<p><a href=\"edit_account.php?id={$_GET["id"]}\">Rediģēt kontu</a></p>";
            ?>
        </div>
        <div class="account-list-container" id="table-container">
            <?php
            $relative_id = get_relative_account_id($_GET['id'], $_SESSION['id']);
            echo "<script>loadDoc($relative_id)</script>" ?>
            <!--<?php include_once('blocks/transaction_table.php'); ?>-->
        </div>
    </div>

</div>
<?php
include_once("blocks/footer.phtml");
