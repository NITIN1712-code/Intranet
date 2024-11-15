<?php
session_start();
include 'db_conn.php';

$filterDate = isset($_GET['filter_date']) ? $_GET['filter_date'] : '';

$sql_incoming = "SELECT b.booking_id, b.tourguide_id, b.total_price, b.booking_date
                 FROM bookings b";
if ($filterDate) {
    $sql_incoming .= " WHERE DATE(b.booking_date) = '$filterDate'";
}
$sql_incoming .= " ORDER BY b.booking_id DESC";

$sql_outgoing = "SELECT p.payroll_id, p.employee_id, p.paymentAmount, p.payment_date
                 FROM payrolls p";
$sql_outgoing2 = "SELECT id, paymentAmount, payment_date
                  FROM outgoing_transaction";
if ($filterDate) {
    $sql_outgoing .= " WHERE DATE(p.payment_date) = '$filterDate'";
    $sql_outgoing2 .= " WHERE DATE(payment_date) = '$filterDate'";
}

$result_incoming = $conn->query($sql_incoming);
$result_outgoing = $conn->query($sql_outgoing);
$result_outgoing2 = $conn->query($sql_outgoing2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Transactions</title>
    <link rel="stylesheet" href="view_transaction.css">
</head>
<body>
    <h1>View Transactions</h1>

    <form method="GET" action="">
        <label for="filter_date">Filter Date:</label>
        <input type="date" id="filter_date" name="filter_date" value="<?php echo $filterDate; ?>">
        <button type="submit">Filter</button>
    </form>

    <div id="topdfele">
        <div class="transaction-container">
            <div class="transaction-box incoming">
                <h3>Incoming Transactions (Bookings)</h3>
                <?php
                if ($result_incoming->num_rows > 0) {
                    while($row = $result_incoming->fetch_assoc()) {
                        echo "<div class='transaction-item'>
                                <span>Booking ID:</span><span class='value'>" . $row['booking_id'] . "</span>
                                <span>Date:</span><span class='value'>" . date("F d, Y", strtotime($row['booking_date'])) . "</span>
                                <span>Tour Guide ID:</span><span class='value'>" . $row['tourguide_id'] . "</span>
                                <span>Total Price:</span><span class='value'>$" . number_format($row['total_price'], 2) . "</span>
                            </div>";
                    }
                } else {
                    echo "<div>No incoming transactions found.</div>";
                }
                ?>
            </div>

        
            <div class="transaction-box outgoing">
                <h3>Outgoing Transactions (Payroll)</h3>
                <?php
                if ($result_outgoing->num_rows > 0 || $result_outgoing2->num_rows > 0) {
                    while($row = $result_outgoing->fetch_assoc()) {
                        echo "<div class='transaction-item'>
                                <span>Payroll ID:</span><span class='value'>" . $row['payroll_id'] . "</span>
                                <span>Employee ID:</span><span class='value'>" . $row['employee_id'] . "</span>
                                <span>Date:</span><span class='value'>" . date("F d, Y", strtotime($row['payment_date'])) . "</span>
                                <span>Amount:</span><span class='value'>$" . number_format($row['paymentAmount'], 2) . "</span>
                            </div>";
                    }
                    while($row = $result_outgoing2->fetch_assoc()) {
                        echo "<div class='transaction-item'>
                                <span>Transaction ID:</span><span class='value'>" . $row['id'] . "</span>
                                <span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span>
                                <span>Date:</span><span class='value'>" . date("F d, Y", strtotime($row['payment_date'])) . "</span>
                                <span>Amount:</span><span class='value'>RS" . number_format($row['paymentAmount'], 2) . "</span>
                            </div>";
                    }
                } else {
                    echo "<div>No outgoing transactions found.</div>";
                }
                
                ?>
            </div>
        </div>
    </div>
</body>
</html>
