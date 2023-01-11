<?php
include_once("blocks/header.phtml");
include_once("./backend/userinfo.php");
?>
<main>
    <h1>Atbildēt uz lietotāja ziņu</h1>
    <?php
    $request = UserInfo::get_request($_GET['id']);
    $profile = UserInfo::get_profile($request['user_id']);

    echo "<div class='request'><h1>{$request['title']}</h1>";
    echo "<h2>{$profile['name']} {$profile['surname']}</h2>";
    echo "<p>{$request['date']}</p>";
    echo "<p>{$request['description']}</p>";
    echo "</div>";
    echo "<form action='/send_answer_request?id={$_GET['id']}' method='POST'>"
    ?>
        <label for="answer">Atbilde</label>
        <textarea id="answer" name="answer" rows="12" cols="100"></textarea>

        <input type="submit" value="Sūtīt atbildi" id="submit">
    </form>
</main>
<?php
include_once("blocks/footer.phtml");