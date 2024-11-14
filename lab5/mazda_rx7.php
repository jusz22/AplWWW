<?php
$currentPage = basename($_SERVER['PHP_SELF']);
include 'includes/config.php';
include 'includes/header.php';
?>

<?php include 'includes/navigation.php'; ?>

<main>
    <section>
        <?php 
            $contentFile = 'content/' . htmlspecialchars($currentPage) . '.php';
            if (file_exists($contentFile)) {
                include $contentFile;
            } else {
                echo "Content not found";
            }
        ?>
    </section>
</main>

<?php include 'includes/footer.php'; ?>