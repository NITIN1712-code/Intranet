<?php

    require("db_conn.php");

    $curDate = date("Y-m-d");

    if(isset($_POST["id"])){
        $attendance = 0;
        if($_POST["type"] == "present"){
            $attendance = 1;
        }

        $results = $conn->query("INSERT INTO attendance(employee_id,date_logged,attendance_status) 
                                 VALUES (".$_POST['id'].",'".$curDate."',".$attendance.")");

        if($results === FALSE){
            echo "An error occured..";
        }


        $conn->close();
        exit();
    }

    

    $result = $conn -> query("SELECT * FROM employees");

    $z = array();

    if($result->num_rows > 0){
        while($tab = $result->fetch_assoc()){

            $tab["check"] = "pending";

            $check = $conn -> query("SELECT * FROM attendance 
                                     WHERE employee_id = ".$tab["id"]." AND date_logged = '".$curDate."'");

            if($check->num_rows != 0){
                $tab["check"] = "absent";
                $row = $check->fetch_assoc();
                if($row["attendance_status"] == 1){
                    $tab["check"] = "present";
                }
            }
            $z[] = $tab;
        };
    }
    echo json_encode($z);

    $conn -> close();
    exit();
?>