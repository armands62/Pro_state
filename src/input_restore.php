<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <link href="src/css/main.css" type="text/css" rel="stylesheet">
    <link href="src/css/adaptive.css" type="text/css" rel="stylesheet">
    <title>Pro State Bank</title>
</head>
<body>
<main class="login-main">
    <div class="login-container">
        <h2>Koda ievade</h2>
        <?php
        if(!empty($_SESSION["login_err_msg"])){
            echo "<p class='login-error'>{$_SESSION["login_err_msg"]}</p>";
            unset($_SESSION["login_err_msg"]);
        }
        ?>
        <form action="/check_restore" method="POST" class="login-page-authenticate">
            <label for="code">Atjaunošanas kods</label>
            <input type="text" name="code" placeholder="000000" id="login-email" required>
            <p><a href="/" class="to-homepage">Atgriezties galvenajā lapā</a></p>
            <p><a href="/send_restore">Sūtīt e-pastu atkārtoti</a></p>
            <input type="submit" value="Apstiprināt" id="submit">
        </form>
    </div>
</main>
</body>
</html>

<?php
include_once("blocks/footer.phtml");
