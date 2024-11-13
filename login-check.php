<?php
session_start();




if (isset($_POST['uname']) && isset($_POST['password'])) {

    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data); // Escape special characters for security
       return $data;
    }

    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);

    if (empty($uname)) {
        header("Location: login.php?error=User Name is required");
        exit();
    } else if (empty($pass)) {
        header("Location: login.php?error=Password is required");
        exit();
    } else {
        include "db_conn.php";
        $sqlAdmin = "SELECT * FROM admins WHERE username=? AND password=?";
        $stmt1 = mysqli_prepare($conn, $sqlAdmin);
        mysqli_stmt_bind_param($stmt1, "ss", $uname, $pass);
        mysqli_stmt_execute($stmt1);
        $result1 = mysqli_stmt_get_result($stmt1);
        if(mysqli_num_rows($result1) === 1){
            mysqli_close($conn);
            header("Location: admin_dashboard.php");
            exit();
        }
        mysqli_stmt_close($stmt1);


        $empSql = "SELECT * FROM employees WHERE username=?";
        $empStmt = mysqli_prepare($conn, $empSql);
        mysqli_stmt_bind_param($empStmt, "s", $uname);
        mysqli_stmt_execute($empStmt);
        $empRes = mysqli_stmt_get_result($empStmt);
        while($row = mysqli_fetch_assoc($empRes)){
            if(password_verify($pass, $row["password"])){
                $_SESSION["id"] = $row["id"];
                header("Location: home.php");
                $conn->close();
                break;
            }
        }
        $conn -> close();
        exit();

    }
} else {
    header("Location: login.php");
    exit();
}
?>
