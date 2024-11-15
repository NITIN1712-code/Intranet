<?php
session_start();
require("db_conn.php");

$id = $_SESSION['id'] ?? null;

if ($id === null) {
    echo "No user logged in.";
    exit;
}

$sql = "
    SELECT e.first_name, e.last_name, e.position, e.email, e.phone_number, e.address, e.employee_category,
           e.hire_date
    FROM employees e
    WHERE e.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Employee not found.";
    exit;
}

$employee = $result->fetch_assoc();
$hireDate = new DateTime($employee['hire_date']);
$currentDate = new DateTime();
$yearsOfService = $hireDate->diff($currentDate)->y;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Profile</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        /* General Page Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 40px;
        }

        h1 {
            color: #00a88f; /* Greenish Blue */
            text-align: center;
            margin: 0;
            font-size: 28px;
            padding: 10px;
        }

        /* Header Styling */
        header {
            background-color: #ffffff; /* White */
            color: #00a88f; /* Greenish Blue */
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 100%;
            position: sticky;
            top: 0;
            z-index: 100;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        header .logo-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin-bottom: 15px;
        }

        header img {
            max-width: 200px;
            height: auto;
        }

        header h1 {
            margin-top: 10px;
            font-size: 28px;
            font-weight: bold;
            color: #00a88f;
        }

        /* Container for the Profile Info */
        .profile-container {
            width: 90%;
            max-width: 1200px;
            margin-top: 40px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            table-layout: auto;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: left;
            font-size: 16px;
        }

        th {
            background-color: #00a88f;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }

        td {
            background-color: #f9f9f9;
        }

        /* Action Button Styling */
        td a {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            transition: background-color 0.3s;
        }

        td a[href*='accept.php'] {
            background-color: #28a745; /* Green for Approve */
        }

        td a[href*='reject.php'] {
            background-color: #dc3545; /* Red for Reject */
        }

        td a:hover {
            opacity: 0.8;
        }

        /* Back Button Styling */
        .back-button {
            background-color: #00a88f;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            margin-bottom: 20px;
            display: inline-block;
            transition: background-color 0.3s;
        }

        .back-button:hover {
            background-color: #008f76;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding-top: 20px;
            }

            .profile-container {
                width: 95%;
            }

            th, td {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="images/Connectitcut.png" alt="Logo">
            <h1>Welcome to Your Profile</h1>
        </div>
    </header>

    <div class="profile-container">
        <h2>Welcome, <?php echo htmlspecialchars($employee['first_name']) . " " . htmlspecialchars($employee['last_name']); ?>!</h2>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($employee['first_name'] . " " . $employee['last_name']); ?></p>
        <p><strong>Position:</strong> <?php echo htmlspecialchars($employee['position']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($employee['email']); ?></p>
        <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($employee['phone_number']); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($employee['address']); ?></p>
        <p><strong>Category:</strong> <?php echo htmlspecialchars($employee['employee_category']); ?></p>
        <p><strong>Hire Date:</strong> <?php echo htmlspecialchars($employee['hire_date']); ?></p>
        <p><strong>Years of Service:</strong> <?php echo $yearsOfService . " years"; ?></p>

        <h3>Actions</h3>
        <ul>
            <li><a href="leave_requests.php?id=<?php echo $id; ?>">Submit Leave Request</a></li>
        </ul>

        <h3>Payroll History</h3>
        <label for="payroll-month">Month:</label>
        <select id="payroll-month">
            <?php
            for ($m = 1; $m <= 12; $m++) {
                echo "<option value='$m'>" . date('F', mktime(0, 0, 0, $m, 1)) . "</option>";
            }
            ?>
        </select>

        <label for="payroll-year">Year:</label>
        <select id="payroll-year">
            <?php
            $currentYear = date('Y');
            for ($y = $currentYear; $y >= $currentYear - 10; $y--) {
                echo "<option value='$y'>$y</option>";
            }
            ?>
        </select>
        <button id="filter-payroll">Filter Payroll</button>

        <table border="1" cellpadding="10" id="payroll-table">
            <tr>
                <th>Pay Date</th>
                <th>Amount (Rs)</th>
            </tr>
        </table>

        <h3>Leave Requests</h3>
        <label for="leave-month">Month:</label>
        <select id="leave-month">
            <?php
            for ($m = 1; $m <= 12; $m++) {
                echo "<option value='$m'>" . date('F', mktime(0, 0, 0, $m, 1)) . "</option>";
            }
            ?>
        </select>

        <label for="leave-year">Year:</label>
        <select id="leave-year">
            <?php
            for ($y = $currentYear; $y >= $currentYear - 10; $y--) {
                echo "<option value='$y'>$y</option>";
            }
            ?>
        </select>
        <button id="filter-leave">Filter Leave Requests</button>

        <table border="1" cellpadding="10" id="leave-table">
            <tr>
                <th>Leave Date</th>
                <th>Leave Type</th>
                <th>Status</th>
            </tr>
        </table>
    </div>

    <script>
       
        $('#filter-payroll').click(function() {
            const month = $('#payroll-month').val();
            const year = $('#payroll-year').val();

            $.ajax({
                url: 'fetch_payroll.php',
                type: 'GET',
                data: {
                    id: <?php echo $id; ?>,
                    month: month,
                    year: year
                },
                success: function(response) {
                    $('#payroll-table').html(response);
                }
            });
        });

    
        $('#filter-leave').click(function() {
            const month = $('#leave-month').val();
            const year = $('#leave-year').val();

            $.ajax({
                url: 'fetch_leaves.php',
                type: 'GET',
                data: {
                    id: <?php echo $id; ?>,
                    month: month,
                    year: year
                },
                success: function(response) {
                    $('#leave-table').html(response);
                }
            });
        });
    </script>
</body>
</html>
