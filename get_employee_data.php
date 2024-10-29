<?php

    require("db_conn.php");

    $val = $_GET["employeeName"];


    $result = $conn->query("SELECT * FROM employees
                            WHERE first_name LIKE '".$val."%'");

    $employeeData = array();

    if($result -> num_rows > 0){

        while($row = $result->fetch_assoc()){
            $employeeData[] = $row;
        }
        
        echo json_encode($employeeData);

    }else{
        echo "ND";
    }



    $conn->close();

?>