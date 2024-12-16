<?php
define('DB_SERVER', 'mysql.caesar.elte.hu');
define('DB_USERNAME', 'ubwrvy');
define('DB_PASSWORD', '39mh4DnXxWbGrGSH');
define('DB_NAME', 'ubwrvy');
 
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
if($link === false){
    die("HIBA: Nem lehetett csatlakozni: " . mysqli_connect_error());
}
?>