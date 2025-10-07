<?php  

if (isset($_POST['email']) &&
    isset($_POST['full_name']) &&
    isset($_POST['message'])&&
	isset($_POST['date_time'])) {

    include "../DB_connection.php";
	
	$email     = $_POST['email'];
	$full_name = $_POST['full_name'];
	$message   = $_POST['message'];
	$date_time = $_POST['date_time'];

	if (empty($email)) {
		$em  = "Email is required";
		header("Location: ../index.php?error=$em#contact");
		exit;
	}else if (empty($full_name)) {
		$em  = "Full name is required";
		header("Location: ../index.php?error=$em#contact");
		exit;
	}else if (empty($message)) {
		$em  = "Massage is required";
		header("Location: ../index.php?error=$em#contact");
		exit;
	}else {
       $sql  = "INSERT INTO
                 message (sender_full_name, sender_email, message, date_time)
                 VALUES(?, ?, ?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$full_name, $email, $message, $date_time]);
        $sm = "Message sent successfully";
        header("Location: ../index.php?success=$sm#contact");
        exit;
	}

}else{
	header("Location: ../login.php");
	exit;
}