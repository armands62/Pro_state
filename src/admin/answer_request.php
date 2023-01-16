<?php
include_once("blocks/header.phtml");
include_once("./backend/userinfo.php");
?>
<main class="admin-answer-request-main">
    <h1 class="answer-request-h1">Atbildēt uz lietotāja ziņu</h1>
    <form>
    <?php
    $request = UserInfo::get_request($_GET['id']);
    $profile = UserInfo::get_profile($request['user_id']);

    echo "<div class='request-answer'><h1>{$request['title']}</h1>";
    echo "<h2>{$profile['name']} {$profile['surname']}</h2>";
    echo "<p>{$request['date']}</p>";
    echo "<p>{$request['description']}</p>";
    echo "</div>";
    echo "<form action='/send_answer_request?id={$_GET['id']}' method='POST'>"
    ?>
    </form>
    <div class="answer-log">
        <label for="answer">Atbilde</label>
        <textarea id="answer" name="answer" rows="12" cols="100"></textarea>

        <input type="submit" value="Sūtīt atbildi" id="submit">
    </div>
</main>
<?php
include_once("blocks/footer.phtml");