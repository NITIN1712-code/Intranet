<?php
require 'db_conn.php';

$selected_year = isset($_GET['year']) ? $_GET['year'] : date('Y');

$monthly_data = [];
$total_income = 0;
$total_expenses = 0;
$total_net_profit = 0;
$individual_data = [];


$sql_years = "
    SELECT DISTINCT DATE_FORMAT(booking_date, '%Y') AS year
    FROM bookings
    ORDER BY year DESC
";


$sql_income = "
    SELECT
        DATE_FORMAT(booking_date, '%Y-%m') AS month,
        total_price,
        booking_date
    FROM
        bookings
    WHERE
        booking_date IS NOT NULL
        AND YEAR(booking_date) = '$selected_year'
    ORDER BY
        booking_date
";


$sql_expenses = "
    SELECT
        DATE_FORMAT(payment_date, '%Y-%m') AS month,
        (paymentAmount + bonusAmount - deductions) AS expense,
        payment_date
    FROM
        payrolls
    WHERE
        payment_date IS NOT NULL
        AND YEAR(payment_date) = '$selected_year'
    ORDER BY
        payment_date
";

$sql_expenses2 = "
    SELECT
        DATE_FORMAT(payment_date, '%Y-%m') AS month,
        paymentAmount AS expense,
        payment_date
    FROM
        outgoing_transaction
    WHERE
        payment_date IS NOT NULL
        AND YEAR(payment_date) = '$selected_year'
    ORDER BY
        payment_date
";

$result_years = $conn->query($sql_years);
$result_income = $conn->query($sql_income);
$result_expenses = $conn->query($sql_expenses);
$result_otherexpences = $conn->query($sql_expenses2);

if (!$result_years || !$result_income || !$result_expenses) {
    die("Error executing query: " . $conn->error);
}

while ($row = $result_income->fetch_assoc()) {
    $month = $row['month'];
    $total_price = $row['total_price'];
    $booking_date = $row['booking_date'];

    $monthly_data[$month]['income'] = ($monthly_data[$month]['income'] ?? 0) + $total_price;
    $individual_data[$month]['income'][] = [
        'date' => $booking_date,
        'amount' => $total_price
    ];
    $total_income += $total_price;
}

while ($row = $result_expenses->fetch_assoc()) {
    $month = $row['month'];
    $expense = $row['expense'];
    $payment_date = $row['payment_date'];

    $monthly_data[$month]['expenses'] = ($monthly_data[$month]['expenses'] ?? 0) + $expense;
    $individual_data[$month]['expenses'][] = [
        'date' => $payment_date,
        'amount' => $expense
    ];
    $total_expenses += $expense;
}

while ($row = $result_otherexpences->fetch_assoc()) {
    $month = $row['month'];
    $expense = $row['expense'];
    $payment_date = $row['payment_date'];

    $monthly_data[$month]['expenses'] = ($monthly_data[$month]['expenses'] ?? 0) + $expense;
    $individual_data[$month]['expenses'][] = [
        'date' => $payment_date,
        'amount' => $expense
    ];
    $total_expenses += $expense;
}


$months = [];
$profits = [];
foreach ($monthly_data as $month => $data) {
    $income = $data['income'] ?? 0;
    $expenses = $data['expenses'] ?? 0;
    $net_profit = $income - $expenses;
    $monthly_data[$month]['net_profit'] = $net_profit;
    $total_net_profit += $net_profit;

    $months[] = $month;
    $profits[] = $net_profit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Financial Report</title>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f7f8;
        color: #333;
        margin: 0;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }


            /* Header */
            header {
            background-color: #ffffff;
            color: #00a88f;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        .logo {
            max-width: 150px;
            height: auto;
        }

        header img {
            max-width: 100px;
            height: auto;
        }

    h2 {
        font-size: 28px;
        margin-bottom: 20px;
        color: #444;
    }

    form {
        margin-bottom: 20px;
    }

    select {
        padding: 8px;
        font-size: 16px;
        border-radius: 4px;
        border: 1px solid #ddd;
        background-color: #fff;
        cursor: pointer;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }

    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
        font-weight: bold;
        font-size: 16px;
    }

    td {
        font-size: 14px;
    }

    .summary {
        font-weight: bold;
        background-color: #f9f9f9;
    }

    button {
        padding: 5px 10px;
        background-color:  #00a88f;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }

    button:hover {
        background-color: #005fa3;
    }

    .details {
        display: none;
        margin-top: 5px;
        margin-bottom: 10px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        padding: 15px;
        padding-top: 0px;
        border-radius: 8px;
    }

    .details-container {
        display: flex;
        justify-content: space-between;
    }

    .details-container div {
        width: 48%;
    }

    .details-container h4 {
        color: #007acc;
        margin-bottom: 10px;
        font-size: 16px;
    }

    .details-container ul {
        padding: 0;
        list-style-type: none;
    }

    .details-container ul li {
        padding: 5px 0;
        border-bottom: 1px solid #ddd;
    }

    .details-container ul li:last-child {
        border-bottom: none;
    }

    .details h3{
        display: flex;
        justify-content: space-between;
    }

    .close-btn {
        cursor: pointer;
        color: #ff0000;
        font-weight: bold;
        margin-left: 20px;
    }

    #profitChart {
        width: 100%;
        max-width: 800px;
        margin-top: 40px;
    }

    @media (max-width: 768px) {
        body {
            padding: 10px;
        }

        table {
            margin: 0;
        }

        .details-container {
            flex-direction: column;
            align-items: center;
        }

        .details-container div {
            width: 100%;
            margin-bottom: 20px;
        }

        button {
            width: 100%;
            font-size: 16px;
            padding: 10px;
        }

        #profitChart {
            max-width: 100%;
        }
    }
