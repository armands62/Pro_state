<table class="account-list-table">
    <thead class="acc-list-thead">
    <tr>
        <th>Konti</th>
        <th>Apraksts</th>
        <th>Datums</th>
        <th>Summa</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php
    session_cache_limiter('');
    session_start();
    include_once("../backend/userinfo.php");
    $account_info = get_accounts($_SESSION['id']);
    $transaction_info = get_transaction_history($account_info[$_POST['account-id']][0]);
    if($transaction_info == '') {
        echo '<td>Nav veiktu maksājumu!</td>';
    } else {
        foreach ($transaction_info as $value) {
            $account_from_info = get_account($value[1]);
            $account_to_info = get_account($value[2]);
            if($account_info[$_POST['account-id']][0] == $value[1]) {
                echo "<tr><th class=\"left\">{$account_from_info['number']} {$account_from_info['name']} --> {$account_to_info['number']} ({$account_from_info['user_name']} {$account_from_info['user_surname']})</th>";
            }
            else {
                echo "<tr><th class=\"left\">{$account_to_info['number']} {$account_to_info['name']} <-- {$account_from_info['number']} ({$account_from_info['user_name']} {$account_from_info['user_surname']})</th>";
            }
            echo "<th class=\"left\">$value[4]</th>";
            echo "<th class=\"center\">$value[5]</th>";
            if($account_info[$_POST['account-id']][0] == $value[1]){
                echo "<th class=\"right\" style=\"color: red\">-$value[3]</th>";
            }
            if($account_info[$_POST['account-id']][0] == $value[2]) {
                echo "<th class=\"right\" style=\"color: green\">+$value[3]</th>";
            }
            echo '<th class="center">FISC</th></tr>';
        }
    }
    ?>
    </tbody>
</table>