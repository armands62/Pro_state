<?php
include_once("blocks/header.phtml");
if(empty($_SESSION['logged'])) {
    header("Location: login.php");
    exit();
}
include_once("backend/userinfo.php");
?>

<main id="profile-main">
<div class="main-content">
    <div class="info-container">
        <div class="general-info">
            <div class="flex-row">
                <img src="./images/avatar.png" class="user-avatar"/>
                <ul class="info-text">
                    <?php
                    $user_info = UserInfo::get_profile($_SESSION['id']);

                    echo '<li>Vārds: ' . $user_info['name'] . '</li>';
                    echo '<li>Uzvārds: ' . $user_info['surname'] . '</li>';
                    echo '<li>E-pasts: ' . $user_info['email'] . '</li>';
                    if($_SESSION['auth'] == 0) {
                        echo '<li style="color: green">Profils ir aktivizēts!</li>';
                    } else {
                        echo '<li style="color: red">Profils nav aktivizēts!</li>';
                        echo '<li><a href="/authorize">Aktivizēt kontu</a></li>';
                    }
                    ?>
                </ul>
            </div>
            <?php
                echo "<p><a href=\"/edit_profile?id={$_SESSION["id"]}\" class='profile-edit-button'>Rediģēt profilu</a></p>";
            if(!empty($_SESSION["login_err_msg"])){
                echo "<p class='login-error'>{$_SESSION["login_err_msg"]}</p>";
                unset($_SESSION["login_err_msg"]);
            }
            ?>
            <p><a href="/change_password" class='profile-edit-button'>Mainīt paroli</a></p>
        </div>
        <div class="account-list-container">
            <?php include_once('blocks/account_table.php'); ?>
        </div>
    </div>
</div>
</main>

<?php
include_once("blocks/footer.phtml");
