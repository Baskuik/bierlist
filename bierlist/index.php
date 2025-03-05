    <?php
    session_start(); // Start sessie om gebruikers te identificeren

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bierlist";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Verbinding mislukt: " . $conn->connect_error);
    }

    // Simuleer ingelogde gebruiker (in een echt systeem haal je dit uit de database)
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['user_id'] = rand(1, 1000); // Simuleer een willekeurige gebruiker
    }
    $user_id = $_SESSION['user_id'];

    // Haal de bieren op en check of de gebruiker al heeft geliked
    $sql = "SELECT id, name, brewer, type, yeast, perc, purchase_price, stars FROM beers";
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

    
        .like-btn, .unlike-btn {
            border: none;
            padding: 8px 14px;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s, transform 0.1s;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

    
        .like-btn {
            background-color: #27ae60;
            color: white;
        }

        .like-btn:hover {
            background-color: #2ecc71;
            transform: scale(1.05);
        }

        
        .unlike-btn {
            background-color: #c0392b;
            color: white;
        }

        .unlike-btn:hover {
            background-color: #e74c3c;
            transform: scale(1.05);
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
                        <th>Naam</th>
                        <th>Brouwer</th>
                        <th>Type</th>
                        <th>Gist</th>
                        <th>Alcohol (%)</th>
                        <th>Prijs (€)</th>
                        <th>Rating</th>
                        <th>Actie</th>
                    </tr>";

                while ($row = $result->fetch_assoc()) {
                    $beerId = $row["id"];
                    echo "<tr>
                            <td>{$row["id"]}</td>
                            <td>" . htmlspecialchars($row["name"]) . "</td>
                            <td>" . htmlspecialchars($row["brewer"]) . "</td>
                            <td>" . htmlspecialchars($row["type"]) . "</td>
                            <td>" . htmlspecialchars($row["yeast"]) . "</td>
                            <td>{$row["perc"]}%</td>
                            <td>€" . number_format($row["purchase_price"], 2) . "</td>
                            <td>{$row["stars"]}</td>
                            <td>
                                <form method='post'>
                                </select>
                                <button type='submit'>Beoordeel</button>
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