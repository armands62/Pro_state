<script src="/src/js/money_transfer.js"></script>
        <div class="general-info">
            <ul class="info-text">
                <?php
                include_once('./backend/userinfo.php');
                $account_info = UserInfo::get_account($_GET['id']);

                echo "<li>Konts: {$account_info['number']} {$account_info['name']}</li>";
                echo "<li>Dienas limits: {$account_info['daily_limit']}</li>";
                echo "<li>Mēneša limits: {$account_info['monthly_limit']}</li>";
                ?>
            </ul>
            <?php
            if ($account_info['user_id'] == $_SESSION['id']) {
                echo "<p><a href=\"edit_account?id={$_GET["id"]}\">Rediģēt kontu</a></p>";
            }
            ?>
        </div>
        <div class="account-list-container" id="table-container">
            <?php
            $relative_id = UserInfo::get_relative_account_id($_GET['id'], $account_info['user_id']);
            $_SESSION['user_id'] = $account_info['user_id'];
            echo "<script>loadDoc($relative_id)</script>" ?>
        </div>
    