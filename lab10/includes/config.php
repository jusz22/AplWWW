<?php
    // Ustawienie parametrów połączenia z bazą danych
    $dbhost = 'localhost';     // Host bazy danych
    $dbuser = 'user';          // Nazwa użytkownika bazy danych
    $dbpass = '';              // Hasło do bazy danych (puste w tym przypadku)
    $dbaza = 'moja_strona';    // Nazwa bazy danych

    // Nawiązanie połączenia z bazą danych i zapisanie go w globalnym zasięgu
    $GLOBALS['link'] = mysqli_connect($dbhost, $dbuser, $dbpass, $dbaza);
    
    // Sprawdzenie, czy połączenie zostało poprawnie nawiązane
    if (!$GLOBALS['link']) echo "<b>przerywane połączenie</b>";
?>


<?php
    // Tablica modeli samochodów z kluczami i pełnymi nazwami
    $carModels = [
        'mazda_mx5' => 'Mazda MX-5',     // Klucz: mazda_mx5, Wartość: pełna nazwa
        'nissan_gtr' => 'Nissan GT-R',
        'mazda_rx7' => 'Mazda RX-7',
        'porsche_911' => 'Porsche 911',
        'nissan_z' => 'Nissan Z'
    ];
    
    // Bazowy adres URL strony
    $baseUrl = '/';

    // Dane logowania administratora
    $login = "admin";      // Nazwa użytkownika
    $pass = "password";    // Hasło
?>
