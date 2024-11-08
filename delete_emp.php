<?php
// Include your database connection file
include 'db_conn.php'; // Make sure 'db_conn.php' is correctly set up

// Query to select all employees
$sql = "SELECT id, first_name, last_name FROM employees";
$result = $conn->query($sql);

if (!$result) {
    die("Error fetching employees: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Employee</title>
    <style>
        /* General Page Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Header */
        header {
            background-color: #ffffff;
            color: #00a88f;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        .logo {
            max-width: 150px;
            height: auto;
        }

        header img {
            max-width: 100px;
            height: auto;
        }

        /* Centered Form Container */
        .form-container {
            width: 100%;
            max-width: 500px;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
            text-align: left;
        }

        h2 {
            color: #00a88f;
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            color: #333;
            margin: 10px 0 5px;
        }

        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #00a88f;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #008f76;
        }
    </style>
</head>
<body>

<header>
    <img src="images/g2.jpg" alt="Explore Mauritius Logo" class="logo" />
    <h1>Delete Employee</h1>
</header>

<div class="form-container">
    <h2>Delete Employee</h2>
    <form action="delete_emp_process.php" method="POST">
        <label for="employee_id">Select Employee to Delete:</label>
        <select name="employee_id" id="employee_id" required>
            <option value="">--Select Employee--</option>
            <?php
            // Populate the dropdown with employee data
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['first_name']} {$row['last_name']}</option>";
                }
            } else {
                echo "<option value=''>No employees found</option>";
            }
            ?>
        </select>
        <button type="submit">Delete Employee</button>
    </form>
</div>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>