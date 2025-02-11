<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bierlist";

// Maak verbinding
$conn = new mysqli($servername, $username, $password, $dbname);

// Controleer verbinding
if ($conn->connect_error) {
  die("Verbinding mislukt: " . $conn->connect_error);
}

$sql = "SELECT id, name, brewer, type, yeast, perc, purchase_price, like_count FROM beers";
$result = $conn->query($sql);

echo "<style>
        .beer-item {
          border: 2px solid black;
          padding: 10px;
          margin: 10px 0;
          border-radius: 5px;
          background-color: #f8f8f8;
          display: block;
        }
      </style>";

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo "<div class='beer-item'>";
    echo "<strong>ID:</strong> " . $row["id"] . "<br>";
    echo "<strong>Name:</strong> " . $row["name"] . "<br>";
    echo "<strong>Brewer:</strong> " . $row["brewer"] . "<br>";
    echo "<strong>Type:</strong> " . $row["type"] . "<br>";
    echo "<strong>Yeast:</strong> " . $row["yeast"] . "<br>";
    echo "<strong>Percentage:</strong> " . $row["perc"] . "%<br>";
    echo "<strong>Price:</strong> €" . $row["purchase_price"] . "<br>";
    echo "<strong>Like count:</strong> " . $row["like_count"] . "<br>";
    echo "</div>";
  }
} else {
  echo "Geen resultaten gevonden";
}

$conn->close();
?>
