<?php
$host = "localhost:3308";       // Usually localhost
$user = "root";            // Default user in XAMPP or SQLYog
$pass = "";                // Leave empty if no password is set
$db = "library_db";        // Make sure it matches the DB name in SQLyog

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
