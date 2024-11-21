<?php
require_once 'includes/config.php';

function PokazPodstrone($alias)
{
   $aliasClean = htmlspecialchars($alias);
   $query = "SELECT * FROM page_list WHERE alias='$aliasClean' LIMIT 1";
   $result = mysqli_query($GLOBALS['link'], $query);

   if (mysqli_num_rows($result) == 0)
   {
       $web = "[nie_znaleziono_strony]";
   }
   else
   {
       $row = mysqli_fetch_assoc($result);
       $web = $row['page_content'];
   }

   return $web;
}


?>