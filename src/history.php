<?php
include_once("blocks/header.phtml");
if(empty($_SESSION['logged'])) {
    header("Location: login.php");
    exit();
}
include_once("backend/userinfo.php");
?>
<link rel="stylesheet" href="src/css/history.css" type="text/css">
<link href="src/css/adaptive.css" type="text/css" rel="stylesheet">
<main class="history-main">
    <div class="history-form">
    <label for="account-id" class="account-output">Izvadīt konta maksājumu informāciju:</label>
    <select id="account-id" name="account-id">
        <option value="-1">Izvēlēties savu kontu</option>
        <?php
        $account_info = UserInfo::get_accounts($_SESSION['id']);
        $i = 0;
        foreach ($account_info as $value) {
            echo "<option value='$i'>$value[1] $value[2]</option>";
            $i++;
        }
        ?>
    </select>
    <button type="button" onclick="loadDoc()" class="load-table">Load table</button>
    </div>
    <div class="account-list-container" id="table-container">
        <!--<?php include_once('blocks/transaction_table.php'); ?>-->
    </div>
    <script src="/src/js/money_transfer.js"></script>
</main>
<?php
include_once("blocks/footer.phtml");
