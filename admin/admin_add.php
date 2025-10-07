<?php 
session_start();
if (isset($_SESSION['id']) && 
    isset($_SESSION['role_user'])) {

    if ($_SESSION['role_user'] == 'admin') {
      
       include "../database_connection.php";

       $email = '';
       $username = '';
       $password_admin = '';
       $role_user = 'admin';
       $question = '';
       $answer = '';
       $date_register = date("Y-m-d"); // Auto-insert today's date

       if (isset($_GET['email'])) $email = $_GET['email'];
       if (isset($_GET['username'])) $username = $_GET['username'];
       if (isset($_GET['password'])) $password_admin = $_GET['password'];
       if (isset($_GET['security_question'])) $question = $_GET['security_question'];
       if (isset($_GET['security_answer'])) $answer = $_GET['security_answer'];
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Add Admin</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="../logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php 
        include "inc/navbar.php";
     ?>
     <div class="container mt-5">
        <a href="admin.php"
           class="btn btn-dark">Go Back</a>

        <form method="post"
              class="shadow p-3 mt-5 form-w" 
              action="req/admin_add.php">
        <h3>Add Admin</h3><hr>
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
          <label class="form-label">Email</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$email?>" 
                 name="email" placeholder="Adauga un email...">
        </div>
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" 
                 class="form-control"
                 value="<?=$username?>"
                 name="username" placeholder="Adauga un username...">
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <div class="input-group mb-3">
              <input type="text" 
                     class="form-control"
                     name="password"
                     id="passwordInput" placeholder="Adauga o parola...">
              <button class="btn btn-secondary" id="gBtn">Random</button>
          </div>
          
          <!-- Role (Hidden, auto set to "student") -->
          <input type="hidden" name="role_user" value="admin">

          <div class="mb-3">
                <label class="form-label">Security Question</label>
                <select class="form-select" name="security_question" required>
                    <option value="" selected disabled>Selectează o întrebare...</option>
                    <option value="mom" <?= ($question == "mom") ? "selected" : "" ?>>What is your mother's maiden name?</option>
                    <option value="color" <?= ($question == "color") ? "selected" : "" ?>>What is your favourite color?</option>
                    <option value="food" <?= ($question == "food") ? "selected" : "" ?>>What is your favourite food?</option>
                    <option value="city" <?= ($question == "city") ? "selected" : "" ?>>What is the name of your city?</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Answer</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($answer) ?>"
                 name="security_answer" placeholder="Introduceți răspunsul..." required>
            </div>
            <div class="mb-3">
                <label class="form-label">Date Register</label>
                <input type="text" class="form-control" value="<?= $date_register ?>" name="date_register" readonly>
            </div>
          </div>
        </div>

      <button type="submit" class="btn btn-primary">Add</button>
     </form>
     </div>
     
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
    <script>
        $(document).ready(function(){
             $("#navLinks li:nth-child(2) a").addClass('active');
        });

        function makePass(length) {
            var result           = '';
            var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for ( var i = 0; i < length; i++ ) {
              result += characters.charAt(Math.floor(Math.random() * 
         charactersLength));

           }
           var passInput = document.getElementById('passwordInput');
           passInput.value = result;
        }

        var gBtn = document.getElementById('gBtn');
        gBtn.addEventListener('click', function(e){
          e.preventDefault();
          makePass(4);
        });
    </script>

</body>
</html>
<?php 

  }else {
    header("Location: ../login.php");
    exit;
  } 
}else {
	header("Location: ../login.php");
	exit;
} 

?>