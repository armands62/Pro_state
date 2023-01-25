<?php
include_once("blocks/header.phtml");
if(empty($_SESSION['logged'])) {
    header("Location: login.php");
    exit();
}
include_once("backend/userinfo.php");
?>
<script src="src/js/money_transfer.js"></script>
<link rel="stylesheet" href="src/css/money_transfer.css" type="text/css">
<link href="src/css/adaptive.css" type="text/css" rel="stylesheet">
<main class="money_transfer-main">
    <?php
    if(!empty($_SESSION["login_err_msg"])){
        echo "<p class='login-error'>{$_SESSION["login_err_msg"]}</p>";
        unset($_SESSION["login_err_msg"]);
    }
    ?>
    <form action="/transfer" method="POST" class="money_transfer-form">
        <div class="mt">
        <label for="account-from">Pārskaitāmais konts</label>
        <select name="account-from" id="account-from" class="mt-input">
            <option value="0">Izvēlēties savu kontu</option>
            <?php
                $account_info = UserInfo::get_accounts($_SESSION['id']);
                foreach ($account_info as $value) {
                    echo "<option value='$value[0]'>$value[1] $value[2] ($value[4]$)</option>";
                }
            ?>
        </select>
        </div>

        <div class="mt">
        <label for="account-to" class="mt-label">Saņēmēja konts</label>
        <input type="text" name="account-to" placeholder="Konta nosaukums" id="account-to" maxlength="21" class="mt-input" required>
        </div>

        <div class="mt">
        <label for="amount" class="mt-label">Pārskaitāmā summa</label>
        <input type="number" name="amount" value="35" id="amount" min="10" max="300" class="mt-input" required>
        </div>

        <div class="mt">
        <label for="description" class="mt-label">Apraksts</label>
        <textarea name="description" placeholder="Apraksts" id="description" maxlength="255" class="mt-input" required></textarea>
        </div>

        <input type="submit" value="Veikt maksājumu" class="submit-payment">
    </form>
</main>
<?php
include_once("blocks/footer.phtml");
