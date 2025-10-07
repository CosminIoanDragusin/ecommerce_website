<?php 
session_start();
if (isset($_SESSION['id']) && 
    isset($_SESSION['role_user'])) {

    if ($_SESSION['role_user'] == 'admin') {
    	

if (isset($_POST['email']) &&
    isset($_POST['username']) &&
    isset($_POST['password']) &&
    isset($_POST['role_user'])     &&
    isset($_POST['security_question'])  &&
    isset($_POST['security_answer'])   &&
    isset($_POST['date_register'])) {
    
    include '../../database_connection.php';
    include "../data/admin.php";

    $email = $_POST['email'];
    $username = $_POST['username'];
    $password_admin = $_POST['password'];
    $role_user = $_POST['role_user'];

    $question = $_POST['security_question'];
    $answer = $_POST['security_answer'];
    $date_register = date('Y-m-d', strtotime($_POST['date_register']));

    $data = 'email='.$email.'&username='.$username.'&role_user='.$role_user.'&security_question='.$question.'&security_answer='.$answer.'&date_register='.$date_register;

    if (empty($email)) {
		$em  = "Email is required";
		header("Location: ../admin_add.php?error=$em&$data");
		exit;
	}else if (empty($question)) {
		$em  = "Question  is required";
		header("Location: ../admin_add.php?error=$em&$data");
		exit;
	}else if (empty($role_user)) {
		$em  = "Role User is required";
		header("Location: ../admin_add.php?error=$em&$data");
		exit;
	}else if (!unameIsUnique($username, $conn)) {
		$em  = "Username is taken! try another";
		header("Location: ../admin_add.php?error=$em&$data");
		exit;
	}else if (empty($password_admin)) {
		$em  = "Password is required";
		header("Location: ../admin_add.php?error=$em&$data");
		exit;
	}else if (empty($answer)) {
        $em  = "Answer is required";
        header("Location: ../admin_add.php?error=$em&$data");
        exit;
    }else if (empty($date_register)) {
        $em  = "Date Register is required";
        header("Location: ../admin_add.php?error=$em&$data");
        exit;
    }else {
        // hashing the password
        $password_admin = password_hash($password_admin, PASSWORD_DEFAULT);
        $sql  = "INSERT INTO
                 users(email, username, password, role_user, security_question, security_answer, date_register)
                 VALUES(?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email, $username, $password_admin, $role_user, $question, $answer, $date_register]);
        $sm = "New user admin registered successfully";
        header("Location: ../admin_add.php?success=$sm");
        exit;
	}
    
  }else {
  	$em = "An error occurred";
    header("Location: ../admin_add.php?error=$em");
    exit;
  }

  }else {
    header("Location: ../../logout.php");
    exit;
  } 
}else {
	header("Location: ../../logout.php");
	exit;
} 