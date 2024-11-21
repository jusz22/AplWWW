<?php
$title = "Moje Hobby";
$currentPage = basename($_SERVER['PHP_SELF']);
include 'includes/header.php';
include 'includes/config.php';
include 'showpage.php';
?>

<img src="img/mainimg.png" class="mainimg" alt="mainpic">

<?php 
    include 'includes/navigation.php'; 
?>

<main>
    <section>
        <?php 
            $content = PokazPodstrone($currentPage);
            echo $content;
        ?>
    </section>
</main>


<?php include 'includes/footer.php'; ?>
