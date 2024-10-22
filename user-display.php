<?php
session_start();
include "db_conn.php";

// Check if the user is logged in
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
    // Get the logged-in user's data from the database
    $id = $_SESSION['id'];

    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT user_name, name, user_phoneNum FROM users WHERE userid = ?");
    $stmt->bind_param("i", $id);  // "i" denotes that the parameter is an integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_name = htmlspecialchars($row['user_name']);  // Escape output to prevent XSS
        $name = htmlspecialchars($row['name']);
        $phone = htmlspecialchars($row['user_phoneNum']); // Updated to match the new column name
    } else {
        echo "No user found!";
        exit();
    }

    $stmt->close(); // Close the prepared statement
} else {
    header("Location: login.php");  // Redirect to login if the user is not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Display</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 50px;
        }
        .user-info {
            background-color: #fff;
            padding: 20px;
            margin: 0 auto;
            width: 90%;
            max-width: 400px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        p {
            font-size: 18px;
            color: #666;
            margin: 10px 0;
        }
        a {
            text-decoration: none;
            color: #0066cc;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="user-info">
        <h2>User Information</h2>
        <p><strong>Name:</strong> <?php echo $name; ?></p>
        <p><strong>Username:</strong> <?php echo $user_name; ?></p>
        <p><strong>ID:</strong> <?php echo $id; ?></p>
        <p><strong>Phone Number:</strong> <?php echo $phone; ?></p>
        <br>
        <a href="logout.php">Logout</a>
    </div>

</body>
</html>

