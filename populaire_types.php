<?php
session_start(); 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bierlist";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

$sql = "SELECT beers.type, COUNT(beers_rating.id) AS aantal_beoordelingen
        FROM beers
        LEFT JOIN beers_rating ON beers.id = beers_rating.beer_id
        GROUP BY beers.type
        ORDER BY aantal_beoordelingen DESC
        LIMIT 10";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Populaire Bier Types</title>
    <style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
        text-align: center;
    }

    .container {
        max-width: 900px;
        margin: auto;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        color: #d35400;
        margin-bottom: 20px;
    }

    .btn {
        display: inline-block;
        margin-bottom: 20px;
        padding: 10px 15px;
        background-color: #d35400;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        transition: 0.3s;
    }

    .btn:hover {
        background-color: #b03a00;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: left;
    }

    th {
        background-color: #d35400;
        color: white;
        font-size: 16px;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #f1f1f1;
    }
    </style>
</head>
<body>
    <div class="container">
        <h1>🍺 Populaire Bier Types 🍺</h1>

        <a href="index.php" class="btn">⬅️ Terug naar Beer List</a>

        <?php
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr>
                    <th>🏅 #</th>
                    <th>Biertype</th>
                    <th>Aantal Beoordelingen</th>
                  </tr>";

            $rank = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$rank}</td>
                        <td>" . htmlspecialchars($row["type"]) . "</td>
                        <td>{$row["aantal_beoordelingen"]}</td>
                      </tr>";
                $rank++;
            }
            echo "</table>";
        } else {
            echo "<p>Geen resultaten gevonden</p>";
        }
        $conn->close();
        ?>
    </div>
</body>
</html>
