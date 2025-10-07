<?php
session_start();
include "../database_connection.php";

if (isset($_POST['email']) && isset($_POST['answer'])) {
    $email  = trim($_POST['email']);
    $answer = strtolower(trim($_POST['answer'])); // match frontend input name

    if (empty($email) || empty($answer)) {
        header("Location: ../forgot_password.php?error=Please fill in all fields");
        exit;
    }

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);

    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch();
        $db_answer = strtolower(trim($user['security_answer'])); // stored in DB

        if ($answer === $db_answer) {
            $_SESSION['reset_email'] = $email; // save for password reset
            header("Location: ../recover_password.php");
            exit;
        } else {
            header("Location: ../forgot_password.php?error=Incorrect security answer");
            exit;
        }
    } else {
        // Generic message for security
        header("Location: ../forgot_password.php?error=If your email exists, a security question will be shown");
        exit;
    }
} else {
    header("Location: ../forgot_password.php?error=Invalid request");
    exit;
}
