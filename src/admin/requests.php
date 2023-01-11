<?php
include_once("blocks/header.phtml");
include_once("./backend/userinfo.php");
?>
    <main class="admin-request-main">
        <h1 class="user-request-page">Lietotāju pieprasījumu lapa</h1>
        <?php
        $requests = UserInfo::get_requests();
        if ($requests == []) {
            echo "Pašlaik nav pieprasījumu!";
        }
        foreach ($requests as $request) {
            $profile = UserInfo::get_profile($request[1]);

            echo "<div class='request'><h1 class='request-name'>$request[2]</h1>";
            echo "<h2 class='requester'>{$profile['name']} {$profile['surname']}</h2>";
            echo "<p class='request-date-time'>$request[4]</p>";
            echo "<p class='request-info'>$request[3]</p>";
            echo "<div class='request-buttons'><a href='/answer_request?id=$request[0]' class='answer-button'>Atbildēt</a>";
            echo "<a href='/delete_request?id=$request[0]' class='delete-button'>Dzēst</a></div>";
            echo "</div>";
        }
        ?>
    </main>
<?php
include_once("blocks/footer.phtml");