<?php
// het ww dat je wilt hashen
$wachtwoord = "ditiseentest";  

$gehasht_wachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);
// Toon het gehashte wachtwoord
echo "Gehasht wachtwoord: " . $gehasht_wachtwoord;
?>
