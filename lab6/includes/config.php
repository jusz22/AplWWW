<?php
    $dbhost = 'localhost';
    $dbuser = 'user';
    $dbpass = '';
    $dbaza = 'moja_strona';
    
    $GLOBALS['link'] = mysqli_connect($dbhost, $dbuser, $dbpass, $dbaza);
    if (!$GLOBALS['link']) echo "<b>przerywane połączenie</b>";


?>


<?php
    $carModels = [
        'mazda_mx5' => 'Mazda MX-5',
        'nissan_gtr' => 'Nissan GT-R',
        'mazda_rx7' => 'Mazda RX-7',
        'porsche_911' => 'Porsche 911',
        'nissan_z' => 'Nissan Z'
    ];
    
    $baseUrl = '/';

?>
