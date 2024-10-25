<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Management</title>
    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="Hr.css">
</head>
<body>
    <div class="hr-container">
        <header>
            <h1>HR Management</h1>
            <nav>
                <ul>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="employee_directory.php">Employee Directory</a></li>
                    <li><a href="payroll.php">Payroll</a></li>
                    <li><a href="leave_requests.php">Leave Requests</a></li>
                    <li><a href="training.php">Training & Development</a></li>
                    <li><a href="performance_reviews.php">Performance Reviews</a></li>
                    <li><a href="reports.php">Reports</a></li>
                    <li><a href="#logout">Logout</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <section class="overview">
                <h2>HR Overview</h2>
                <p>Welcome to the HR Management section. Manage employee records, payroll, leave, training, and more.</p>
            </section>

            <section class="hr-sections">
                <!-- Employee Management -->
                <div class="hr-card">
                    <h3>Employee Management</h3>
                    <p>Manage employee information and records.</p>
                    <ul>
                        <li><a href="add_employee.php">Add New Employee</a></li>
                        <li><a href="view_employees.php">View Employees</a></li>
                        <li><a href="update_employee.php">Update Employee Details</a></li>
                        <li><a href="delete_employee.php">Delete Employee</a></li>
                    </ul>
                </div>

                <!-- Payroll Management -->
                <div class="hr-card">
                    <h3>Payroll</h3>
                    <p>Manage salaries, bonuses, and deductions.</p>
                    <ul>
                        <li><a href="view_payroll.php">View Payroll</a></li>
                        <li><a href="process_payroll.php">Process Payroll</a></li>
                        <li><a href="add_bonus.php">Add Bonuses</a></li>
                        <li><a href="deductions.php">Manage Deductions</a></li>
                    </ul>
                </div>

                <!-- Leave Management -->
                <div class="hr-card">
                    <h3>Leave Requests</h3>
                    <p>Manage employee leave requests and approvals.</p>
                    <ul>
                        <li><a href="view_leave_requests.php">View Leave Requests</a></li>
                        <li><a href="approve_leave.php">Approve/Reject Leave</a></li>
                        <li><a href="leave_policy.php">Leave Policies</a></li>
                    </ul>
                </div>

                <!-- Training & Development -->
                <div class="hr-card">
                    <h3>Training & Development</h3>
                    <p>Manage employee training programs and schedules.</p>
                    <ul>
                        <li><a href="view_training.php">View Training Programs</a></li>
                        <li><a href="schedule_training.php">Schedule New Training</a></li>
                        <li><a href="training_feedback.php">Training Feedback</a></li>
                    </ul>
                </div>

                <!-- Performance Management -->
                <div class="hr-card">
                    <h3>Performance Reviews</h3>
                    <p>Manage employee performance evaluations.</p>
                    <ul>
                        <li><a href="view_performance.php">View Performance Reviews</a></li>
                        <li><a href="add_review.php">Add Performance Review</a></li>
                        <li><a href="set_goals.php">Set Employee Goals</a></li>
                    </ul>
                </div>

                <!-- HR Reports -->
                <div class="hr-card">
                    <h3>Reports</h3>
                    <p>Generate HR-related reports and analytics.</p>
                    <ul>
                        <li><a href="attendance_report.php">Attendance Report</a></li>
                        <li><a href="leave_report.php">Leave Report</a></li>
                        <li><a href="salary_report.php">Salary Report</a></li>
                        <li><a href="performance_report.php">Performance Report</a></li>
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
