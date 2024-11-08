
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
                    <li><a href="home.php">Logout</a></li>
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
                        
                        <li><a href="HR_Management.php">Access Human Resources Page</a></li>
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
                        <li><a href="financial_report.php">Generate Financial Reports</a></li> <!-- New feature -->
                    </ul>
                </div>
                <!-- Admin Access -->
                <div class="card">
                    <h2>Admin Access</h2>
                    <p>Admin Options</p>
                    <ul class="options">
                        <li><a href="admin_settings_page.php">Settings</a></li>
                        <li><a href="home.php">Home</a></li> <!-- Additional option -->
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
