<?php
include_once("blocks/header.phtml");
?>
    <main class="home-main">
        <h1>Lietotāju darbību reģistrs</h1>
        <div class="account-list-container" id="table-container">
            <table class="account-list-table">
                <thead class="acc-list-thead">
                <tr>
                    <th>Lietotājs</th>
                    <th>Apraksts</th>
                    <th>Datums</th>
                    <th>IP adrese</th>
                </tr>
                </thead>
                <tbody>
                <?php
                include_once("./backend/userinfo.php");
                $registry_info = UserInfo::get_all_activity_registry();
                if($registry_info == '') {
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

                    foreach ($registry_info as $value) {
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
                        $profile_info = UserInfo::get_profile($value[1]);
                        echo "<tr><th class=\"left\"><a href='/admin_view_profile?id=$value[1]'>{$profile_info['name']} {$profile_info['surname']}</a></th>";
                        switch ($value[3]) {
                            case 2:
                                echo "<th class=\"left\" style='color: orange'>$value[2]</th>";
                                break;
                            case 3:
                                echo "<th class=\"left\" style='color: red'>$value[2]</th>";
                                break;
                            case 1:
                            default:
                                echo "<th class=\"left\" style='color: black'>$value[2]</th>";
                                break;
                        }
                        echo "<th class=\"left\">$value[4]</th>";
                        echo "<th class=\"center\">$value[5]</th></tr>";
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
                    echo '<a href="/admin_registry?page=1" class="end">Iepriekšējā lapa</a>';
                } else {
                    echo '<a href="/admin_registry?page=' . ($_GET['page'] - 1) . '">Iepriekšējā lapa</a>';
                }
                echo "<p>{$_GET['page']}</p>";
                if(count($registry_info) - $_GET['page'] * 9 > 0) {
                    echo '<a href="/admin_registry?page=' . ($_GET['page'] + 1) . '">Nākamā lapa</a>';
                } else {
                    echo '<a href="/admin_registry?page=' . $_GET['page'] . '" class="end">Nākamā lapa</a>';
                }
                ?>
            </div>
        </div>
    </main>
<?php
include_once("blocks/footer.phtml");