<?php 
session_start();

if (isset($_POST['email']) &&
    isset($_POST['uname']) &&
    isset($_POST['pass']) &&
    isset($_POST['password_rewrite']) &&
    isset($_POST['role_user']) &&
    isset($_POST['question']) &&
    isset($_POST['answer']) &&
    isset($_POST['date_register'])) {

    include "../database_connection.php";

    $email = trim($_POST['email']);
    $uname = trim($_POST['uname']);
    $pass = trim($_POST['pass']);
    $password_rewrite = trim($_POST['password_rewrite']);
    $role = $_POST['role_user'];
    $question = trim($_POST['question']);
    $answer = trim($_POST['answer']);
    $date_register = date('Y-m-d', strtotime($_POST['date_register']));

    // Validate required fields
    if (empty($email) || empty($uname) || empty($pass) || empty($password_rewrite) || 
        empty($role) || empty($question) || empty($answer) || empty($date_register)) {
        $em = "All fields are required.";
        header("Location: ../register.php?error=$em");
        exit;
    }

    // Check if passwords match
    if ($pass !== $password_rewrite) {
        $em = "Passwords do not match.";
        header("Location: ../register.php?error=$em");
        exit;
    }

    // Check for duplicate email
    $sql_check = "SELECT * FROM users WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->execute([$email]);

    if ($stmt_check->rowCount() > 0) {
        $em = "An account with this email already exists.";
        header("Location: ../register.php?error=$em");
        exit;
    }

    // Hash password for security
    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

    // Insert user into users table
    $sql = "INSERT INTO users (email, username, password, role_user, security_question, security_answer, date_register) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email, $uname, $hashed_pass, $role, $question, $answer, $date_register]);

    // Redirect with success
    $sm = "Account successfully created! You can now log in.";
    header("Location: ../register.php?success=$sm");
    exit;

} else {
    header("Location: ../register.php?error=Invalid request.");
    exit;
}
?>
