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
            <h1>Dashboard</h1>
            <nav>
                <ul>
                    <li><a href="#logout">Logout</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <section class="info-cards">
                <div class="card">
                    <a href="employees.php" class="card-link">
                        <h2>Employees</h2>
                        <p>Manage Employees here</p>
                        <!-- Options for managing employees -->
                        <ul class="options">
                            <li><a href="add_emp.php">Add Employee</a></li>
                            <li><a href="delete_emp.php">Delete Employee</a></li>
                            <li><a href="view_emp.php">View All Employees</a></li> <!-- Add the link here -->
                        </ul>
                    </a>    
                </div>
                <div class="card">
                    <a href="clients.php" class="card-link">
                        <h2>Bookings</h2>
                        <p>Manage Clients and Bookings</p>
                        <ul class="options">
                            <li><a href="booking.php">Booking</a></li>
                            <li><a href="view_booking.php">View Bookings</a></li>
                            <li><a href="create_user.php">Create User</a></li>
                            <li><a href="manage_tours.php">Manage Tours</a></li> <!-- Add the link here -->
                        </ul>
                    </a>
                </div>
                <div class="card">
                    <a href="finance.php" class="card-link">
                        <h2>Finance</h2>
                        <p>View transactions</p>
                    </a>
                </div>
                <div class="card">
                    <a href="clients.php" class="card-link">
                        <h2>Human Resources</h2>
                        <p>Manages Employees and Payroll</p>
                        <ul class="options">
                            <li><a href="human_resources.php">Manage Employees</a></li><!-- Add the link here -->
                        </ul>
                    </a>
                </div>
            </section>
        </main>

        <footer>
            <p>&copy; 2024 Dashboard App. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
