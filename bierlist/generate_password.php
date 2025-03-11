<?php
// Het wachtwoord dat je wilt hashen
$wachtwoord = "ditiseentest";  // Vervang dit door je werkelijke wachtwoord

// Hash het wachtwoord met password_hash
$gehasht_wachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);

// Toon het gehashte wachtwoord
echo "Gehasht wachtwoord: " . $gehasht_wachtwoord;
?>
