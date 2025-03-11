<?php
include "connect.php";
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .login-container {
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 300px;
        }
        .login-container h2 {
            text-align: center;
        }
        .login-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .login-container button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .login-container button:hover {
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
    <div class="login-container">
        <h2>Inloggen</h2>
        <?php if (isset($_GET['error'])) { ?>
     	<b style="color: #f00;"><?=$_GET['error']?></b><br>
      <?php } ?>
        <form id="inloggen" method="post" action="/login">
            <input type="text" placeholder="Email" name="email" id="email" required>
            <input type="password" placeholder="Wachtwoord" name="password" id="password" required>
            <input type ="submit" value="Login" id="submit"></input>
        </form>
    </div>
</body>
</html>
