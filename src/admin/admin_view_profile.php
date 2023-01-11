<?php
include_once("blocks/header.phtml");
include_once("./backend/userinfo.php");
?>
    <main id="profile-main">
        <div class="main-content">
            <div class="info-container">
                <div class="general-info">
                    <div class="flex-row">
                        <img src="./images/avatar.png" class="user-avatar"/>
                        <ul class="info-text">
                            <?php
                            $user_info = UserInfo::get_profile($_GET['id']);

                            echo '<li>Vārds: ' . $user_info['name'] . '</li>';
                            echo '<li>Uzvārds: ' . $user_info['surname'] . '</li>';
                            echo '<li>E-pasts: ' . $user_info['email'] . '</li>';
                            if($user_info['auth'] == 0) {
                                echo '<li style="color: green">Profils ir aktivizēts!</li>';
                            } else {
                                echo '<li style="color: red">Profils nav aktivizēts!</li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="account-list-container">
                    <?php include_once('./blocks/account_table.php'); ?>
                </div>
            </div>
        </div>
    </main>

<?php
include_once("blocks/footer.phtml");