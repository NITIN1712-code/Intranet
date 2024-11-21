<?php
include 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_id = $_POST['employee_id'];
    $month = $_POST['month'];
    $year = $_POST['year'];

    // Fetch employee details
    $employee_query = "SELECT first_name, last_name, position FROM employees WHERE id = '$employee_id'";
    $employee_result = $conn->query($employee_query);

    if ($employee_result->num_rows > 0) {
        $employee = $employee_result->fetch_assoc();
        $employee_name = $employee['first_name'] . ' ' . $employee['last_name'];
        $position = $employee['position'];

        // Calculate working days in the specified month (only weekdays)
        $attendance = [];
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = "$year-$month-$day";
            $dayOfWeek = date('N', strtotime($date));
            if ($dayOfWeek >= 1 && $dayOfWeek <= 5) {
                $attendance[$day] = ["Time In" => "09:00", "Time Out" => "16:00", "Status" => "Present"];
            }
        }

        // Check for approved leaves
        $leaves_query = "SELECT DAY(leaveDate) AS day FROM leaves WHERE employee_id = '$employee_id' AND approval = 1 AND MONTH(leaveDate) = $month AND YEAR(leaveDate) = $year";
        $leaves_result = $conn->query($leaves_query);

        if ($leaves_result->num_rows > 0) {
            while ($leave = $leaves_result->fetch_assoc()) {
                $day = $leave['day'];
                if (isset($attendance[$day])) {
                    $attendance[$day]["Time In"] = "-";
                    $attendance[$day]["Time Out"] = "-";
                    $attendance[$day]["Status"] = "Absent";
                }
            }
        }
    } else {
        echo "Employee not found.";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Attendance Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background-color: #ffffff;
            color: #00a88f;
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
        }
        .container {
            width: 80%;
            margin: 30px auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .message {
            color: #2980b9;
            margin-bottom: 20px;
            font-size: 18px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #00a88f;
            color: white;
        }
        td {
            background-color: #f9f9f9;
        }

        /* Form Styling */
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-weight: bold;
            font-size: 16px;
        }
        input[type="text"], select {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 14px;
        }
        button {
            background-color: #00a88f;
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #3498db;
        }
        select {
            font-size: 14px;
        }


        button,
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #00a88f;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover,
        input[type="submit"]:hover {
            background-color: #008f76;
        }

        .back-button {
            width: 100%;
            padding: 12px;
            background-color: #cccccc;
            border: none;
            border-radius: 5px;
            color: black;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .back-button:hover {
            background-color: #b3b3b3;
        }
    </style>
</head>
<body>
<header>
    <img src="images/g2.jpg" alt="Explore Mauritius Logo" class="logo" />
    <h1>Employee Attendance Report</h1>
</header>

<div class="container">
    <form method="POST" action="">
        <label for="employee_id">Employee ID:</label>
        <input type="text" id="employee_id" name="employee_id" required>
        
        <label for="month">Month:</label>
        <select id="month" name="month" required>
            <option value="01">January</option>
            <option value="02">February</option>
            <option value="03">March</option>
            <option value="04">April</option>
            <option value="05">May</option>
            <option value="06">June</option>
            <option value="07">July</option>
            <option value="08">August</option>
            <option value="09">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
        </select>
        
        <label for="year">Year:</label>
        <select id="year" name="year" required>
            <?php
                $currentYear = date("Y");
                for ($y = $currentYear - 5; $y <= $currentYear; $y++) {
                    echo "<option value=\"$y\">$y</option>";
                }
            ?>
        </select>

        <button type="submit">Generate Report</button>
    </form>

    <?php if (isset($employee)): ?>
        <?php
            $monthNames = [
                "01" => "January", "02" => "February", "03" => "March", "04" => "April",
                "05" => "May", "06" => "June", "07" => "July", "08" => "August",
                "09" => "September", "10" => "October", "11" => "November", "12" => "December"
            ];
            $monthName = $monthNames[$month];
        ?>
        <p class="message">This is the attendance report of <?php echo htmlspecialchars($employee_name); ?> for <?php echo $monthName; ?> <?php echo $year; ?>.</p>

        <table>
            <thead>
                <tr>
                    <th>Day</th>
                    <th>Member Name</th>
                    <th>Position</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($attendance as $day => $data): ?>
                    <tr>
                        <td><?php echo $day; ?></td>
                        <td><?php echo htmlspecialchars($employee_name); ?></td>
                        <td><?php echo htmlspecialchars($position); ?></td>
                        <td><?php echo $data["Time In"]; ?></td>
                        <td><?php echo $data["Time Out"]; ?></td>
                        <td><?php echo $data["Status"]; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    <button class="back-button" onclick="history.back(); return false;">Back</button>
</div>

</body>
</html>


