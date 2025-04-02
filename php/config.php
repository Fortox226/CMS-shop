<?php
$host = "localhost";
$dbname = "cms";
$user = "root"; 
$pass = ""; 

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Błąd połączenia: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>