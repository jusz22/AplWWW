<?php
$title = "Moje Hobby";
$currentPage = basename($_SERVER['PHP_SELF']);
include 'includes/config.php';
include 'includes/header.php';
?>

<img src="img/mainimg.png" class="mainimg" alt="mainpic">

<?php include 'includes/navigation.php'; ?>

<main>
    <section>
        <h1>Moim hobby są samochody</h1>
        <p>Na stronie można znaleźć moje ulubione modele samochodów.</p>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
