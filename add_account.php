<?php
include_once("blocks/header.phtml");
?>
<main>
    <?php
    if(!empty($_SESSION["login_err_msg"])){
        echo "<p class='login-error'>{$_SESSION["login_err_msg"]}</p>";
        unset($_SESSION["login_err_msg"]);
    }
    ?>
    <form action="backend/create_account.php" method="POST">
        <label for="name">Konta nosaukums</label>
        <input type="text" name="name" placeholder="Konta nosaukums" id="name" required>

        <label for="daily-limit">Dienas limits</label>
        <input type="number" name="daily-limit" value="35" id="daily-limit" min="10" max="300" required>

        <label for="monthly-limit">Mēneša limits</label>
        <input type="number" name="monthly-limit" value="500" id="monthly-limit" min="100" max="5000" required>

        <input type="submit" value="Izveidot kontu" id="submit">
    </form>
</main>

<?php
include_once("blocks/footer.phtml");
