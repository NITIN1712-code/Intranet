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
</head>
<body>

<h2>Employee Performance Review</h2>

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
    <br><br>

    <label for="description">Performance Review:</label>
    <textarea name="description" id="description" maxlength="255" required></textarea>
    <br><br>

    <button type="submit">Submit Review</button>
</form>

</body>
</html>