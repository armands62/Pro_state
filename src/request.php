<?php
include_once("blocks/header.phtml");
if(empty($_SESSION['logged'])) {
header("Location: login.php");
exit();
}
include_once("backend/userinfo.php");
?>
<main>
    <h1>Nosūtīt ziņu administratoram</h1>
    <p>Vai ir radušies jautājumi, radušās problēmas, vēlaties ziņot par problēmu sistēmā vai veikt pieprasījumu administratoram?</p>
    <p>Atstājiet ziņu, un administrators mēģinās risināt problēmu pēc iespējas ātrāk!</p>
    <p>Atbildi uz ziņojumu Jūs saņemsiet uz profilā norādīto e-pastu.</p>
    <form action="/create_request" method="POST">
        <label for="title">Ziņojuma tēma</label>
        <input type="text" name="title" placeholder="Mans ziņojums" id="title" required>

        <label for="description">Apraksts (līdz 1200 rakstzīmēm)</label>
        <textarea id="description" name="description" rows="12" cols="100"></textarea>

        <input type="submit" value="Sūtīt ziņojumu" id="submit">
    </form>
</main>
<?php
include_once("blocks/footer.phtml");