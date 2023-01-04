<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="src/css/main.css" type="text/css" rel="stylesheet">
    <title>Pro State Bank</title>
</head>
<body>
<main class="signup-main">
    <div class="signup-container">
        <h2>Mainīt paroli</h2>
        <?php
        if(!empty($_SESSION["login_err_msg"])){
            echo "<p class='login-error'>{$_SESSION["login_err_msg"]}</p>";
            unset($_SESSION["login_err_msg"]);
        }
        ?>
        <form action="/update_password" method="POST">
            <?php
            if(isset($_SESSION['logged'])) {
                echo '<label for="password_old">Ievadiet veco paroli</label>';
                echo '<input type="password" name="password_old" placeholder="Parole" id="password_old" required>';
            }
            ?>
            <label for="password">Ievadiet jauno paroli</label>
            <input type="password" name="password" placeholder="Parole" id="password" required>

            <label for="password_repeat">Ievadiet paroli vēlreiz</label>
            <input type="password" name="password_repeat" placeholder="Parole" id="password_repeat" required>

            <input type="submit" value="Mainīt paroli" id="submit">
        </form>
    </div>
</main>
</body>
</html>
