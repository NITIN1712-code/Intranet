<?php 
session_start(); 
include "db_conn.php";

if (isset($_POST['uname']) && isset($_POST['password'])) {

    function validate($data) {
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
        // Check in the admins table
        $sqlAdmin = "SELECT * FROM admins WHERE password=? AND username=?";
        $stmt1 = mysqli_prepare($conn, $sqlAdmin);

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

        // Check in the employees table
        $sqlEmp = "SELECT * FROM employees WHERE username=?";
        $stmt2 = mysqli_prepare($conn, $sqlEmp);

        if ($stmt2 === false) {
            die('Prepare failed: ' . htmlspecialchars(mysqli_error($conn)));
        }

        mysqli_stmt_bind_param($stmt2, "s", $uname);
        mysqli_stmt_execute($stmt2);
        $result2 = mysqli_stmt_get_result($stmt2);

        if (mysqli_num_rows($result2) === 1) {
            // Fetch the employee row
            $row2 = mysqli_fetch_assoc($result2);
            // Verify the password
            if (password_verify($pass, $row2['password'])) {
                // Password is correct
                $_SESSION['username'] = $row2['username']; // Store session data
                header("Location: employee_dashboard.php");
                exit();
            } else {
                header("Location: login.php?error=Incorrect password for employee");
                exit();
            }
        }

        // If no match found in both tables
        header("Location: login.php?error=Incorrect User name or password");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>
