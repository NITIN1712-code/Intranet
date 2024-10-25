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
</head>
<body>
    <div class="leave-requests-container">
        <header>
            <h1>Leave Requests Management</h1>
        </header>
        
        <main>
            <a href="HR_Management.php" class="back-button">Back to HR</a>
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
                            echo "<td>
                                    <a href='approve_leave.php?leave_id=" . urlencode($row['leave_id']) . "' onclick='return confirm(\"Are you sure you want to approve this leave request?\");'>Approve</a> |
                                    <a href='reject_leave.php?leave_id=" . urlencode($row['leave_id']) . "' onclick='return confirm(\"Are you sure you want to reject this leave request?\");'>Reject</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No leave requests found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </main>

        <footer>
            <p>&copy; 2024 Intranet System. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>

<?php
$conn->close();
?>
