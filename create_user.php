<?php
// db_conn.php
// Database connection file
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'tourop';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// main page
require("db_conn.php");

$message = ""; // Initialize message variable

// Create a new user if form submitted
if (isset($_POST['create_user'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $full_name = $_POST['full_name'];

    // Check if username or email already exists
    $check_user = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $check_user->bind_param("ss", $username, $email);
    $check_user->execute();
    $check_user_result = $check_user->get_result();

    if ($check_user_result->num_rows > 0) {
        $message = "Username or email already exists!";
    } else {
        // Insert new user into users table
        $stmt = $conn->prepare("INSERT INTO users (username, password, email, full_name) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $password, $email, $full_name);

        if ($stmt->execute()) {
            $message = "User created successfully!";
        } else {
            $message = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
    $check_user->close();
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
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .message { color: green; margin-bottom: 20px; }
        form { margin-bottom: 20px; }
        label { display: block; margin: 10px 0 5px; }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #4CAF50; color: white; border: none; padding: 10px 15px; cursor: pointer; border-radius: 4px;
        }
        input[type="submit"]:hover { background-color: #45a049; }
        h1, h2 { color: #333; }

        /* Header */
        header {
            background-color: #ffffff; color: #00a88f; padding: 20px; text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .logo { max-width: 150px; height: auto; }
        header img { max-width: 100px; height: auto; }
        header h1 { margin: 0; font-size: 36px; }
    </style>
</head>
<body>

<header>
    <img src="images/g2.jpg" alt="Explore Mauritius Logo" class="logo" />
    <h1>Create User</h1>
</header>

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
