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

// Fetch beer data
$sql = "SELECT id, name, brewer, type, yeast, perc, purchase_price, like_count FROM beers";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beer List</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 20px;
            text-align: center;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
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
            background-color: #f2f2f2;
        }
        .like-btn {
            background-color: #27ae60;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }
        .like-btn:hover {
            background-color: #2ecc71;
        }
        .no-results {
            color: red;
            font-size: 18px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Beer List</h1>

        <?php
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Brewer</th>
                    <th>Type</th>
                    <th>Yeast</th>
                    <th>Percentage</th>
                    <th>Price (€)</th>
                    <th>Like Count</th>
                    <th>Action</th>
                  </tr>";
            
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["brewer"] . "</td>";
                echo "<td>" . $row["type"] . "</td>";
                echo "<td>" . $row["yeast"] . "</td>";
                echo "<td>" . $row["perc"] . "%</td>";
                echo "<td>€" . number_format($row["purchase_price"], 2) . "</td>";
                echo "<td id='like-count-".$row["id"]."'>" . $row["like_count"] . "</td>";
                echo "<td><button class='like-btn' onclick='likeBeer(".$row["id"].")'>❤️ Like</button></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='no-results'>Geen resultaten gevonden</p>";
        }
        $conn->close();
        ?>

    </div>

 

</body>
</html>
