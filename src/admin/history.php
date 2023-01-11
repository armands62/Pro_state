<?php
include_once("blocks/header.phtml");
?>
    <main class="home-main">
        <h1>Maksājumu vēstures lapa</h1>
        <div class="account-list-container" id="table-container">
            <table class="account-list-table">
                <thead class="acc-list-thead">
                <tr>
                    <th>Sūtītājs</th>
                    <th>Saņēmējs</th>
                    <th>Apraksts</th>
                    <th>Datums</th>
                    <th>Summa</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                include_once("./backend/userinfo.php");
                $account_info = UserInfo::get_accounts($_SESSION['id']);
                $transaction_info = UserInfo::get_all_transaction_history();
                if($transaction_info == []) {
                    echo '<td>Nav veiktu maksājumu!</td>';
                } else {
                    $i = 0;
                    $page_start = 0;
                    $page_end = 0;
                    if(empty($_GET['page'])) {
                        $_GET['page'] = 1;
                    }
                    $i = $_GET['page'];
                    $page_start = ($i - 1) * 11;
                    $page_end = $page_start + 10;
                    foreach ($transaction_info as $value) {
                        if($_GET['page'] == 1) {
                            if($i < $page_start) {
                                $i++;
                                continue;
                            }
                        }
                        else if($_GET['page'] > 1) {
                            if($i <= $page_start) {
                                $i++;
                                continue;
                            }
                        }
                        if($i > $page_end) break;
                        $account_from_info = UserInfo::get_account($value[1]);
                        $account_to_info = UserInfo::get_account($value[2]);
                        echo "<tr><th class=\"left\"><a href='/admin_view_account?id=$value[1]'>{$account_from_info['number']}</a> (<a href='/admin_view_profile?id={$account_from_info['user_id']}'>{$account_from_info['user_name']} {$account_from_info['user_surname']}</a>)</th>";
                        echo "<th class=\"left\"><a href='/admin_view_account?id=$value[2]'>{$account_to_info['number']}</a> (<a href='/admin_view_profile?id={$account_to_info['user_id']}'>{$account_to_info['user_name']} {$account_to_info['user_surname']}</a>)</th>";
                        echo "<th class=\"left\">$value[4]</th>";
                        echo "<th class=\"center\">$value[5]</th>";
                        echo "<th class=\"right\" style=\"color: red\">-$value[3]</th>";
                        echo '<th class="center">FISC</th></tr>';
                        $i++;
                    }
                }
                ?>
                </tbody>
            </table>
            <div class="table-nav">
                <?php
                if(empty($_GET['page'])) {
                    $_GET['page'] = 1;
                }
                if($_GET['page'] == 1) {
                    echo '<a href="/admin_history?page=1" class="end">Iepriekšējā lapa</a>';
                } else {
                    echo '<a href="/admin_history?page=' . ($_GET['page'] - 1) . '">Iepriekšējā lapa</a>';
                }
                echo "<p>{$_GET['page']}</p>";
                if(count($transaction_info) - $_GET['page'] * 9 > 0) {
                    echo '<a href="/admin_history?page=' . ($_GET['page'] + 1) . '">Nākamā lapa</a>';
                } else {
                    echo '<a href="/admin_history?page=' . $_GET['page'] . '" class="end">Nākamā lapa</a>';
                }
                ?>
            </div>
        </div>
    </main>
<?php
include_once("blocks/footer.phtml");