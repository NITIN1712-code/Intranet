<?php
    require("db_conn.php");
    $id = $_GET["id"];

    $results = $conn -> query("SELECT dept_name
                               FROM departments
                               WHERE id = (SELECT department_id FROM employees WHERE id = ".$id.")");
    
    $row = $results -> fetch_assoc();

    echo $row["dept_name"];


    $conn -> close();

?>