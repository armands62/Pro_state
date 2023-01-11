<?php
include_once("blocks/header.phtml");
?>
<main class="home-main">
    <?php
    if(isset($_SESSION['err_msg'])) {
        echo $_SESSION['err_msg'];
        unset($_SESSION['err_msg']);
    }
    ?>
    <h1>Administratoru lapa</h1>
    <p>Jūsu administratora līmenis: <?php echo $_SESSION['admin'];?></p>
</main>
<?php
include_once("blocks/footer.phtml");