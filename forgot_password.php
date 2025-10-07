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
    <title>Forgot Password</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="icon" href="logo.png">
</head>
<body class="body-login">
<div class="black-fill"><br /> <br />
<div class="d-flex justify-content-center align-items-center flex-column">
<form class="login" method="post" action="req/forgot_password.php">
    <div class="text-center">
        <img src="logo.png" width="100">
    </div>
    <h3>Forgot Password</h3>

    <?php if (isset($_GET['error'])) { ?>
        <div class="alert alert-danger" role="alert">
            <?= $_GET['error'] ?>
        </div>
    <?php } ?>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email">
    </div>

    <!-- Security Question will be displayed here -->
    <div class="mb-3" id="security-question-container" style="display: none;">
        <label class="form-label">Security Question</label>
        <input type="text" class="form-control" id="security_question" readonly>
    </div>

    <div class="mb-3">
        <label class="form-label">Answer</label>
        <input type="text" class="form-control" name="answer" placeholder="Enter your security answer">
    </div>

    <button type="submit" class="btn btn-primary">Recover Password</button>
    <a href="login.php" class="text-decoration-none">Return to Login</a>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $("#email").on("blur", function() {
        var email = $(this).val();
        if (email !== "") {
            $.ajax({
                url: "req/get_security_question.php",
                type: "POST",
                data: { email: email },
                success: function(response) {
                    if (response !== "not_found") {
                        $("#security-question-container").show();
                        $("#security_question").val(response);
                    } else {
                        $("#security-question-container").hide();
                        $("#security_question").val("");
                    }
                }
            });
        }
    });
});
</script>

	<br /><br />
        <div class="text-center text-light">
        	Copyright &copy;<?=$setting['current_year']?>  <?=$setting['name']?>. All rights reserved.
        </div>
</div>
</div>
</body>
</html>