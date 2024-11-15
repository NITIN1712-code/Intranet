<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
            background-color: white; /* White background */
            color: #333;
            padding: 20px 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header .header-content {
            display: flex;
            align-items: center;
        }

        header img {
            max-width: 100px;
            height: auto;
            margin-right: 20px;
        }

        header h1 {
            font-size: 24px;
            margin: 0;
            color: #00a88f; /* Greenish-blue */
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
            background-color: #3498db; /* Blue color */
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            display: inline-block;
        }

        nav a:hover {
            background-color: #2980b9; /* Darker blue */
        }

        /* Main Content Styles */
        .dashboard-container {
            width: 90%;
            margin: 30px auto;
        }

        main {
            margin-top: 30px; /* Adding space between the header and the content */
        }

        .info-cards {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
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

        /* Footer Styles */
        footer {
            background-color: #f4f4f4;
            color: #333;
            padding: 10px;
            text-align: center;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .info-cards {
                flex-direction: column;
                align-items: center;
            }

            .card {
                width: 80%;
                margin-bottom: 20px;
            }

            header {
                flex-direction: column;
                align-items: center;
            }

            header nav {
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <header>
            <div class="header-content">
                <img src="images/g2.jpg" alt="Logo" />
                <h1>Admin Dashboard</h1>
            </div>
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
                        <li><a href="add_transaction.php">Add Transaction</a></li> <!-- Additional option -->
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