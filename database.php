<?php
$host = "localhost";
$username = "root"; // Default username
$password = "MySQLSrB123*8";
$database = "hap_database";

// Create a connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
