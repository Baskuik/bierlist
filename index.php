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

if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = rand(1, 1000);
}
$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $beerId = intval($_POST['beer_id']);
    $rating = intval($_POST['rating']);

    $check_sql = "SELECT * FROM beers_rating WHERE user_id = ? AND beer_id = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ii", $user_id, $beerId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $insert_sql = "INSERT INTO beers_rating (user_id, beer_id, rating) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("iii", $user_id, $beerId, $rating);
        $stmt->execute();
    } else {
        $update_sql = "UPDATE beers_rating SET rating = ? WHERE user_id = ? AND beer_id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("iii", $rating, $user_id, $beerId);
        $stmt->execute();
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$sql = "SELECT beers.id, beers.name, beers.brewer, beers.type, beers.yeast, beers.perc, beers.purchase_price, 
               IFNULL(AVG(beers_rating.rating), 0) AS avg_rating
        FROM beers
        LEFT JOIN beers_rating ON beers.id = beers_rating.beer_id
        GROUP BY beers.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beer List</title>
    <style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
        text-align: center;
    }

    .container {
        max-width: 9000px;
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
        margin: 10px;
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

    .rating {
        display: flex;
        justify-content: center;
        gap: 5px;
    }

    .stars {
        cursor: pointer;
        font-size: 25px;
        color: gray;
    }

    .stars:hover,
    .stars:hover ~ .stars,
    .selected {
        color: gold;
    }
    </style>
    <script>
    function setRating(beerId, rating) {
        document.getElementById('rating-' + beerId).value = rating;
        document.getElementById('form-' + beerId).submit();
    }

    function highlightStars(beerId, stars) {
        let starsList = document.querySelectorAll(".star-" + beerId);
        starsList.forEach((star, index) => {
            star.classList.toggle("selected", index < stars);
        });
    }
    </script>
</head>
<body>
    <div class="container">
        <h1>🍺 Beer List</h1>

        <a href="top10.php" class="btn">🏆 Top 10 Bieren</a>
        <a href="top10_brouwers.php" class="btn">🍻 Top 10 Brouwers</a>
        <a href="populaire_types.php" class="btn">📊 Populaire Bier Types</a>
        <a href="meest_beoordeeld.php" class="btn">🔥 Meest Beoordeeld</a>

        <?php
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr>
                    <th>ID</th>
                    <th>Naam</th>
                    <th>Brouwer</th>
                    <th>Type</th>
                    <th>Gist</th>
                    <th>Alcohol (%)</th>
                    <th>Prijs (€)</th>
                    <th>Gemiddelde Beoordeling</th>
                    <th>Jouw Beoordeling</th>
                  </tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row["id"]}</td>
                        <td>" . htmlspecialchars($row["name"]) . "</td>
                        <td>" . htmlspecialchars($row["brewer"]) . "</td>
                        <td>" . htmlspecialchars($row["type"]) . "</td>
                        <td>" . htmlspecialchars($row["yeast"]) . "</td>
                        <td>{$row["perc"]}%</td>
                        <td>€" . number_format($row["purchase_price"], 2) . "</td>
                        <td>" . number_format($row["avg_rating"], 1) . " ⭐</td>
                        <td>
                            <form method='POST' id='form-{$row["id"]}'>
                                <input type='hidden' name='beer_id' value='{$row["id"]}'>
                                <input type='hidden' name='rating' id='rating-{$row["id"]}' value='0'>
                                <div class='rating'>
                                    <span class='stars star-{$row["id"]}' onclick='setRating({$row["id"]}, 1)'>⭐</span>
                                    <span class='stars star-{$row["id"]}' onclick='setRating({$row["id"]}, 2)'>⭐</span>
                                    <span class='stars star-{$row["id"]}' onclick='setRating({$row["id"]}, 3)'>⭐</span>
                                    <span class='stars star-{$row["id"]}' onclick='setRating({$row["id"]}, 4)'>⭐</span>
                                    <span class='stars star-{$row["id"]}' onclick='setRating({$row["id"]}, 5)'>⭐</span>
                                </div>
                            </form>
                        </td>
                      </tr>";
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
