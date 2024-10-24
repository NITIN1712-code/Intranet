<?php
require("db_conn.php");

// Initialize message variable
$message = "";

// Create a user
if (isset($_POST['create_user'])) {
    $username = $_POST['username']; // Username for the new user
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashing the password
    $email = $_POST['email']; // Email for the new user
    $full_name = $_POST['full_name']; // Full name for the new user

    // Insert into users table
    $stmt = $conn->prepare("INSERT INTO users (username, password, email, full_name) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $password, $email, $full_name);

    if ($stmt->execute()) {
        $message = "User created successfully!";
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close(); // Close the main user creation statement
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <link rel="stylesheet" href="style.css"> <!-- Assuming you have a separate CSS file -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .message {
            color: green;
            margin-bottom: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 4px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        h1, h2 {
            color: #333;
        }

        
        /* Header */
        header {
            background-color: #ffffff; /* White */
            color: #00a88f; /* Apple Green */
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        /* Logo */
        .logo {
            max-width: 150px;
            height: auto;
        }
        header img {
            max-width: 100px; /* Adjust size as needed */
            height: auto;
        }

        header h1 {
            margin: 0;
            font-size: 36px;
        }
        .message {
            color: #2980b9; /* Message color */
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<header>
    <img src="images/g2.jpg" alt="Explore Mauritius Logo" class="logo" />
    <h1>Create User</h1>
</header>

    <!-- Display messages -->
    <?php if ($message): ?>
        <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="full_name">Full Name:</label>
        <input type="text" name="full_name" required>

        <input type="submit" name="create_user" value="Create User">
    </form>
</body>
</html>
