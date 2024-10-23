<?php 
session_start(); 
include "db_conn.php";

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

		$sqlAdmin = "SELECT * FROM admins WHERE username=? AND password=?";

		
		$stmt1 = mysqli_prepare($conn, $sqlAdmin);
		mysqli_stmt_bind_param($stmt1, "ss", $uname, $pass);
		mysqli_stmt_execute($stmt1);
		$result1 = mysqli_stmt_get_result($stmt1);
		echo $pass;
		if(mysqli_num_rows($result1) === 1){
			header("Location: admin_dashboard.php");
			mysqli_close($conn);
			exit();
		}



		$sqlEmp = "SELECT * FROM employees WHERE username=? AND password=?";
		$stmt2 = mysqli_prepare($conn, $sqlEmp);
		mysqli_stmt_bind_param($stmt2, "ss", $uname, $pass);
		mysqli_stmt_execute($stmt2);
		$result2 = mysqli_stmt_get_result($stmt2);
		if (mysqli_num_rows($result2) === 1) {
			$row = mysqli_fetch_assoc($result);
			header("Location: employee_dashboard.php");
		    exit();
		} else {
			header("Location: login.php?error=Incorrect User name or password");
	        exit();
		}
	}
} else {
	header("Location: login.php");
	exit();
}

