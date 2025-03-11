<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "bierlist";

$conn = new mysqli($servername, $username, $password, $database);

// Controleer of de verbinding werkt
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}
?>
