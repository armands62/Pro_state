<?php
include_once("header.phtml");
if(empty($_SESSION['logged'])) {
    header("Location: login.php");
    exit();
}
include_once("userinfo.php");
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
        <div class="info-outer-container">
            <div class="info-inner-container">
                <!-- Jāpafixo -->
                <h3>Konti</h3>
                <ul class="account-info-header">
                    <li>Konta numurs</li>
                    <li>Bilance</li>
                    <li>Kredīts</li>
                    <li>Rezervēts</li>
                    <li>Pieejams</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php
include_once("footer.phtml");
