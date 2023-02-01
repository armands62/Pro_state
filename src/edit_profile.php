<?php
include_once("blocks/header.phtml");
if(empty($_SESSION['logged'])) {
    header("Location: login.php");
    exit();
}
include_once("backend/userinfo.php");
?>
<link rel="stylesheet" href="src/css/edit_profile.css" type="text/css">
    <main class="edit-profile-main">
        <?php
        if(!empty($_SESSION["login_err_msg"])){
            echo "<p class='login-error'>{$_SESSION["login_err_msg"]}</p>";
            unset($_SESSION["login_err_msg"]);
        }
        ?>
        <form action="/update_profile" method="POST" class="edit-profile-form">
            <?php
            $user_info = UserInfo::get_profile($_SESSION['id']);
            echo "<label for=\"name\" class='edit-name'>Vārds</label>";
            echo "<input type=\"text\" name=\"name\" placeholder=\"Vārds\" value=\"{$user_info['name']}\" id=\"name\" class='e-input' required>";

            echo "<label for=\"surname\" class='edit-surname'>Uzvārds</label>";
            echo "<input type=\"text\" name=\"surname\" placeholder=\"Uzvārds\" value=\"{$user_info['surname']}\" id=\"surname\" class='e-input' required>";

            echo "<label for=\"email\" class='edit-email'>E-pasts</label>";
            echo "<input type=\"text\" name=\"email\" placeholder=\"E-pasts\" value=\"{$user_info['email']}\" id=\"email\" class='e-input' required>";
            ?>
            <input type="submit" value="Rediģēt profilu" class="accept-edit">
        </form>
    </main>

<?php
include_once("blocks/footer.phtml");
