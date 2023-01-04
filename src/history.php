<?php
include_once("blocks/header.phtml");
if(empty($_SESSION['logged'])) {
    header("Location: login.php");
    exit();
}
include_once("backend/userinfo.php");
?>
<main>
    <label for="account-id">Izvadīt konta maksājumu informāciju:</label>
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
    <button type="button" onclick="loadDoc()">Load table</button>
    <div class="account-list-container" id="table-container">
        <!--<?php include_once('blocks/transaction_table.php'); ?>-->
    </div>
    <script src="/src/js/money_transfer.js"></script>
</main>
<?php
include_once("blocks/footer.phtml");
