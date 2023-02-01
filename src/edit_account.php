<?php
include_once("blocks/header.phtml");
if(empty($_SESSION['logged'])) {
    header("Location: login.php");
    exit();
}
include_once("backend/userinfo.php");

$account_info = UserInfo::get_account($_GET['id']);
if($_SESSION['id'] != $account_info['user_id']) {
    header("Location: accounts.php");
    exit();
}
?>
    <main class="edit-acc-main">
        <div class="edit-acc-container">
        <?php
            if(!empty($_SESSION["login_err_msg"])){
                echo "<p class='login-error'>{$_SESSION["login_err_msg"]}</p>";
                unset($_SESSION["login_err_msg"]);
            }

            $account_info = UserInfo::get_account($_GET['id']);
            echo "<form action=\"/update_account?id={$_GET['id']}\" method=\"POST\">";
            echo "<div class='edit-accs'><label for=\"name\" class='e-acc-name'>Konta nosaukums</label>";
            echo "<input type=\"text\" name=\"name\" placeholder=\"Konta nosaukums\" value=\"{$account_info['name']}\" id=\"name\" class='e-acc-input' required></div>";

            echo "<div class='edit-accs'><label for=\"daily-limit\" class='e-acc-name'>Dienas limits</label>";
            echo "<input type=\"number\" name=\"daily-limit\" value=\"{$account_info['daily_limit']}\" id=\"daily-limit\" class='e-acc-input' required></div>";

            echo "<div class='edit-accs'><label for=\"monthly-limit\" class='e-acc-name'>Mēneša limits</label>";
            echo "<input type=\"number\" name=\"monthly-limit\" value=\"{$account_info['monthly_limit']}\" id=\"monthly-limit\" class='e-acc-input' required></div>";
        ?>
            <div class="e-acc-footer">
            <input type="submit" value="Rediģēt kontu" class="edit-acc-submit">
            </div>
        </form>
        </div>
    </main>
<?php
include_once("blocks/footer.phtml");
