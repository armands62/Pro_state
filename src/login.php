<?php
if(!empty($_SESSION["logged"])) {
    header("Location: index.php");
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <link href="src/css/main.css" type="text/css" rel="stylesheet">
    <title>Pro State Bank</title>
</head>
<body>
<main class="login-main">
    <form action="/authenticate" method="POST" class="login-container">
        <div class="login-form-header">
        <h2>Ielogoties</h2>
        <?php
        if(!empty($_SESSION["login_err_msg"])){
            echo "<p class='login-error'>{$_SESSION["login_err_msg"]}</p>";
            unset($_SESSION["login_err_msg"]);
        }
        ?>
        </div>
        <div class="login-form">
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
            <div class="login-form-footer">
                <p><a href="/signup" class="to-registration">Reģistrējieties šeit!</a></p>
                <p><a href="/" class="to-homepage">Galvenā lapā</a></p>
            </div>
        </div>
        </form>
</main>
</body>
</html>
<footer class="login-footer">
    <a href="/">© ProState Bank</a>
    <?php
    if(!empty($_SESSION["logged"])) {
        echo "<a href='/profile'>Profile</a>";
        echo "<a href='/accounts'>Accounts</a>";
        echo "<a href='/money_transfer'>Transfer</a>";
        echo "<a href='/history'>History</a>";
        echo "<a href='/request'>Sūtīt ziņojumu</a>";
    }
    ?>
    <a href="/faq">FAQ</a>
</footer>
</body>
</html>
