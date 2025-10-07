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
	<title>Login - Ecommerce User</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="icon" href="logo.png">
</head>
<body class="body-login">
    <div class="black-fill"><br /> <br />
    	<div class="d-flex justify-content-center align-items-center flex-column">
    	<form class="login" 
    	      method="post"
    	      action="req/login.php">

    		<div class="text-center">
    			<img src="logo.png"
    			     width="100">
    		</div>
    		<h3>LOGIN</h3>
    		<?php if (isset($_GET['error'])) { ?>
    		<div class="alert alert-danger" role="alert">
			  <?=$_GET['error']?>
			</div>
			<?php } ?>
		  <div class="mb-3">
		    <label class="form-label">Username</label>
		    <input type="text" 
		           class="form-control"
		           name="uname" placeholder="Enter your username">
		  </div>
		  
		  <div class="mb-3">
		    <label class="form-label">Password</label>
		    <input type="password" 
		           class="form-control" name="pass" id="password" placeholder="Enter your password">
		  </div>

		  <div class="mb-3 form-check">
    		<input type="checkbox" class="form-check-input" id="showPassword">
    		<label class="form-check-label" for="showPassword">Show Password</label>
		  </div>

		  <div class="mb-3">
		    <label class="form-label">Login As</label>
		    <select class="form-control"
		            name="role_user">
				<option value="" disabled selected>Select user type</option>
		    	<option value="admin">Admin</option>
		    	<option value="premium">Premium Client</option>
		    	<option value="client">Client</option>
		    	
		    </select>
		  </div>

		  <div class="mb-3">
		  <a href="register.php" class="text-decoration-none"> Register Here</a>
		  </div>

		  <div class="mb-3">
		  <a href="forgot_password.php" class="text-decoration-none"> Do you forget your password?</a>
		  </div>
		  
		  <button type="submit" class="btn btn-primary">Login</button>
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
        
        if (this.checked) {
            password.type = "text";
        } else {
            password.type = "password";
        }
    });
	</script>
</body>
</html>