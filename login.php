<?php
session_start();
if(!empty($_SESSION["logged"])) {
    header("Location: index.php");
}
?>
<!doctype html>
<html lang="en">
<header>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <link href="css/main.css" type="text/css" rel="stylesheet">
    <title>Pro State Bank</title>
</header>
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
        <form action="authenticate.php" method="POST">
            <label for="email">E-pasta adrese</label>
            <input type="text" name="email" placeholder="E-pasts" id="email" required>

            <label for="password">Parole</label>
            <input type="password" name="password" placeholder="Parole" id="password" required>
            <input type="submit" value="Log in" id="submit">
        </form>
        <p><a href="signup.php">Vai jūs vēl neesat reģistrējies? Reģistrējieties šeit!</a></p>
        <p><a href="index.php">Atgriezties galvenajā lapā</a></p>
    </div>
</main>
</body>
</html>