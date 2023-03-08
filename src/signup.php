<?php
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
    <link href="src/css/main.css" type="text/css" rel="stylesheet">
    <link href="src/css/signup.css" type="text/css" rel="stylesheet">
    <title>Pro State Bank</title>
</head>
<body>
<main class="signup-main">
    <form action="/register" method="POST" class="signup-container">
            <div class="signup-form-header">
                <h2>Reģistrēties</h2>
                <?php
                if(!empty($_SESSION["login_err_msg"])){
                    echo "<p class='login-error'>{$_SESSION["login_err_msg"]}</p>";
                    unset($_SESSION["login_err_msg"]);
                }
                ?>
            </div>
            <div class="registration-form">
            <div class="registration-field">
                <label for="name" class="rlabel">Vārds</label>
                <input type="text" name="name" placeholder="Vārds" id="name" class="rinput" required>
            </div>

            <div class="registration-field">
                <label for="surname" class="rlabel">Uzvārds</label>
                <input type="text" name="surname" placeholder="Uzvārds" id="surname" class="rinput" required>
            </div>

            <div class="registration-field">
                <label for="soc-num-first" class="rlabel">Personas kods</label>
                <input type="text" pattern="\d*" maxlength="6" name="soc-num-first" placeholder="000000" id="soc-num-first" class="rinput" required>
                <input type="text" pattern="\d*" maxlength="5" name="soc-num-last" placeholder="00000" id="soc-num-last" class="rinput" required>
            </div>

            <div class="registration-field-date">
                <label for="birthday" class="rlabel">Dzimšanas datums</label>
                <input type="date" name="birthday" id="birthday" class="rinput-date" required>
            </div>

            <div class="registration-field">
                <label for="gender" class="rlabel">Dzimums</label>
                <select id="gender" name="gender" class="rinput" required>
                    <option value="male">Vīrietis</option>
                    <option value="female">Sieviete</option>
                    <option value="other">Nezinu</option>
                </select>
            </div>

            <div class="registration-field">
                <label for="email" class="rlabel">E-pasta adrese</label>
                <input type="email" name="email" placeholder="E-pasts" id="email" class="rinput" required>
            </div>

            <div class="registration-field-password">
                <label for="password" class="rlabel">Parole</label>
                <input type="password" name="password" placeholder="Parole" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" onkeyup="checkPassword(this.value)" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" id="password" class="rinput" required>
                <span id="Btn"></span>
            </div>
            <input type="submit" value="Reģistrēties" class="register-submit">
            <div class="register-container-footer">
            <p><a href="/login" class="to-login">Pierakstieties šeit!</a></p>
            <p><a href="/" class="to-homepage">Galvenā lapā</a></p>
            <p><a href="/faq" class="to-faq">FAQ</a></p>
        </div>
        </form>
    </div>  
    <div id="validation" style="display: none;"> <!--style="display: none;"-->
            <ul>
                <li id="upper" class="invalid">At least one uppercase character</li>
                <li id="lower" class="invalid">At least one lowercase character</li>
                <li id="number" class="invalid">At least one number</li>
                <li id="length" class="invalid">At least 8 characters</li>
            </ul>
    </div>
</main>
<footer class="signup-footer">
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
<script src="/src/js/register_password.js"></script>