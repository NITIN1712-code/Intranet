<?php
// Include the database connection
include 'db_connection.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $position = $_POST['position'];
    $hire_date = $_POST['hire_date'];
    $salary = $_POST['salary'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];

    // Insert the new employee into the database
    $query = "INSERT INTO employees (first_name, last_name, position, hire_date, salary, email, phone_number)
              VALUES ('$first_name', '$last_name', '$position', '$hire_date', '$salary', '$email', '$phone_number')";

    if ($conn->query($query) === TRUE) {
        // Redirect back to the admin dashboard with a success message
        header("Location: admin_dashboard.php?success=1");
        exit();
    } else {
        // Redirect back to the admin dashboard with an error message
        header("Location: admin_dashboard.php?error=1");
        exit();
    }
} else {
    // If the form wasn't submitted, redirect back to the admin dashboard
    header("Location: admin_dashboard.php");
    exit();
}
