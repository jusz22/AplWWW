<?php
// Dołączenie pliku konfiguracyjnego z ustawieniami połączenia z bazą danych
require_once 'includes/config.php';

/**
 * Funkcja pobierająca treść podstrony z bazy danych na podstawie jej aliasu
 * 
 * @param string $alias Alias strony do wyszukania
 * @return string Treść strony lub komunikat o braku strony
 */
function PokazPodstrone($alias)
{
   // Oczyszczenie aliasu ze znaków specjalnych, aby zapobiec atakom XSS
   $aliasClean = htmlspecialchars($alias);
   
   // Przygotowanie zapytania SQL do pobrania strony o podanym aliasie
   $query = "SELECT * FROM page_list WHERE alias='$aliasClean' LIMIT 1";
   
   // Wykonanie zapytania do bazy danych
   $result = mysqli_query($GLOBALS['link'], $query);

   // Sprawdzenie, czy znaleziono stronę
   if (mysqli_num_rows($result) == 0)
   {
       // Jeśli nie znaleziono strony, zwróć komunikat
       $web = "[nie_znaleziono_strony]";
   }
   else
   {
       // Pobranie pierwszego (i jedynego) wyniku z bazy danych
       $row = mysqli_fetch_assoc($result);
       
       // Przypisanie treści strony do zmiennej
       $web = $row['page_content'];
   }

   // Zwrócenie treści strony lub komunikatu
   return $web;
}
?>