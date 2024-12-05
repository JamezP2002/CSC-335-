<?php
// Database credentials
$host = 'localhost';     // Database host (usually localhost)
$dbname = 'cdkey_db';      // Name of your database
$username = 'root';      // Database username (default is root for local setups)
$password = '';          // Database password (leave empty for local setups)

// Create a connection using MySQLi
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
