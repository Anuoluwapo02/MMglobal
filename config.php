<?php
// Database configuration for MM Global

$host = "localhost";        // usually 'localhost'
$user = "root";             // your MySQL username
$pass = "";                 // your MySQL password (leave empty if none)
$dbname = "mm_global";      // your database name

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: set character encoding
$conn->set_charset("utf8mb4");

// You can include this file in other PHP scripts like this:
// include 'config.php';
?>
