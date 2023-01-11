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
            <div class="emails">
                <label for="email" class="lemail">E-pasta adrese</label>
                <div class="emails2">
                    <img src="/images/email-icon.jpg" class="email-icon" width="30px" height="30px">
                    <input type="text" name="email" placeholder="E-pasts" id="login-email" required>
                </div>
            </div>

            <div class="passwords">
                <label for="password" class="lpassword">Parole</label>
                <div class="passwords2">
                    <img src="/images/password-icon.jpg" class="password-icon" width="16px" height="18px">
                    <input type="password" name="password" placeholder="Parole" class="login-password" required>
                </div>
            </div>
            <input type="submit" value="Log in" class="submit-login">
        </form>
        <div class="login-container-footer">
            <p><a href="/restore" class="to-password-restore">Aizmirsāt paroli?</a></p>
            <p><a href="/signup" class="to-registration">Reģistrējieties šeit!</a></p>
            <p><a href="/" class="to-homepage">Galvenā lapā</a></p>
        </div>
    </div>
</main>
</body>
</html>
<footer class="login-footer">
    <a href="/">© Pro State Bank 2022</a>
    <a href="/profile">Profile</a>
    <a href="/accounts">Accounts</a>
    <a href="/money_transfer">Money transfer</a>
    <a href="/history">History</a>
    <a href="/fiscles">Fiscleees!</a>
</footer>
</body>
</html>
