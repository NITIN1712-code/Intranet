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
if ($filterDate) {
    $sql_outgoing .= " WHERE DATE(p.payment_date) = '$filterDate'";
}

$result_incoming = $conn->query($sql_incoming);
$result_outgoing = $conn->query($sql_outgoing);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Transactions</title>
    <link rel="stylesheet" href="view_transaction.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
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
                if ($result_outgoing->num_rows > 0) {
                    while($row = $result_outgoing->fetch_assoc()) {
                        echo "<div class='transaction-item'>
                                <span>Payroll ID:</span><span class='value'>" . $row['payroll_id'] . "</span>
                                <span>Employee ID:</span><span class='value'>" . $row['employee_id'] . "</span>
                                <span>Date:</span><span class='value'>" . date("F d, Y", strtotime($row['payment_date'])) . "</span>
                                <span>Amount:</span><span class='value'>$" . number_format($row['paymentAmount'], 2) . "</span>
                            </div>";
                    }
                } else {
                    echo "<div>No outgoing transactions found.</div>";
                }
                ?>
            </div>
        </div>
    </div>

    <button onclick="transactionPdf()">Turn to pdf</button>


    <script>


        function generate() {
            let length = 16;
            const characters = 'abcdefghijklmnopqrstuvwxyz123456789';
            let result = '';
            const charactersLength = characters.length;
            for(let i = 0; i < length; i++) {
                result +=  characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        }

        async function transactionPdf(){
            const {jsPDF} = window.jspdf;

            const contentCanvas = await html2canvas(document.getElementById("topdfele"));
            var img = contentCanvas.toDataURL("image/png");
            
            var randomValue = generate();

            var fileName = "financial_report"+randomValue+".pdf"

            var doc = new jsPDF();
            doc.addImage(img, "png",0 ,0);

            doc.save(fileName);
            return;
        }
    </script>
</body>
</html>
