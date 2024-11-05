<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    <link rel="stylesheet" href="dashboard.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="form-container">
        <h2>Add Employee</h2>
        <form action="add_emp_process.php" method="POST">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required>

            <label for="position">Position:</label>
            <input type="text" id="position" name="position" required>

            <label for="hire_date">Hire Date:</label>
            <input type="date" id="hire_date" name="hire_date" required>

            <label for="salary">Salary:</label>
            <input type="number" id="salary" name="salary" required>

            <label for="address">Address:</label>
            <input id="address" name="address" required>
            <label for="baNumber">Bank Account Number:</label>
            <input id="baNumber" name="baNumber" required>
            
            <label for="travel_cost">Travel Cost:</label>
            <input type="number" id="travel_cost" name="travel_cost" required>

            <label for="category">Category:</label>
            <select name="category" id="category">
                <option value="Full Time">Full Time</option>
                <option value="Part Time">Part Time</option>
            </select>

            <label for="department">Department:</label>
            <select name="department" id="department">
                <?php
                    require("db_conn.php");

                    $sql = "SELECT * FROM departments";
                    $results = $conn->query($sql);

                    if($results->num_rows > 0){
                        while($row = $results->fetch_assoc()){
                            echo "<option value =".$row["id"].">".$row["dept_name"]."</option>";
                        }
                    }

                    $conn->close();
                ?>
            </select>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="phone_number">Phone Number:</label>
            <input type="tel" id="phone_number" name="phone_number" required>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Add Employee">
        </form>
    </div>
</body>
</html>
