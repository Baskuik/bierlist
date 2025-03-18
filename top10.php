<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bierlist";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

// Top 10 bieren ophalen
$sql = "SELECT beers.name, beers.brewer, beers.type, beers.perc, beers.purchase_price, 
               AVG(beers_rating.rating) AS avg_rating, GROUP_CONCAT(beers_rating.note SEPARATOR ' | ') AS notes
        FROM beers
        LEFT JOIN beers_rating ON beers.id = beers_rating.beer_id
        GROUP BY beers.id
        ORDER BY avg_rating DESC
        LIMIT 10";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top 10 Bieren</title>
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
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        a {
            display: inline-block;
            margin: 10px 0;
            padding: 10px 15px;
            background-color: #d35400;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }

        a:hover {
            background-color: #b03a00;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Top 10 Bieren 🍻</h1>
        <a href="index.php" class="btn">⬅️ Terug naar Beer List</a>
        <table>
            <tr>
                <th>Naam</th>
                <th>Brouwer</th>
                <th>Alcohol (%)</th>
                <th>Gemiddelde Beoordeling</th>
                <th>Notities</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row["name"]) ?></td>
                    <td><?= htmlspecialchars($row["brewer"]) ?></td>
                    <td><?= $row["perc"] ?>%</td>
                    <td><?= number_format($row["avg_rating"], 1) ?> ⭐</td>
                    <td><?= htmlspecialchars($row["notes"]) ?: "Geen notities" ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
