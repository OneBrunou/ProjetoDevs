<?php
$host = 'localhost';
$dbname = 'db_loja_carros';
$username = 'root';
$password = '12345678'; 
$cmd= new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
?>