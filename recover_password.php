<?php
session_start();
include "database_connection.php";

// Make sure the reset session is set
if (!isset($_SESSION['reset_email'])) {
    header("Location: forgot_password.php?error=Unauthorized Access");
    exit;
}

$email = $_SESSION['reset_email'];
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $new_password     = trim($_POST['new_password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');

    if (empty($new_password) || empty($confirm_password)) {
        $error = "All fields are required!";
    } elseif ($new_password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update password in the single users table
        $sql  = "UPDATE users SET password = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt->execute([$hashed_password, $email])) {
            unset($_SESSION['reset_email']); // clear session
            $success = "Password reset successfully! You can now <a href='login.php'>log in</a>.";
        } else {
            $error = "An error occurred. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Recover Password</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css">
<link rel="icon" href="logo.png">
</head>
<body class="body-login">
<div class="black-fill">
    <div class="d-flex justify-content-center align-items-center flex-column">
        <form class="login" method="post">
            <div class="text-center">
                <img src="logo.png" width="100">
            </div>
            <h3>Password Recovery</h3>

            <?php if (isset($error)) { ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php } ?>

            <?php if (!empty($success)) { ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php } else { ?>
                <p>Email: <b><?= htmlspecialchars($email) ?></b></p>

                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" class="form-control" name="new_password" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" name="confirm_password" required>
                </div>

                <button type="submit" class="btn btn-success">Reset Password</button>

                <div class="mt-3">
                    <a href="login.php" class="text-decoration-none">Back to Login</a>
                </div>
            <?php } ?>
        </form>
    </div>
</div>
</body>
</html>
