<table class="account-list-table">
    <thead class="acc-list-thead">
    <tr>
        <th>Norēķinu konti</th>
        <th>Konta atlikums</th>
        <th>Rezervēts</th>
        <th>Pieejamais atlikums</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <!-- PREVIEW -->
    <?php
        $account_info = get_accounts($_SESSION['id']);
        $total = 0;
        if($account_info == '') {
            echo '<td>Nav kontu!</td>';
        } else {
            foreach ($account_info as &$value) {
                echo '<tr>';
                echo '<th class="left">' . $value[1] . ' ' . $value[2] . '</th>';
                echo '<th class="right">' . $value[4] . '</th>';
                echo '<th class="right">' . $value[5] . '</th>';
                echo '<th class="right">' . $value[4] + $value[5] . '</th>';
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