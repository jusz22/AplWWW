<?php
$currentPage = basename($_SERVER['PHP_SELF']);
include 'includes/config.php';
include 'includes/header.php';
include 'showpage.php';
?>

<?php include 'includes/navigation.php'; ?>

<main>
    <section>
        <?php 
            $content = PokazPodstrone($currentPage);
            echo $content;
        ?>
    </section>
</main>

<?php include 'includes/footer.php'; ?>