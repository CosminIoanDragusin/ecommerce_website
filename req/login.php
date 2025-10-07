<?php 
session_start();

if (isset($_POST['uname']) &&
    isset($_POST['pass']) &&
    isset($_POST['role_user'])) {

	include "../database_connection.php";
	
	$uname = $_POST['uname'];
	$pass = $_POST['pass'];
	$role = $_POST['role_user'];

	if (empty($uname)) {
		$em  = "Username is required";
		header("Location: ../login.php?error=$em");
		exit;
	}else if (empty($pass)) {
		$em  = "Password is required";
		header("Location: ../login.php?error=$em");
		exit;
	}else if (empty($role)) {
		$em  = "An error Occurred";
		header("Location: ../login.php?error=$em");
		exit;
	}else {
        
        if($role == 'admin'){
        	$sql = "SELECT * FROM users 
        	        WHERE username = ?";
        	$role = "admin";
			$password_field = "password";
        }else if($role == 'premium'){
        	$sql = "SELECT * FROM users 
        	        WHERE username = ?";
        	$role = "premium";
			$password_field = "password_teacher";
        }else if($role == 'client'){
        	$sql = "SELECT * FROM users 
        	        WHERE username = ?";
        	$role = "client";
			$password_field = "password";
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute([$uname]);

        if ($stmt->rowCount() == 1) {
        	$user = $stmt->fetch();
        	$username = $user['username'];
			$password = $user[$password_field];
        	
            if ($username === $uname) {
            	if (password_verify($pass, $password)) {
            		$_SESSION['role_user'] = $role;
            		if ($role == 'admin') {
                        $id = $user['id'];
                        $_SESSION['id'] = $id;
                        header("Location: ../admin/admin.php");
                        exit;
                    }else if ($role == 'premium') {
                        $id = $user['id'];
                        $_SESSION['id'] = $id;
                        header("Location: ../premium/index.php");
                        exit;
                    }else if($role == 'client'){
                    	$id = $user['id'];
                        $_SESSION['id'] = $id;
                        header("Location: ../client/index.php");
                        exit;
                    }else {
                    	$em  = "Incorrect Username or Password";
				        header("Location: ../login.php?error=$em");
				        exit;
                    }
				    
            	}else {
		        	$em  = "Incorrect Username or Password1";
				    header("Location: ../login.php?error=$em");
				    exit;
		        }
            }else {
	        	$em  = "Incorrect Username or Password2";
			    header("Location: ../login.php?error=$em");
			    exit;
	        }
        }else {
        	$em  = "Incorrect Username or Password3";
		    header("Location: ../login.php?error=$em");
		    exit;
        }
	}


}else{
	header("Location: ../login.php");
	exit;
}