<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bierlist"; // De naam van de database

// Maak verbinding
$conn = new mysqli($servername, $username, $password, $dbname);

// Controleer de verbinding
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}
?>