</style>
</head>
<body>

<header>
    <img src="images/g2.jpg" alt="Explore Mauritius Logo" class="logo" />
</header>

<h2 style="color: #00a88f;">Financial Report - Yearly Analytics</h2>


<form method="get">
    <label for="year">Select Year: </label>
    <select name="year" id="year" onchange="this.form.submit()">
        <?php
        while ($row = $result_years->fetch_assoc()) {
            $year = $row['year'];
            $selected = ($year == $selected_year) ? 'selected' : '';
            echo "<option value='$year' $selected>$year</option>";
        }
        ?>
    </select>
</form>

<table>
    <tr>
        <th>Month</th>
        <th>Total Income (Rs)</th>
        <th>Total Expenses (Rs)</th>
        <th>Net Profit (Rs)</th>
        <th>Details</th>
    </tr>

    <?php
    foreach ($monthly_data as $month => $data) {
        $income = number_format($data['income'] ?? 0, 2);
        $expenses = number_format($data['expenses'] ?? 0, 2);
        $net_profit = number_format($data['net_profit'] ?? 0, 2);

        echo "<tr>
                <td>$month</td>
                <td>Rs $income</td>
                <td>Rs $expenses</td>
                <td>Rs $net_profit</td>
                <td><button id=$month onclick=\"toggleDetails('$month')\">View Details</button></td>
              </tr>";

        echo "<div id='details-$month' class='details'>
                <h3>Details for $month <span class='close-btn' onclick='toggleDetails(\"$month\")'>X</span></h3>
                <div class='details-container'>
                    <div>
                        <h4>Incomes</h4>
                        <ul>";
        if(isset($individual_data[$month]['income'])){
            foreach ($individual_data[$month]['income'] as $income_item) {
                echo "<li>Date: {$income_item['date']}, Amount: Rs " . number_format($income_item['amount'], 2) . "</li>";
            }
        }
            
        echo "</ul></div><div><h4>Expenses</h4><ul>";
        if(isset($individual_data[$month]['expenses'])){
            foreach ($individual_data[$month]['expenses'] as $expense_item) {
                echo "<li>Date: {$expense_item['date']}, Amount: Rs " . number_format($expense_item['amount'], 2) . "</li>";
            }
        }
        echo "</ul></div></div></div>";
    }
    ?>

    <tr class="summary">
        <td>Total</td>
        <td>Rs <?= number_format($total_income, 2) ?></td>
        <td>Rs <?= number_format($total_expenses, 2) ?></td>
        <td>Rs <?= number_format($total_net_profit, 2) ?></td>
        <td></td>
    </tr>
</table>


<div id="profitChart"></div>

<!-- Back Button -->
<div style="margin-top: 20px;">
    <button onclick="history.back()" style="padding: 10px 20px; background-color: #007acc; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer;">
        Back
    </button>
</div>

<script>
   
    function toggleDetails(month) {
        const details = document.getElementById(`details-${month}`);
        details.style.display = (details.style.display === 'none' || details.style.display === '') ? 'block' : 'none';
        if(!(details.style.display === 'none' || details.style.display === '')){
            document.documentElement.scrollTop = 0;
        }
        document.getElementById(month).innerHTML = (details.style.display === 'none' || details.style.display === '') ? 'View Details' : 'Close';;
    }

    var options = {
    chart: {
        type: 'bar',
        height: 500,  
        width: '120%',  
        offsetX: '5%'  
    },
    series: [{
        name: 'Net Profit (Rs)',
        data: <?= json_encode($profits) ?>
    }],
    xaxis: {
        categories: <?= json_encode($months) ?>
    },
    title: {
        text: 'Monthly Net Profit (Rs)',
        align: 'center'
    },
    colors: ['#007acc'],
    dataLabels: {
        enabled: true,
        style: {
            fontSize: '14px',  
            fontWeight: 'bold',
            colors: ['#ffffff']  
        },
        background: {
            enabled: true,
            foreColor: '#000000',
            borderRadius: 2,
            padding: 4,
            opacity: 0.7,  
            borderWidth: 1,
            borderColor: '#34a853' 
        },
        formatter: function(val) {
            return 'Rs ' + val.toFixed(2);  
        }
    },
    plotOptions: {
        bar: {
            horizontal: false, 
            columnWidth: '60%' 
        }
    },
    grid: {
        show: true, 
        borderColor: '#f1f1f1', 
        padding: {
            left: 20,
            right: 20,
            top: 10,
            bottom: 10
        }
    },
    tooltip: {
        theme: 'dark',
        x: {
            show: true 
        },
        y: {
            formatter: function(val) {
                return 'Rs ' + val.toFixed(2);
            }
        }
    }
};

var chart = new ApexCharts(document.querySelector("#profitChart"), options);
chart.render();



   
</script>

</body>
</html>

<?php

$conn->close();
?>