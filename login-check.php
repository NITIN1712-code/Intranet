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
		// Hashing the password for security
        $pass = md5($pass); 

		// Secure SQL query using prepared statements to prevent SQL injection
		$sql = "SELECT * FROM users WHERE user_name=? AND user_password=?";
		$stmt = mysqli_prepare($conn, $sql);
		mysqli_stmt_bind_param($stmt, "ss", $uname, $pass);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);

		if (mysqli_num_rows($result) === 1) {
			$row = mysqli_fetch_assoc($result);
            // Store user data in session
            $_SESSION['user_name'] = $row['user_name'];  // Correctly referencing user_name
            $_SESSION['name'] = $row['name'];             // Assuming 'name' exists in your table
            $_SESSION['userid'] = $row['userid'];         // Correctly referencing userid
			header("Location: user-display.php");
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

