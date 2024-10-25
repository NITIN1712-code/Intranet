<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="process_payroll.css">
</head>
<body>
    
    <header>
        <h1>Processing Payroll</h1>
    </header>

    <main>
        <section>
            <?php 
                if(!isset($_GET["id"])){
                    echo '
                    <form method="GET">
                        <label for="id">Input Employee ID</label>
                        <input type="text" name = "id">
                        <input type="submit" value="Search Employee">
                    </form>
                    ';
                }else{
                    require("db_conn.php");

                    $empStatement = $conn->prepare("SELECT id,first_name, last_name, email FROM employees WHERE id = ?");
                    $empStatement->bind_param("i",$_GET["id"]);
                    $empStatement->execute();
                    $empStatement->bind_result($id,$fname, $lname, $email);
                    $empStatement->fetch();
                    $empStatement->close();
                    if(!isset($id)){
                        echo"Employee NOT FOUND";
                    }else{
                        echo '
                        <form method="POST" action ="payroll_payment.php">
                            <label for="id">Employee ID:</label>
                            <input type="text" name="id" value='. $_GET["id"] .' required>

                            <label for="name">Name:</label>
                            <input type="name" name="name" value="'.$fname.' '.$lname.'" required>

                            <label for="email">Email:</label>
                            <input type="email" name="email" value='.$email.' required>

                            <label for="bonus">Bonus (optional):</label>
                            <input type="text" name="bonus">

                            <input type="submit" name="pay_employee" value="Pay Employee">
                        </form>
                        ';
                    }
                    $conn->close();
                }
            ?>

            
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Intranet HR System. All rights reserved.</p>
    </footer>
</body>
</html>