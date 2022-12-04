<?php
include_once("blocks/header.phtml");
if(empty($_SESSION['logged'])) {
    header("Location: login.php");
    exit();
}
include_once("backend/userinfo.php");
?>
    <main>
        <?php
        if(!empty($_SESSION["login_err_msg"])){
            echo "<p class='login-error'>{$_SESSION["login_err_msg"]}</p>";
            unset($_SESSION["login_err_msg"]);
        }
        ?>
        <form action="backend/update_profile.php" method="POST">
            <?php
            $user_info = get_profile($_SESSION['id']);
            echo "<label for=\"name\">Vārds</label>";
            echo "<input type=\"text\" name=\"name\" placeholder=\"Vārds\" value=\"{$user_info['name']}\" id=\"name\" required>";

            echo "<label for=\"surname\">Uzvārds</label>";
            echo "<input type=\"text\" name=\"surname\" placeholder=\"Uzvārds\" value=\"{$user_info['surname']}\" id=\"surname\" required>";

            echo "<label for=\"email\">E-pasts</label>";
            echo "<input type=\"text\" name=\"email\" placeholder=\"E-pasts\" value=\"{$user_info['email']}\" id=\"email\" required>";
            ?>
            <input type="submit" value="Rediģēt profilu" id="submit">
        </form>
    </main>

<?php
include_once("blocks/footer.phtml");
