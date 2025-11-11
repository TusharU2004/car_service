<?php
$servername = getenv('DB_HOST') ?: 'localhost';   // Replace with your database server name if different
$username = getenv('DB_USER') ?: 'root';          // Replace with your database username
$password = getenv('DB_PASS') ?: '';              // Replace with your database password
$dbname = getenv('DB_NAME') ?: 'car_rental_db';   // Replace with your database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>