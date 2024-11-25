<?php
require("db_conn.php");

$id = $_GET['id'];
$month = $_GET['month'];
$year = $_GET['year'];

$sql = "
    SELECT payroll_id, payment_date, paymentAmount
    FROM payrolls
    WHERE employee_id = ?
    AND MONTH(payment_date) = ?
    AND YEAR(payment_date) = ?
    ORDER BY payment_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $id, $month, $year);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . htmlspecialchars($row['payment_date']) . "</td>";
        echo "<td>Rs " . number_format($row['paymentAmount'], 2) . "</td>";
        echo "<td><button style='background-color:#00a88f; border-radius:20px; border-width: 2px'><a href='download_slip.php/?id=".$row['payroll_id']."'> Download Slip </a></button></td></tr>";
    }
} else {
    echo "<tr><td colspan='2'>No records found.</td></tr>";
}
?>
