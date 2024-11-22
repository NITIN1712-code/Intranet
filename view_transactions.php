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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Transactions</title>
    <style>
        /* General layout */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        h1 {
            color: #00a88f; /* Greenish Blue */
            text-align: center;
            margin-top: 20px;
        }

        /* Header */
        header {
            background-color: #ffffff;
            color: #00a88f;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            width: 100%;
            z-index: 100;
        }
        header img {
            max-width: 100px;
            height: auto;
        }

        /* Filter Form */
        form {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
        }
        form label {
            margin-right: 10px;
            font-weight: bold;
        }
        form input, form button {
            padding: 10px;
            margin: 0 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        form button {
            background-color: #00a88f;
            color: white;
            border: none;
            cursor: pointer;
        }
        form button:hover {
            background-color: #007f68;
        }

        /* Transaction Containers */
        .transaction-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin: 20px auto;
            width: 80%;
        }
        .transaction-box {
            flex: 1;
            background: #fff;
            margin: 10px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 45%;
        }
        .transaction-box h3 {
            color: #00a88f;
            text-align: center;
            margin-bottom: 20px;
        }
        .transaction-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .transaction-item span {
            display: inline-block;
        }
        .transaction-item span.value {
            font-weight: bold;
        }
        .transaction-box div {
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .transaction-box div:last-child {
            margin-bottom: 0;
        }

        /* Back Button */
        .back-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #00a88f;
            color: white;
            text-align: center;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
        }
        .back-button:hover {
            background-color: #007f68;
        }
    </style>
</head>
<body>
<header>
    <img src="images/g2.jpg" alt="Explore Mauritius Logo" class="logo" />
    <h1>View Transactions</h1>
</header>

<form method="GET" action="">
    <label for="filter_date">Filter Date:</label>
    <input type="date" id="filter_date" name="filter_date" value="<?php echo $filterDate; ?>">
    <button type="submit">Filter</button>
</form>

<div class="transaction-container">
    <div class="transaction-box incoming">
        <h3>Incoming Transactions (Bookings)</h3>
        <?php
        if ($result_incoming->num_rows > 0) {
            while ($row = $result_incoming->fetch_assoc()) {
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
            while ($row = $result_outgoing->fetch_assoc()) {
                echo "<div class='transaction-item'>
                        <span>Payroll ID:</span><span class='value'>" . $row['payroll_id'] . "</span>
                        <span>Employee ID:</span><span class='value'>" . $row['employee_id'] . "</span>
                        <span>Date:</span><span class='value'>" . date("F d, Y", strtotime($row['payment_date'])) . "</span>
                        <span>Amount:</span><span class='value'>$" . number_format($row['paymentAmount'], 2) . "</span>
                    </div>";
            }
            while ($row = $result_outgoing2->fetch_assoc()) {
                echo "<div class='transaction-item'>
                        <span>Transaction ID:</span><span class='value'>" . $row['id'] . "</span>
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

<a href="javascript:history.back()" class="back-button">Back</a>

</body>
</html>
