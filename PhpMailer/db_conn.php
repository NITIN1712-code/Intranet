<?php
$servername = 'localhost';
$port = 4306;
$username = 'root';
$password = '1234';
$dbname = 'tourop';
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}   

?>