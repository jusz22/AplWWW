<?php
// Ustawienie tytułu strony
$title = "Moje Hobby";

// Pobranie nazwy aktualnie wykonywanego pliku PHP
$currentPage = basename($_SERVER['PHP_SELF']);

// Dołączenie pliku nagłówka strony
include 'includes/header.php';

// Dołączenie pliku konfiguracyjnego z ustawieniami połączenia z bazą danych
include 'includes/config.php';

// Dołączenie pliku z funkcją wyświetlania podstron
include 'showpage.php';
?>

<!-- Wyświetlenie głównego obrazu strony -->
<img src="img/mainimg.png" class="mainimg" alt="mainpic">

<?php 
    // Dołączenie pliku z nawigacją
    include 'includes/navigation.php'; 
?>

<!-- Główna sekcja treści strony -->
<main>
    <section>
        <?php 
            // Pobranie treści podstrony za pomocą funkcji PokazPodstrone()
            // Przekazanie nazwy aktualnej strony jako parametru
            $content = PokazPodstrone($currentPage);
            
            // Wyświetlenie pobranej treści
            echo $content;
        ?>
    </section>
</main>

<?php 
    // Dołączenie pliku stopki strony
    include 'includes/footer.php'; 
?>
