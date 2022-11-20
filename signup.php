<?php
session_start();
if(!empty($_SESSION["logged"])) {
    header("Location: index.php");
}
?>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="css/main.css" type="text/css" rel="stylesheet">
    <title>Pro State Bank</title>
</head>
<body>
<main class="login-main">
    <div class="login-container">
        <h2>Reģistrēties</h2>
        <?php
        if(!empty($_SESSION["login_err_msg"])){
            echo "<p class='login-error'>{$_SESSION["login_err_msg"]}</p>";
            unset($_SESSION["login_err_msg"]);
        }
        ?>
        <form action="backend/register.php" method="POST">
            <label for="name">Vārds</label>
            <input type="text" name="name" placeholder="Vārds" id="name" required>

            <label for="surname">Uzvārds</label>
            <input type="text" name="surname" placeholder="Uzvārds" id="surname" required>

            <label for="soc-num-first">Personas kods</label>
            <input type="text" pattern="\d*" maxlength="6" name="soc-num-first" placeholder="000000" id="soc-num-first" required>
            <input type="text" pattern="\d*" maxlength="5" name="soc-num-last" placeholder="00000" id="soc-num-last" required>

            <label for="birthday">Dzimšanas datums</label>
            <input type="date" name="birthday" id="birthday" required>

            <label for="gender">Dzimums</label>
            <select id="gender" name="gender" required>
                <option value="male">Vīrietis</option>
                <option value="female">Sieviete</option>
                <option value="other">Nezinu</option>
            </select>

            <label for="email">E-pasta adrese</label>
            <input type="email" name="email" placeholder="E-pasts" id="email" required>

            <label for="password">Parole</label>
            <input type="password" name="password" placeholder="Parole" id="password" required>

            <input type="submit" value="Reģistrēties" id="submit">
        </form>
        <p><a href="login.php">Vai konts jau eksistē? Pierakstieties šeit!</a></p>
        <p><a href="index.php">Atgriezties galvenajā lapā</a></p>
    </div>
</main>
</body>
</html>
