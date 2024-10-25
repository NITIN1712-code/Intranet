<?php

require("db_conn.php");

if(isset($_POST["pay_employee"])){

    $empId = $_POST["id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $bonus = $_POST["bonus"];

    $empSql = $conn->prepare("SELECT salary FROM employees WHERE id = ?");
    $empSql->bind_param("i",$empId);
    $salary = 0.00;
    $empSql->execute();
    $empSql->bind_result($salary);
    $empSql->fetch();
    $empSql->close();

    //to add email
    //to add to database

}


$conn->close();
?>