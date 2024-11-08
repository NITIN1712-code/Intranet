<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
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

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"],
        input[type="date"],
        input[type="number"],
        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        input[type="submit"] {
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

        input[type="submit"]:hover {
            background-color: #008f76;
        }
    </style>
</head>
<body>

<header>
    <img src="images/g2.jpg" alt="Explore Mauritius Logo" class="logo" />
    <h1>Add Employee</h1>
</header>

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
        <input type="text" id="address" name="address" required>

        <label for="baNumber">Bank Account Number:</label>
        <input type="text" id="baNumber" name="baNumber" required>

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
                        echo "<option value='".$row["id"]."'>".$row["dept_name"]."</option>";
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