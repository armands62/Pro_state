<?php
include_once("blocks/header.phtml");
?>
<main class="admin-home-main">
    <?php
    if(isset($_SESSION['err_msg'])) {
        echo $_SESSION['err_msg'];
        unset($_SESSION['err_msg']);
    }
    ?>
    <div class="admin-home-container">
        <h1>Administratoru lapa</h1>
        <p>Jūsu administratora līmenis: <?php echo $_SESSION['admin'];?></p>
    </div> 
</main>
<?php
include_once("blocks/footer.phtml");