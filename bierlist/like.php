<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "like.php is being accessed.<br>";

// Check request method
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Error: This script only accepts POST requests.");
}

// Check if 'id' is sent
if (!isset($_POST["id"])) {
    die("Error: Missing beer ID.");
}

echo "Received beer ID: " . $_POST["id"];
?>



<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bierlist";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $beerId = intval($_POST["id"]);

    // Increment like count
    $sql = "UPDATE beers SET like_count = like_count + 1 WHERE id = $beerId";
    $conn->query($sql);

    // Fetch updated like count
    $result = $conn->query("SELECT like_count FROM beers WHERE id = $beerId");
    $row = $result->fetch_assoc();
    
    echo $row["like_count"]; // Return new like count
}

$conn->close();
?>
