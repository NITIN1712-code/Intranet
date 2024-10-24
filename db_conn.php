<?php
$host = 'localhost';
$port = 3306;
$username = 'root';
$password = '';
$dbname = 'tourop';

// Create connection
$conn = new mysqli($host, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}   

?>
