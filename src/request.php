<?php
include_once("blocks/header.phtml");
if(empty($_SESSION['logged'])) {
header("Location: login.php");
exit();
}
include_once("backend/userinfo.php");
?>
<main class="client-request-main">
    <div class="client-request-container">
        <div class="client-request-info">
            <h1>Nosūtīt ziņu administratoram</h1>
            <p>Vai ir radušies jautājumi, problēmas?</p>
            <p>Atstājiet ziņu, un administrators mēģinās risināt problēmu!</p>
            <p>Atbildi uz ziņojumu saņemsiet uz profilā norādīto e-pastu.</p>
        </div>
        <div class="rq-send-form">
        <form action="/create_request" method="POST" class="request-send-form">
            <label for="title">Ziņojuma tēma</label>
            <input type="text" name="title" placeholder="Mans ziņojums" id="title" required>

            <label for="description" class="request-send-description">Apraksts (līdz 300 rakstzīmēm)</label>
            <textarea id="description" name="description" rows="12" cols="100" maxlength="300" class="request-send-description-textarea"></textarea>

            <input type="submit" value="Sūtīt ziņojumu" id="submit">
        </form>
        </div>
    </div>
</main>
<?php
include_once("blocks/footer.phtml");