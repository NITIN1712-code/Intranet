<?php
    require("db_conn.php");

    $curYear = date("Y");

    $res = $conn->query("SELECT COUNT(*) AS days_present FROM attendance
                         WHERE MONTH(date_logged) = ".$_GET["month"]." AND YEAR(CURDATE()) = ".$curYear." AND employee_id = ".$_GET["id"]." AND attendance_status=1");

    echo $res->fetch_assoc()["days_present"];

?>