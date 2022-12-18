<?php
include_once("blocks/header.phtml");
if(empty($_SESSION['logged'])) {
    header("Location: login.php");
    exit();
}
include_once("backend/userinfo.php");
?>
<script src="src/js/money_transfer.js"></script>
<main>
    <?php
    if(!empty($_SESSION["login_err_msg"])){
        echo "<p class='login-error'>{$_SESSION["login_err_msg"]}</p>";
        unset($_SESSION["login_err_msg"]);
    }
    ?>
    <form action="/transfer" method="POST">
        <label for="account-from">Pārskaitāmais konts</label>
        <select name="account-from" id="account-from">
            <option value="0">Izvēlēties savu kontu</option>
            <?php
                $account_info = get_accounts($_SESSION['id']);
                foreach ($account_info as $value) {
                    echo "<option value='$value[1]'>$value[1] $value[2] ($value[4]$)</option>";
                }
            ?>
        </select>

        <label for="account-to">Saņēmēja konts</label>
        <input type="text" name="account-to" placeholder="Konta nosaukums" id="account-to" maxlength="21" required>

        <label for="amount">Pārskaitāmā summa</label>
        <input type="number" name="amount" value="35" id="amount" min="10" max="300" required>

        <label for="description">Apraksts</label>
        <textarea name="description" placeholder="Apraksts" id="description" maxlength="255" required></textarea>

        <input type="submit" value="Veikt maksājumu" id="submit">
    </form>
</main>
<?php
include_once("blocks/footer.phtml");
