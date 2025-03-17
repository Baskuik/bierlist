<?php
include "connect.php";

//variabelen voor foutmeldingen
$fout = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $adres = $_POST['adres'];
    $email = $_POST['email'];
    $wachtwoord = $_POST['password'];

    // checkt of het wachtwoord minimaal 12 tekens heeft
    if (strlen($wachtwoord) < 12) {
        $fout = "Wachtwoord moet minimaal 12 tekens bevatten.";
    }

    //checkt of het e-mailadres al bestaat in de database
    $query = "SELECT * FROM gebruikers WHERE email = '$email'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $fout = "Dit e-mailadres is al in gebruik.";
    }

    //wnr geen fout is gevonden, wordt het wachtwoord gehashed en de gebruikers table toegevoegd
    if (empty($fout)) {
        //hash het wachtwoord
        $hashedWachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);

        //gebruiker toevoegen
        $query = "INSERT INTO gebruikers (voornaam, achternaam, adres, email, password)
                  VALUES ('$voornaam', '$achternaam', '$adres', '$email', '$hashedWachtwoord')";

        if ($conn->query($query) === TRUE) {
            echo "Registratie succesvol! Je kunt nu inloggen.";
        } else {
            $fout = "Er is iets misgegaan bij de registratie: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .registration-container {
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 300px;
        }
        .registration-container h2 {
            text-align: center;
        }
        .registration-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .registration-container button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .registration-container button:hover {
            background: #218838;
        }
        #submit{
            background-color: lightgreen;
            color: white;
        }
        #submit:hover{
            background-color: darkgreen;
        }
    </style>
</head>
<body>
    <div class="registration-container">
        <h2>Registreren</h2>
        <?php if (!empty($fout)) { ?>
     	<b style="color: #f00;"><?php echo $fout; ?></b><br>
      <?php } ?>
        <form method="POST" action="registration.php">
            <input type="text" placeholder="Voornaam" name="voornaam" required>
            <input type="text" placeholder="Achternaam" name="achternaam" required>
            <input type="text" placeholder="Adres" name="adres" required>
            <input type="email" placeholder="Email" name="email" required>
            <input type="password" placeholder="Wachtwoord" name="password" required>
            <input type="submit" value="Registreren" id="submit">
            <a href="login.php">Login</a>
        </form>
    </div>
</body>
</html>
