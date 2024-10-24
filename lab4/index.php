<?php 

$nr_indexu = '169250';
$nr_grupy = 'ISI2';

echo'Jan Juszkiewicz '.$nr_indexu.' grupa '.$nr_grupy.'<br/><br/>';

echo'Zastosowanie metody include()<br/>';

if ($nr_indexu < $nr_grupy) {
  echo "nr indexu < nr grupy<br\>";
}

for ($i = 1; $i <= 10; $i++) {
    echo "$i ";
    while($i <= 3) {
        echo $i++;
        echo ' ';
    }
}
echo'<br\>';
include 'test.html';
echo 'Hello ' . htmlspecialchars($_GET["name"]) . '!';
$name = $_POST['name'];
echo 'Hello ' . $name . '!';






?>