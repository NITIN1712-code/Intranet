<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SIGN UP</title>
	<link rel="stylesheet" type="text/css" href="loginphp.css">
</head>
<body>

    <!-- Signup Form -->
    <form action="signup-check.php" method="post">
     	<h2>SIGN UP</h2>

        <!-- Error Message -->
     	<?php if (isset($_GET['error'])) { ?>
     		<p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
     	<?php } ?>

        <!-- Success Message -->
        <?php if (isset($_GET['success'])) { ?>
            <p class="success"><?php echo htmlspecialchars($_GET['success']); ?></p>
        <?php } ?>

        <!-- Name Input Field -->
        <label>Name</label>
        <input type="text" 
               name="name" 
               placeholder="Name" 
               value="<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : ''; ?>" required><br>

        <!-- User Name Input Field -->
        <label>User Name</label>
        <input type="text" 
               name="uname" 
               placeholder="User Name" 
               value="<?php echo isset($_GET['uname']) ? htmlspecialchars($_GET['uname']) : ''; ?>" required><br>

        <!-- Phone Number Input Field -->
        <label>Phone Number</label>
        <input type="text" 
               name="phone" 
               placeholder="Phone Number" 
               value="<?php echo isset($_GET['phone']) ? htmlspecialchars($_GET['phone']) : ''; ?>" required><br>

        <!-- Password Input Field -->
     	<label>Password</label>
     	<input type="password" name="password" placeholder="Password" required><br>

        <!-- Re-Password Input Field -->
        <label>Re Password</label>
        <input type="password" name="re_password" placeholder="Re_Password" required><br>

        <button type="submit">Sign Up</button>
        <a href="login.php" class="ca">Already have an account?</a>
    </form>
</body>
</html>
