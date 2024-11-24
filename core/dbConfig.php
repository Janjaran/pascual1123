<?php 

$host = "localhost";
$user = "root";
$password = "";
$PASCUAL1123 = "PASCUAL1123";
$dsn = "mysql:host={$host};dbname={$PASCUAL1123}";

$pdo = new PDO($dsn,$user,$password);
$pdo->exec("SET time_zone = '+08:00';");
date_default_timezone_set('Asia/Manila');

?>