<?php
session_start(); // Make sure to start the session to access session variables testaada
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <header>
            <h1>Admin Dashboard</h1>
            <nav>
                <ul>
                    <li><a href="#logout">Logout</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <section class="info-cards">
                <!-- HR Management Card -->
                <div class="card">
                    <h2>Human Resource Management</h2>
                    <p>Manage HR-related tasks here</p>
                    <ul class="options">
                        <li><a href="add_emp.php">Add Employee</a></li>
                        <li><a href="view_emp.php">View All Employees</a></li>
                        <!-- Only show the Delete Employee option if the user is an admin -->
                        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') : ?>
                            <li><a href="delete_emp.php">Delete Employee</a></li>
                        <?php endif; ?>
                        <li><a href="employee_reports.php">Generate HR Reports</a></li> <!-- New feature suggestion -->
                    </ul>
                </div>

                <!-- Bookings Card -->
                <div class="card">
                    <h2>Bookings</h2>
                    <p>Manage Clients and Bookings</p>
                    <ul class="options">
                        <li><a href="booking.php">Create New Booking</a></li>
                        <li><a href="view_booking.php">View All Bookings</a></li>
                        <li><a href="create_user.php">Create User</a></li>
                        <li><a href="manage_tours.php">Manage Tours</a></li>
                    </ul>
                </div>

                <!-- Finance Card -->
                <div class="card">
                    <h2>Finance</h2>
                    <p>View and manage financial transactions</p>
                    <ul class="options">
                        <li><a href="view_transactions.php">View Transactions</a></li>
                        <li><a href="add_transaction.php">Add Transaction</a></li> <!-- Additional option -->
                        <li><a href="generate_financial_report.php">Generate Financial Reports</a></li> <!-- New feature -->
                    </ul>
                </div>
            </section>
        </main>

        <footer>
            <p>&copy; 2024 Dashboard App. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
