<?php
    require("db_conn.php");
    if (isset($_POST["submit"])) {
        $statement = $conn->prepare("INSERT INTO outgoing_transaction(paymentAmount, payment_date)
                                    VALUES(?, ?)");
        $statement->bind_param("ds", $_POST["amount"], $_POST["date"]);

        if ($statement->execute()) {
            echo "<script>alert('Transaction added successfully!');</script>";
        } else {
            echo "<script>alert('Failed to add transaction. Please try again.');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Outgoing Transaction</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

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
        }

        header img {
            max-width: 100px;
            height: auto;
        }

        header h1 {
            margin: 0;
            font-size: 24px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            margin-top: 20px;
        }

        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        form input[type="number"],
        form input[type="date"],
        form input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        form input[type="submit"] {
            background-color: #00a88f;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 18px;
        }

        form input[type="submit"]:hover {
            background-color: #007f68;
        }

        .back-button {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #00a88f;
            color: white;
            text-align: center;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            text-decoration: none;
            cursor: pointer;
        }

        .back-button:hover {
            background-color: #007f68;
        }
    </style>
</head>
<body>
    <header>
        <img src="images/g2.jpg" alt="Explore Mauritius Logo" />
        <h1>Add Outgoing Transaction</h1>
    </header>
    <form method="POST">
        <label for="amount">Amount</label>
        <input type="number" required name="amount" id="amount" step="0.01" placeholder="Enter the amount">
        
        <label for="date">Date</label>
        <input type="date" required name="date" id="date">
        
        <input type="submit" name="submit" value="Add Transaction">
        
        <a href="javascript:history.back()" class="back-button">Back</a>
    </form>
</body>
</html>