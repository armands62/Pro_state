<?php
include_once("blocks/header.phtml");
if(empty($_SESSION['logged'])) {
    header("Location: login.php");
    exit();
}
include_once("backend/userinfo.php");
?>
<link rel="stylesheet" href="src/css/profile.css" type="text/css">
<link href="src/css/adaptive.css" type="text/css" rel="stylesheet">
<main class="profile-main">
        <div id="general-info">
            <div class="flex-row">
                <img src="./images/avatar.png" class="user-avatar"/>
                <div class="info-text">
                    <?php
                    $user_info = UserInfo::get_profile($_SESSION['id']);

                    echo '<p>Vārds: ' . $user_info['name'] . '</p>';
                    echo '<p>Uzvārds: ' . $user_info['surname'] . '</p>';
                    echo '<p>E-pasts: ' . $user_info['email'] . '</p>';
                    if($_SESSION['auth'] == 0) {
                        echo '<li style="color: green">Profils ir aktivizēts!</li>';
                    } else {
                        echo '<li style="color: red">Profils nav aktivizēts!</li>';
                        echo '<li><a href="/authorize">Aktivizēt kontu</a></li>';
                    }
                    ?>
                </div>
            </div>
            <div class="profile-changes-buttons">
            <?php
                echo "<p><a href=\"/edit_profile?id={$_SESSION["id"]}\" class='profile-edit-button'>Rediģēt profilu</a></p>";
            if(!empty($_SESSION["login_err_msg"])){
                echo "<p class='login-error'>{$_SESSION["login_err_msg"]}</p>";
                unset($_SESSION["login_err_msg"]);
            }
            ?>
            <p><a href="/change_password" class='profile-edit-button'>Mainīt paroli</a></p>
            </div>
        </div>
        <div id="profile-account-list-container">
            <?php include_once('blocks/account_table.php'); ?>
        </div>
</main>

<?php
include_once("blocks/footer.phtml");
