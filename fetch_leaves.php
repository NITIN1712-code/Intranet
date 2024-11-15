<?php
require("db_conn.php");

$id = $_GET['id'];
$month = $_GET['month'];
$year = $_GET['year'];

$sql = "
    SELECT leaveDate, leaveType, status
    FROM leaves
    WHERE employee_id = ?
    AND MONTH(leaveDate) = ?
    AND YEAR(leaveDate) = ?
    ORDER BY leaveDate DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $id, $month, $year);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . htmlspecialchars($row['leaveDate']) . "</td>";
        echo "<td>" . htmlspecialchars($row['leaveType']) . "</td>";
        echo "<td>" . htmlspecialchars($row['status']) . "</td></tr>";
    }
} else {
    echo "<tr><td colspan='3'>No records found.</td></tr>";
}
?>
