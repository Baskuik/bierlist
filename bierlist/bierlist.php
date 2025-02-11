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

$sql = "SELECT id, name, brewer, type, yeast, perc, purchase_price, like_count FROM beers";
$result = $conn->query($sql);
if ($result->num_rows > 0) 
  echo "<style>
          .beer-item {
            border: 2px solid black;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            background-color: #f8f8f8;
          }
        </style>";

while($row = $result->fetch_assoc()) {
  echo "<div class='beer-item'>";
  echo "<strong> ID: </strong> " . $row["id"] ;
  echo "<strong> Name: </strong> " . $row["name"];
  echo "<strong> Brewer: </strong> " . $row["brewer"];
  echo "<strong> Type: </strong> " . $row["type"];
  echo "<strong> Yeast: </strong> " . $row["yeast"];
  echo "<strong> Percentage: </strong> " . $row["perc"] . "%";
  echo "<strong> Price: </strong> €" . $row["purchase_price"] ;
  echo "<strong> Like count: </strong> " . $row["like_count"];
  echo "</div>";
}
{
echo "Geen resultaten gevonden";
}
$conn->close();
?>