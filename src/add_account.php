<?php
include_once("blocks/header.phtml");
?>
<link href="src/css/adaptive.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" href="src/css/add_accounts.css" type="text/css">
<div class="add-account-main">
    <?php
    if(!empty($_SESSION["login_err_msg"])){
        echo "<p class='login-error'>{$_SESSION["login_err_msg"]}</p>";
        unset($_SESSION["login_err_msg"]);
    }
    ?>
    <div class="add-accounts-container">
    <form action="/create_account" method="POST" class="add-account-form">
        <div id="add-acc-name">
            <label for="name" class="add-acc-aname">Konta nosaukums</label>
            <input type="text" name="name" placeholder="Konta nosaukums" id="name" class="add-acc-input" required>
        </div>

        <div id="add-acc-limit">
        <label for="daily-limit" class="add-acc-daylimit">Dienas limits</label>
        <input type="number" name="daily-limit" value="35" id="daily-limit" min="10" max="300" class="add-acc-input" required>
        </div>

        <div id="add-acc-mlimit">
        <label for="monthly-limit" class="add-acc-monthlimit">Mēneša limits</label>
        <input type="number" name="monthly-limit" value="500" id="monthly-limit" min="100" max="5000" class="add-acc-input" required>
        </div>

        <div class="add-acc-b">
        <input type="submit" value="Izveidot kontu" class="add-acc-submit">
        </div>
    </form>
    </div>
</div>

<?php
include_once("blocks/footer.phtml");
