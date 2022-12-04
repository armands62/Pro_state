<?php
include_once("blocks/header.phtml");
if(empty($_SESSION['logged'])) {
    header("Location: login.php");
    exit();
}
include_once("backend/userinfo.php");

$account_info = get_account($_GET['id']);
if($_SESSION['id'] != $account_info['user_id']) {
    header("Location: accounts.php");
    exit();
}
?>
    <main>
        <?php
            if(!empty($_SESSION["login_err_msg"])){
                echo "<p class='login-error'>{$_SESSION["login_err_msg"]}</p>";
                unset($_SESSION["login_err_msg"]);
            }

            $account_info = get_account($_GET['id']);
            echo "<form action=\"backend/update_account.php?id={$_GET['id']}\" method=\"POST\">";
            echo "<label for=\"name\">Konta nosaukums</label>";
            echo "<input type=\"text\" name=\"name\" placeholder=\"Konta nosaukums\" value=\"{$account_info['name']}\" id=\"name\" required>";

            echo "<label for=\"daily-limit\">Dienas limits</label>";
            echo "<input type=\"number\" name=\"daily-limit\" value=\"{$account_info['daily_limit']}\" id=\"daily-limit\" required>";

            echo "<label for=\"monthly-limit\">Mēneša limits</label>";
            echo "<input type=\"number\" name=\"monthly-limit\" value=\"{$account_info['monthly_limit']}\" id=\"monthly-limit\" required>";
        ?>
            <input type="submit" value="Rediģēt kontu" id="submit">
        </form>
    </main>

<?php
include_once("blocks/footer.phtml");
