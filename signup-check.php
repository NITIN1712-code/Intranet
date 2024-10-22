<?php 
session_start(); 
include "db_conn.php";

if (isset($_POST['uname']) && isset($_POST['password'])
    && isset($_POST['name']) && isset($_POST['re_password']) && isset($_POST['phone'])) {

	function validate($data){
	   $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data); // Escape special characters for security
	   return $data;
	}

	$uname = validate($_POST['uname']);
	$pass = validate($_POST['password']);
	$re_pass = validate($_POST['re_password']);
	$name = validate($_POST['name']);
	$phone = validate($_POST['phone']);

	$user_data = 'uname='. $uname. '&name='. $name. '&phone='. $phone;

	if (empty($uname)) {
		header("Location: signup.php?error=User Name is required&$user_data");
	    exit();
	} else if (empty($pass)) {
        header("Location: signup.php?error=Password is required&$user_data");
	    exit();
	} else if (empty($re_pass)) {
        header("Location: signup.php?error=Re-enter your password&$user_data");
	    exit();
	} else if (empty($name)) {
        header("Location: signup.php?error=Name is required&$user_data");
	    exit();
	} else if (empty($phone)) {
        header("Location: signup.php?error=Phone Number is required&$user_data");
	    exit();
	} else if (!preg_match("/^[0-9]{8}$/", $phone)) {
		header("Location: signup.php?error=Phone number must be 8 digits&$user_data");
	    exit();
	} else if ($pass !== $re_pass) {
        header("Location: signup.php?error=The confirmation password does not match&$user_data");
	    exit();
	} else {
		// Hashing the password for security
        $pass = md5($pass);

		// Secure SQL query using prepared statements
	    $sql = "SELECT * FROM users WHERE user_name=?";
	    $stmt = mysqli_prepare($conn, $sql);
	    mysqli_stmt_bind_param($stmt, "s", $uname);
	    mysqli_stmt_execute($stmt);
	    $result = mysqli_stmt_get_result($stmt);

		if (mysqli_num_rows($result) > 0) {
			header("Location: signup.php?error=The username is already taken&$user_data");
	        exit();
		} else {
			$sql2 = "INSERT INTO users(user_name, user_password, name, user_phoneNum) VALUES(?, ?, ?, ?)";
			$stmt2 = mysqli_prepare($conn, $sql2);
			mysqli_stmt_bind_param($stmt2, "ssss", $uname, $pass, $name, $phone);
			$result2 = mysqli_stmt_execute($stmt2);

			if ($result2) {
				header("Location: signup.php?success=Your account has been created successfully");
		        exit();
			} else {
				header("Location: signup.php?error=An unknown error occurred&$user_data");
		        exit();
			}
		}
	}
} else {
	header("Location: signup.php");
	exit();
}
?>
