<?php
// Define database connection parameters
$servername = "localhost"; // Server name or IP address
$username = "root"; // Username for database access
$password = ""; // Password for database access
$dbname = "ssrf"; // Name of the database to connect to

// Create a new mysqli object to establish a database connection
$conn = new mysqli($servername, $username, $password, $dbname);
?>