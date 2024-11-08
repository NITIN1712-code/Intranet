<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Management</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Header Styles */
        header {
            background-color: #ffffff;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        header img {
            max-width: 100px;
            height: auto;
        }

        header h1 {
            margin: 0;
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

        nav a:hover {
            background-color: #3498db; /* Lighter blue color */
        }

        /* Main Content */
        .hr-container {
            text-align: center;
            padding: 20px;
        }

        .overview {
            margin: 30px 0;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .overview h2 {
            color: #00a88f;
        }

        /* HR Sections */
        .hr-sections {
            display: flex; /* Align the cards horizontally */
            justify-content: space-around; /* Space between the cards */
            flex-wrap: wrap; /* Allow wrapping if the screen is too small */
            margin-top: 30px;
        }

        .hr-card {
            background-color: #ffffff;
            padding: 20px;
            margin: 10px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 22%; /* Adjust this value to control the size of each card */
            box-sizing: border-box; /* Ensures padding is included in the width */
        }

        .hr-card h3 {
            color: #00a88f;
        }

        .hr-card p {
            color: #333;
        }

        .hr-card ul {
            list-style-type: none;
            padding: 0;
        }

        .hr-card li {
            margin: 10px 0;
        }

        .hr-card a {
            text-decoration: none;
            color: #3498db;
            font-size: 16px;
        }

        .hr-card a:hover {
            color: #00a88f; /* Greenish blue */
        }

        /* Footer Styles */
        footer {
            background-color: #f4f4f4;
            color: #333;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="hr-container">
        <header>
            <img src="images/g2.jpg" alt="Logo" class="logo" />
            <h1>HR Management</h1>
            <nav>
                <ul>
                    <li><a href="home.php">Logout</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <section class="overview">
                <h2>HR Overview</h2>
                <p>Welcome to the HR Management section. Manage employee records, payroll, leave, and more.</p>
            </section>

            <section class="hr-sections">
                <!-- Employee Management -->
                <div class="hr-card">
                    <h3>Employee Management</h3>
                    <p>Manage employee information and records.</p>
                    <ul>
                        <li><a href="add_emp.php">Add New Employee</a></li>
                        <li><a href="view_emp.php">View And Edit Employees</a></li>
                        <li><a href="delete_emp.php">Delete Employee</a></li>
                        <li><a href="add_review.php">Add Employee Performance Review</a></li>
                    </ul>
                </div>

                <!-- Payroll Management -->
                <div class="hr-card">
                    <h3>Payroll</h3>
                    <p>Manage salaries, bonuses, and deductions.</p>
                    <ul>
                        <li><a href="payroll.php">View Payroll</a></li>
                        <li><a href="process_payroll.php">Process Payroll</a></li>
                    </ul>
                </div>

                <!-- Leave Management -->
                <div class="hr-card">
                    <h3>Leave Requests</h3>
                    <p>Manage employee leave requests and approvals.</p>
                    <ul>
                        <li><a href="view_leave_requests.php">View Leave Requests</a></li>
                    </ul>
                </div>

                <!-- HR Reports -->
                <div class="hr-card">
                    <h3>Reports</h3>
                    <p>Generate HR-related reports and analytics.</p>
                    <ul>
                        <li><a href="attendance_report.php">Attendance Report</a></li>
                        <li><a href="view_performance.php">Performance Report</a></li>
                    </ul>
                </div>
            </section>
        </main>

        <footer>
            <p>&copy; 2024 Intranet System. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>