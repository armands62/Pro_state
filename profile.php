<?php
include_once("blocks/header.phtml");
if(empty($_SESSION['logged'])) {
    header("Location: login.php");
    exit();
}
include_once("backend/userinfo.php");
?>


<div class="main-content">
    <div class="profile-info-container">
        <div class="user-info-container">
            <img src="images/avatar.png" class="user-avatar"/>
            <ul>
                <?php
                $user_info = get_profile($_SESSION['id']);

                echo '<li>Vārds: ' . $user_info['name'] . '</li>';
                echo '<li>Uzvārds: ' . $user_info['surname'] . '</li>';
                echo '<li>E-pasts: ' . $user_info['email'] . '</li>';
                ?>
            </ul>
        </div>
        <div class="account-list-container">
            <?php include_once('blocks/account_table.php'); ?>
        </div>
    </div>

</div>

<?php
include_once("blocks/footer.phtml");
