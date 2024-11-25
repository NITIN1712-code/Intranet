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
    
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e9f5f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 40px;
        }

        h1 {
            color: #005f73; 
            text-align: center;
            margin: 0;
            font-size: 32px;
            padding: 10px;
        }

       

header {
    background-color: #005f73; 
    color: white;
    padding: 20px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 100%;
    position: relative; 
    display: flex;
    justify-content: center; 
    align-items: center;
}


.logo-container {
    display: flex;
    flex-direction: column; 
    align-items: center;
    flex-grow: 1;
    margin-right: 100px;
}


.back-button {
    position: absolute;
    top: 20px; 
    right: 20px; 
    background-color: #005f73;
    color: white;
    padding: 8px 15px;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s;
}

.back-button:hover {
    background-color: #014f63; 
}

header img {
    max-width: 150px; 
    height: auto;
}


header h1 {
    font-size: 24px; 
    margin-top: 10px; 
}


    
        .profile-container {
            width: 90%;
            max-width: 1200px;
            margin-top: 120px; 
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

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
            background-color: #005f73;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }

        td {
            background-color: #f9f9f9;
        }
        td a {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            transition: background-color 0.3s;
        }

        td a[href*='accept.php'] {
            background-color: #28a745; 
        }

        td a[href*='reject.php'] {
            background-color: #dc3545;
        }

        td a:hover {
            opacity: 0.8;
        }

        .back-button {
            background-color: #005f73;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            margin-bottom: 20px;
            display: inline-block;
            transition: background-color 0.3s;
        }

ul li a {
    display: inline-block;
    padding: 8px 15px;
    background-color: #005f73; 
    color: white;
    text-align: center;
    text-decoration: none;
    border-radius: 5px;
    font-size: 14px; 
    transition: background-color 0.3s, transform 0.2s;
}

ul li a:hover {
    background-color: #014f63;
    transform: scale(1.05); 
}

ul li a:active {
    background-color: #003c48; 
    transform: scale(1); 
}


        .back-button:hover {
            background-color: #014f63;
        }


        select, button {
            margin: 5px 0;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #005f73;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background-color: #014f63;
        }

   
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
        <p><strong>Wlcome to your profile</strong> <?php echo htmlspecialchars($employee['first_name'] . " " . $employee['last_name']); ?></p>
        <h1>Welcome to Your Profile</h1>
    </div>

    <a href="javascript:history.back()" class="back-button">Back</a>
</header>




    <div class="profile-container">
      
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
                <th></th>
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
        $('#filter-payroll').click
