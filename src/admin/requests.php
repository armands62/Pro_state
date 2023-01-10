<?php
include_once("blocks/header.phtml");
include_once("./backend/userinfo.php");
?>
    <main class="home-main">
        <h1>Lietotāju pieprasījumu lapa</h1>
        <div class="request-list">
        <?php
        $requests = UserInfo::get_requests();
        if ($requests == []) {
            echo "Pašlaik nav pieprasījumu!";
        }
        foreach ($requests as $request) {
            $profile = UserInfo::get_profile($request[1]);

            echo "<div class='request'><h1>$request[2]</h1>";
            echo "<h2>{$profile['name']} {$profile['surname']}</h2>";
            echo "<p>$request[4]</p>";
            echo "<p>$request[3]</p>";
            echo "<div class='request-buttons'><a href='/answer_request?id=$request[0]' class='answer-button'>Atbildēt</a>";
            echo "<a href='/delete_request?id=$request[0]' class='delete-button'>Dzēst</a></div>";
            echo "</div>";
        }
        ?>
        </div>
    </main>
<?php
include_once("blocks/footer.phtml");