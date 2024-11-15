<?php
session_start();
require("db_conn.php");

$logType;
$val = false;
$id = "null";

if (isset($_SESSION["id"])) {
    $logType = "Logout";
    $val = true;
    $id = $_SESSION["id"];
} else {
    $logType = "Login";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intranet Home</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css"> <!-- Link to external CSS file -->
    <script>
        // Simple form validation
        function validateForm() {
            const employeeId = document.getElementById("employee_id").value;
            const leaveDate = document.getElementById("leaveDate").value;
            if (!employeeId || !leaveDate) {
                alert("Please fill in all required fields.");
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }
    </script>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #ffffff;
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
            color: #00a88f; /* Greenish blue color */
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        nav li {
            display: inline-block;
            margin: 10px;
        }

        nav a {
            text-decoration: none;
            color: white;
            background-color: #00a88f; /* Greenish blue color */
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            display: inline-block;
        }

        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 22%;
            margin-bottom: 20px;
            text-align: center;
        }

        .card h2 {
            color: #00a88f; /* Greenish-blue */
        }

        .card p {
            color: #333;
            font-size: 14px;
        }

        .options {
            list-style-type: none;
            padding: 0;
        }

        .options li {
            margin: 10px 0;
        }

        .options a {
            text-decoration: none;
            color: #3498db;
            font-size: 16px;
        }

        .options a:hover {
            color: #00a88f; /* Greenish-blue */
        }

        .info-cards {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }

        nav a:hover {
            background-color: #3498db; /* Lighter blue color */
        }

        /* Main Content */
        .home-container {
            text-align: center;
        }

        .welcome-section, .leave-request-section {
            margin: 30px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .quote_of_the_day{
            margin: 30px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .welcome-section h2, .leave-request-section h2 {
            color: #00a88f;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        label {
            font-weight: bold;
        }

        input[type="text"], input[type="date"], select {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            width: 100%;
            font-size: 14px;
        }

        button {
            background-color: #00a88f; /* Greenish blue color */
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #3498db;
        }

        footer {
            background-color: #f4f4f4;
            color: #333;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="home-container">
        
        <header>
            <img src="images/g2.jpg" alt="Explore Mauritius Logo" class="logo" />
            <h1>Connecticut Tours</h1>
            <nav>
    <ul>
        
        <li><a href="emp_profile.php" id="profile-button" style="display: <?php echo $val ? 'block' : 'none'; ?>">Profile</a></li>

        <?php if ($val): ?>
            <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="login.php">Login</a></li>
        <?php endif; ?>
    </ul>
</nav>


        </header>

        <main>
            <section class="welcome-section">
                <h2>Welcome to the Intranet System</h2>
            </section>

            <section class="quote_of_the_day">
                <h2>Quote of the day</h2>
                <p id="quote"></p>
                <h4 id="author"></h4>
            </section>

            <section class="quota">

            </section>

            <section class="info-cards">
                <div class="card" id="Human Resources" style="display:none">
                    <h2>Human Resource Management</h2>
                    <p>Manage HR-related tasks here</p>
                    <ul class="options">
                        <li><a href="HR_Management.php">Access Human Resources Page</a></li>
                    </ul>
                </div>
                <div class="card" id="Tour Management" style="display:none">
                    <h2>Bookings</h2>
                    <p>Manage Clients and Bookings</p>
                    <ul class="options">
                        <li><a href="booking.php">Create New Booking</a></li>
                        <li><a href="view_booking.php">View All Bookings</a></li>
                        <li><a href="create_user.php">Create User</a></li>
                        <li><a href="manage_tours.php">Manage Tours</a></li>
                    </ul>
                </div>
                <div class="card" id="Finance" style="display:none">
                    <h2>Finance</h2>
                    <p>View and manage financial transactions</p>
                    <ul class="options">
                        <li><a href="view_transactions.php">View Transactions</a></li>
                        <li><a href="add_transaction.php">Add Transaction</a></li> <!-- Additional option -->
                        <li><a href="financial_report.php">Generate Financial Reports</a></li> <!-- New feature -->
                    </ul>
                </div>
            </section>
        </main>
        

        <footer>
            <p>&copy; 2024 Intranet System. All rights reserved.</p>
        </footer>
    </div>

    <script>
        var id = <?php echo $id; ?>;

        fetch('settings.json')
        .then((response) => response.json())
        .then((json_data) => {
            document.getElementById("quote").innerHTML = json_data["quote"]["quote"];
            document.getElementById("author").innerHTML = "- " + json_data["quote"]["author"];
        });

        function checkEmployee(){
            if(!id){
                return;
            }
            $.ajax({
                url:"get_dept.php",
                type:"GET",
                data:{
                    "id":id,
                },
                success: function(response){
                    document.getElementById(response).style.display = "block";
                }
            })
        }

        checkEmployee();
    </script>
</body>
</html>
