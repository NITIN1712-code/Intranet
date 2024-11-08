<?php
include 'db_conn.php';

$sql = "SELECT * FROM leaves";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Leave Requests</title>
    <link rel="stylesheet" href="leaves.css">
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

        /* Container for the Table */
        .leave-requests-container {
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
            background-color: #00a88f;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        td a:hover {
            background-color: #008f76;
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

            .leave-requests-container {
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
        <img src="images/g2.jpg" alt="Explore Mauritius Logo" class="logo" />
        <h1>Leave Requests Management</h1>
    </div>
</header>

<div class="leave-requests-container">
    <a href="javascript:history.back()" class="back-button">Back to HR</a>
    <table>
        <thead>
            <tr>
                <th>Leave ID</th>
                <th>Employee ID</th>
                <th>Leave Date</th>
                <th>Leave Type</th>
                <th>Approval Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['leave_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['employee_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['leaveDate']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['leaveType']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['approval']) . "</td>";
                    if($row["approval"] == 1){
                        echo "<td> Approved </td>";
                    } else {
                        echo "<td>
                                <a href='PhpMailer/index.php?leave_id=" . urlencode($row['leave_id']) . "' onclick='return confirm(\"Are you sure you want to approve this leave request?\");'>Approve</a> |
                                <a href='index.php?leave_id=" . urlencode($row['leave_id']) . "' onclick='return confirm(\"Are you sure you want to reject this leave request?\");'>Reject</a>
                            </td>";
                    }
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No leave requests found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
$conn->close();
?>