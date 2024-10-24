<?php
// Include your database connection file
include 'db_conn.php'; // Update this line if your connection file has a different name

// Get data from POST request
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$position = $_POST['position'];
$hire_date = $_POST['hire_date'];
$salary = $_POST['salary'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security

// Prepare the SQL statement
$sql = "INSERT INTO employees (first_name, last_name, position, hire_date, salary, email, phone_number, username, password) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql); // Prepare the statement

if ($stmt) {
    // Bind parameters
    $stmt->bind_param("ssssdssss", $first_name, $last_name, $position, $hire_date, $salary, $email, $phone_number, $username, $password);
    
    // Execute the statement
    if ($stmt->execute()) {
        echo "New employee added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Error preparing statement: " . $conn->error;
}

// Close the database connection
$conn->close();
?>