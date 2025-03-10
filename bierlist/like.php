<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    exit(json_encode(["error" => "Niet ingelogd"]));
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bierlist";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    exit(json_encode(["error" => "Databasefout"]));
}

$user_id = $_SESSION['user_id'];
$beer_id = $_POST['beer_id'];
$like = $_POST['like'] === "true";

if ($like) {
    $stmt = $conn->prepare("INSERT IGNORE INTO beer_likes (user_id, beer_id) VALUES (?, ?)");
} else {
    $stmt = $conn->prepare("DELETE FROM beer_likes WHERE user_id = ? AND beer_id = ?");
}
$stmt->bind_param("ii", $user_id, $beer_id);
$stmt->execute();

$result = $conn->query("SELECT COUNT(*) AS like_count FROM beer_likes WHERE beer_id = $beer_id");
$row = $result->fetch_assoc();

echo json_encode(["like_count" => $row["like_count"], "user_liked" => $like]);

$stmt->close();
$conn->close();
?>
