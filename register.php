<?php 
include "database_connection.php";
include "data/setting.php";
$setting = getSetting($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Register - Aplicatie Licenta</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="icon" href="logo.png">
</head>
<body class="body-login">
    <div class="black-fill"><br /> <br />
    	<div class="d-flex justify-content-center align-items-center flex-column">
    	<form class="login" method="post" action="req/register.php">

    		<div class="text-center">
    			<img src="logo.png" width="100">
    		</div>
    		<h3>REGISTER</h3>
    		<?php if (isset($_GET['error'])) { ?>
    		<div class="alert alert-danger" role="alert">
			  <?=$_GET['error']?>
			</div>
			<?php } ?>
			<?php if (isset($_GET['success'])) { ?>
			<div class="alert alert-success" role="alert">
   			   <?=$_GET['success']?>
			</div>
			<?php } ?>
			<div class="mb-3">
		    <label class="form-label">Please write your Email</label>
		    <input type="text" 
		           class="form-control" name="email" required placeholder="Enter your email">
		  </div>

		  <div class="mb-3">
		    <label class="form-label">Please write your Username</label>
		    <input type="text" 
		           class="form-control" name="uname" required placeholder="Enter your username">
		  </div>

		  <div class="mb-3">
		    <label class="form-label">Please write your Password</label>
		    <input type="password" 
		           class="form-control" name="pass" id="password" required placeholder="Enter your password">
		  </div>

		  <div class="mb-3">
		    <label class="form-label">Please rewrite your Password</label>
		    <input type="password" 
		           class="form-control" name="password_rewrite" id="password_rewrite" required placeholder="Rewrite your passowrd">
		  </div>

		  <div class="mb-3 form-check">
    		<input type="checkbox" class="form-check-input" id="showPassword">
    		<label class="form-check-label" for="showPassword">Show Password</label>
		  </div>
		  
		  <div class="mb-3">
		    <label class="form-label">What Type of User you want to be:</label>
		    <select class="form-control"
		            name="role_user">
				<option value="" disabled selected>Select user type</option>
		    	<option value="admin">Admin</option>
		    	<option value="teacher">Teacher</option>
		    	<option value="student">Student</option>
		    	
		    </select>
		  </div>

		  <div class="mb-3">
		    <label class="form-label">Select Question:</label>
		    <select class="form-control"
		            name="question">
				<option value="" disabled selected>Please select your question</option>
		    	<option value="mom">Your mother name</option>
		    	<option value="color">Your favourite color</option>
		    	<option value="food">Favorite food</option>
		    	<option value="city">City name</option>
		    </select>
		  </div>

		  <div class="mb-3">
		    <label class="form-label">Write the answer of Question:</label>
		    <input type="text" class="form-control" name="answer" placeholder="Enter your answer">
		  </div>

		  <div class="mb-3">
        <label class="form-label">Date Register</label>
        <input type="date" 
           class="form-control"  name="date_register"
           value="<?= date('Y-m-d') ?>">
        </div>

			<div class="mb-3">
		  <a href="login.php" class="text-decoration-none"> Return to Login</a>
		    </div>

		  <button type="submit" class="btn btn-primary">Register</button>
		  <a href="index.php" class="text-decoration-none">Home</a>
		</form>
        
        <br /><br />
        <div class="text-center text-light">
        	Copyright &copy;<?=$setting['current_year']?>  <?=$setting['name']?>. All rights reserved.
        </div>

    	</div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	

	<script>
    document.getElementById("showPassword").addEventListener("change", function () {
        let password = document.getElementById("password");
        let passwordRewrite = document.getElementById("password_rewrite");
        
        if (this.checked) {
            password.type = "text";
            passwordRewrite.type = "text";
        } else {
            password.type = "password";
            passwordRewrite.type = "password";
        }
    });
	</script>
</body>
</html>

