<?php
include 'db_conn.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $employee_id = $_POST['employee_id'];
    $description = $_POST['description'];
    $dateLogged = date('Y-m-d');  // Current date

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("INSERT INTO employee_reviwes (employee_id, dateLogged, description) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $employee_id, $dateLogged, $description);

    if ($stmt->execute()) {
        echo "Review added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch employees for the dropdown
$employees_result = $conn->query("SELECT id, CONCAT(first_name, ' ', last_name) AS full_name FROM employees");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Performance Review</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #ffffff;
            color: #00a88f;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        header img {
            max-width: 100px;
            height: auto;
        }

        header h1 {
            margin: 10px 0;
            font-size: 36px;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
            background-color: #ffffff;
        }

        .form-container {
            width: 40%;
            background-color: #f9f9f9;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            text-align: center;
            color: #2980b9;
            font-size: 24px;
            margin-bottom: 20px;
        }

        label {
            font-size: 16px;
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
        }

        select, textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 14px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
            height: 150px;
        }

        button {
            width: 100%;
            background-color: #00a88f;
            color: white;
            padding: 12px;
            font-size: 16px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #3498db;
        }

        .message {
            text-align: center;
            color: green;
            margin-top: 20px;
        }

    </style>
</head>
<body>

<header>
    <img src="images/g2.jpg" alt="Explore Mauritius Logo" class="logo" />
    <h1>Employee Performance Review</h1>
</header>

<div class="container">
    <div class="form-container">
        <h2>Submit a Performance Review For The Current Month</h2>

        <!-- Form starts here -->
        <form method="POST" action="">
            <label for="employee_id">Select Employee:</label>
            <select name="employee_id" id="employee_id" required>
                <option value="">-- Select an Employee --</option>
                <?php if ($employees_result->num_rows > 0): ?>
                    <?php while($row = $employees_result->fetch_assoc()): ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['full_name']); ?></option>
                    <?php endwhile; ?>
                <?php endif; ?>
            </select>

            <label for="description">Performance Review:</label>
            <textarea name="description" id="description" maxlength="255" required></textarea>

            <button type="submit">Submit Review</button>
        </form>

        <!-- Success or Error message -->
        <?php if ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
            <div class="message">
                <?php echo isset($stmt) && $stmt->execute() ? 'Review added successfully!' : 'Error: ' . $stmt->error; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
