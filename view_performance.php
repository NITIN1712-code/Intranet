<?php
include 'db_conn.php';

// Fetch employees for the dropdown
$employees_result = $conn->query("SELECT id, CONCAT(first_name, ' ', last_name) AS full_name FROM employees");

// Initialize variables
$reviews = [];
$selected_employee = "";
$selected_month = "";
$selected_year = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $employee_id = $_POST['employee_id'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    
    $selected_employee = $employee_id;
    $selected_month = $month;
    $selected_year = $year;

    // Query to get the reviews for the selected employee and month/year
    $stmt = $conn->prepare("SELECT description, dateLogged FROM employee_reviwes WHERE employee_id = ? AND MONTH(dateLogged) = ? AND YEAR(dateLogged) = ?");
    $stmt->bind_param("iii", $employee_id, $month, $year);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch all reviews for the selected employee and month/year
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $reviews[] = [
                'description' => htmlspecialchars($row['description']),
                'dateLogged' => $row['dateLogged']
            ];
        }
    } else {
        // No reviews found message
        $reviews[] = "No reviews found for the specified month and year.";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Employee Performance Review</title>
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

        select, input[type="number"] {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 14px;
            margin-bottom: 15px;
            box-sizing: border-box;
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

        .review-message {
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
        }

    </style>
</head>
<body>

<header>
    <img src="images/g2.jpg" alt="Explore Mauritius Logo" class="logo" />
    <h1>View Employee Performance Review</h1>
</header>

<div class="container">
    <div class="form-container">
        <h2>View Employee Performance Review for <?php echo $selected_month ? $monthNames[$selected_month] . ' ' . $selected_year : date('F Y'); ?></h2>

        <!-- Form starts here -->
        <form method="POST" action="">
            <label for="employee_id">Select Employee:</label>
            <select name="employee_id" id="employee_id" required>
                <option value="">-- Select an Employee --</option>
                <?php if ($employees_result->num_rows > 0): ?>
                    <?php while($row = $employees_result->fetch_assoc()): ?>
                        <option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $selected_employee) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($row['full_name']); ?>
                        </option>
                    <?php endwhile; ?>
                <?php endif; ?>
            </select>

            <label for="month">Enter Month (1-12):</label>
            <input type="number" name="month" id="month" min="1" max="12" value="<?php echo $selected_month; ?>" required>
            <br><br>

            <label for="year">Enter Year:</label>
            <input type="number" name="year" id="year" min="2000" max="<?php echo date('Y'); ?>" value="<?php echo $selected_year; ?>" required>
            <br><br>

            <button type="submit">View Review</button>
        </form>

        <!-- Display the performance review message(s) -->
        <?php if (!empty($reviews)): ?>
            <div class="review-message">
                <h3>Performance Reviews:</h3>
                <?php foreach ($reviews as $review): ?>
                    <p><?php echo is_array($review) ? "<strong>Date:</strong> " . $review['dateLogged'] . "<br><strong>Review:</strong> " . $review['description'] : $review; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>

