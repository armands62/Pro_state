<table class="account-list-table">
    <thead class="acc-list-thead">
    <tr>
        <th>Norēķinu konti</th>
        <th>Pieejamais atlikums</th>
        <th>Rezervēts</th>
        <th>Kopējais atlikums</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <!-- PREVIEW -->
    <?php
        $account_info = "";
        $account_url = "/view_account";
        if(!empty($_SESSION['admin'])) {
            if ($_SESSION['admin'] > 2 && isset($_GET['id'])) {
                $account_info = UserInfo::get_accounts($_GET['id']);
                $account_url = "/admin_view_account";
            } else {
                $account_info = UserInfo::get_accounts($_SESSION['id']);
            }
        } else {
            $account_info = UserInfo::get_accounts($_SESSION['id']);
        }
        $total = 0;
        if($account_info == '') {
            echo '<td>Nav kontu!</td>';
        } else {
            foreach ($account_info as $value) {
                echo '<tr>';
                echo "<th class=\"left\"><a href='$account_url?id=$value[0]' class='profile-accounts'>$value[1] $value[2]</a></th>";
                echo "<th class=\"right\">$value[4]</th>";
                echo "<th class=\"right\">$value[5]</th>";
                echo '<th class="right">' . ($value[4] + $value[5]) . '</th>';
                echo '<th class="center">FISC</th>';
                echo '<tr>';
                $total += $value[4] + $value[5];
            }
        }
        echo '<tr class="acc-total">';
        echo '<th class="left">Pieejamais atlikums:</th>';
        echo '<th></th>';
        echo '<th></th>';
        echo '<th class="right">' . $total . '</th>';
        echo '<th>FISC</th>';
        echo '</tr>';
    ?>
    </tbody>
</table>