<?php
// Database connection variables
$host = 'localhost'; // Your database host
$port = 4306;        // Your MySQL port
$username = 'root';  // Your MySQL username
$password = '1234';      // Your MySQL password
$dbname = 'tourop'; // Replace with your database name

// Create connection
$conn = new mysqli($host, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

// Close the connection when done

?>
