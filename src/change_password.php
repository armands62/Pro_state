<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="src/css/main.css" type="text/css" rel="stylesheet">
    <link href="src/css/adaptive.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="src/css/change_password.css" type="text/css">
    <title>Pro State Bank</title>
</head>
<body>
<main class="change-password-main">
    <div class="change-password-container">
        <h2>Mainīt paroli</h2>
        <?php
        if(!empty($_SESSION["login_err_msg"])){
            echo "<p class='login-error'>{$_SESSION["login_err_msg"]}</p>";
            unset($_SESSION["login_err_msg"]);
        }
        ?>
        <form action="/update_password" method="POST">
            <div class="password-change">
                <?php
                if(isset($_SESSION['logged'])) {
                    echo '<label for="password_old" class="old-password">Ievadiet veco paroli</label>';
                    echo '<input type="password" name="password_old" placeholder="Vecā parole" id="password_old" class="change-input" required>';
                }
                ?>
            </div>

            <div class="password-change">
                <label for="password" class="new-password">Ievadiet jauno paroli</label>
                <input type="password" name="password" placeholder="Jaunā parole" id="password" class="change-input" required>
            </div>

            <div class="password-change">
                <label for="password_repeat" class="new-password2">Ievadiet paroli vēlreiz</label>
                <input type="password" name="password_repeat" placeholder="Jaunā parole" id="password_repeat" class="change-input" required>
            </div>

            <input type="submit" value="Mainīt paroli" class="change-submit">
            <div class="change-password-footer">
            <p><a href="/" class="cp-to-homepage">Galvenā lapā</a></p>
            </div>
        </form>
    </div>
</main>
</body>
</html>
