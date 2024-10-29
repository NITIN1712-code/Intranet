<?php

    require("db_conn.php");
    
    $val = $_GET["employeeName"];
    $first = $val;
    $last = $val;

    $pos = strpos($val, " ", 0);

    if($pos){
        $first = substr($val,0,$pos);
        $last = substr($val,$pos+1, strlen($val));
    }

    $result = "";

    if($last == $first){
        $result = $conn->query("SELECT * FROM employees
                            WHERE first_name LIKE '".$first."%' OR last_name LIKE '".$last."%'");
    }else{
        $result = $conn->query("SELECT * FROM employees
                            WHERE first_name LIKE '".$first."%' AND last_name LIKE '".$last."%'");

    }

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