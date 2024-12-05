<?php require_once 'includes/config.php'; ?>

<?php


function FormularzLogowania()
{
   $wynik = 
   '<div class="logowanie">
       <h1 class="heading">Panel logowania</h1>
       <div class="logowanie">
       <form method="post" name="loginForm" enctype="multipart/form-data" action="'.($_SERVER["REQUEST_URI"]).'">
           <table class="logowanie">
               <tr><td class="log4_t">[email]</td><td><input type="text" name="login_email" class ="logowanie" /></td></tr>
               <tr><td class="log4_t">[haslo]</td><td><input type="password" name="login_pass" class ="logowanie" /></td></tr>
               <tr><td>&nbsp;</td><td><input type="submit" name="x1_submit" class="logowanie" value="Zaloguj" /></td></tr>
           </table>
       </form>
       </div>
   </div>';

   return $wynik;
}


session_start();

if (isset($_POST['x1_submit'])) {
    $login_email = $_POST['login_email'];
    $login_pass = $_POST['login_pass'];

    if ($login_email === $login && $login_pass === $pass) {
        $_SESSION['logged_in'] = true;
        $_SESSION['user_email'] = $login_email;

    } else {
        echo "Błędny login lub hasło.";
        echo FormularzLogowania();
    }
} else {

    echo FormularzLogowania();
}

$query = "SELECT * FROM page_list ORDER BY id DESC LIMIT 100";
$result = mysqli_query($GLOBALS['link'], $query);

$grow = '';
$row = mysqli_fetch_array($result);
echo $row['page_title'];
while($row = mysqli_fetch_array($result))
{
    $grow .= '<id>'. $row['id'] .'</id><tytul>'. $row['page_title'] .'</tytul><br />';
}


?>