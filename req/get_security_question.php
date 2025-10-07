<?php
include "../database_connection.php";

if (isset($_POST['email'])) {
    $email = trim($_POST['email']);

    $sql = "SELECT security_question FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && !empty($user['security_question'])) {
        echo htmlspecialchars($user['security_question']); // safe output
    } else {
        echo "not_found";
    }
} else {
    echo "not_found";
}
