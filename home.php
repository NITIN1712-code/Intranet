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
</head>
<body>
    <div class="home-container">
        <header>
            <h1>Intranet System</h1>
            <nav>
                <ul>
                    <li><a href="login.php">Login</a></li>
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
                <form action="process_leave_requests.php" method="POST" onsubmit="return validateForm();">
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
