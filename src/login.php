<?php
if(!empty($_SESSION["logged"])) {
    header("Location: index.php");
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <link href="src/css/main.css" type="text/css" rel="stylesheet">
    <title>Pro State Bank</title>
</head>
<body>
<main class="login-main">
    <div class="login-container">
        <h2>Ielogoties</h2>
        <?php
        if(!empty($_SESSION["login_err_msg"])){
            echo "<p class='login-error'>{$_SESSION["login_err_msg"]}</p>";
            unset($_SESSION["login_err_msg"]);
        }
        ?>
        <form action="/authenticate" method="POST" class="login-page-authenticate">
            <label for="email">E-pasta adrese</label>
            <input type="text" name="email" placeholder="E-pasts" id="login-email" required>

            <label for="password">Parole</label>
            <input type="password" name="password" placeholder="Parole" id="login-password" required>
            <input type="submit" value="Log in" id="submit">
        </form>
        <p><a href="/signup" class="to-registration">Vai jūs vēl neesat reģistrējies? Reģistrējieties šeit!</a></p>
        <p><a href="/" class="to-homepage">Atgriezties galvenajā lapā</a></p>
    </div>
</main>
</body>
</html>

<?php
include_once("blocks/footer.phtml");
