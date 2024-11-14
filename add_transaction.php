
<?php
    require("db_conn.php");
    if(isset($_POST["submit"])){

        $statement = $conn->prepare("INSERT INTO outgoing_transaction(paymentAmount, payment_date)
                                    VALUES(?,?)");
        $statement->bind_param("ds",$_POST["amount"],$_POST["date"]);

        $statement->execute();
        
        echo "<script> alert('success!') </script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST">
        <label for="amount">Amount</label>
        <input type="number" required name="amount">
        <label for="date">Date</label>
        <input type="date" required name="date">

        <input type="submit" name="submit" value="Add Transaction">
    </form>
</body>
</html>