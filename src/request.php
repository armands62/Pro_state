<?php
include_once("blocks/header.phtml");
if(empty($_SESSION['logged'])) {
header("Location: login.php");
exit();
}
include_once("backend/userinfo.php");
?>
<link rel="stylesheet" href="src/css/request.css" type="text/css">
<main class="client-request-main">
        <div class="client-request-info">
            <h1>Nosūtīt ziņu administratoram</h1>
            <p>Vai ir radušies jautājumi, problēmas?</p>
            <p>Atbildi uz ziņojumu saņemsiet uz profilā norādīto e-pastu.</p>
        </div>
        <div class="rq-send-form">
            <form action="/create_request" method="POST" class="request-send-form">
                <div class="request-theme">
                    <label for="title">Ziņojuma tēma</label>
                    <input type="text" name="title" placeholder="Mans ziņojums" id="title" class="request-title" required>
                </div>
                <div class="request-message">
                    <textarea id="description" placeholder="Apraksts līdz 300 rakstzīmēm" name="description" rows="12" cols="100" maxlength="300" class="request-send-description-textarea"></textarea>
                </div>

                <div>
                    <input type="submit" value="Sūtīt ziņojumu" class="send-request-button">
                </div>
            </form>
        </div>
</main>
<?php
include_once("blocks/footer.phtml");