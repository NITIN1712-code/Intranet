<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intranet Home</title>
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
                    <li><a href="login.php" class="login-button">Login</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <section class="welcome-section">
                <h2>Welcome to the Intranet System</h2>
                <p>This platform is designed to help manage internal processes, including human resources, payroll, employee management, and more.</p>
            </section>

            <section class="leave-request-section">
                <h2>Leave Request Form</h2>
                <form action="process_leave_requests.php" method="POST" onsubmit= "return validateForm();">
                    <div class="form-group">
                        <label for="employee_id">Employee ID:</label>
                        <input type="text" id="employee_id" name="employee_id" required>
                    </div>
                    <div class="form-group">
                        <label for="leaveDate">Leave Date:</label>
                        <input type="date" id="leaveDate" name="leaveDate" required>
                    </div>
                    <div class="form-group">
                        <label for="leaveType">Leave Type:</label>
                        <select id="leaveType" name="leaveType" required>
                            <option value="Sick Leave">Sick Leave</option>
                            <option value="Casual Leave">Casual Leave</option>
                            <option value="Annual Leave">Annual Leave</option>
                        </select>
                    </div>
                    <button type="submit" class="submit-button">Submit Leave Request</button>
                </form>
            </section>
        </main>

        <footer>
            <p>&copy; 2024 Intranet System. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
