<?php
session_start();
require('database.php');

$emailError = $passwordError = "";

// if(isset($_SESSION["email"])) {
//     session_destroy();
// }

if(isset($_POST['submit'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Please enter a valid email address";
    }

    $passwordRegex = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@#$%^&*!])[A-Za-z\d@#$%^&*!]{6,}$/';
    if (!preg_match($passwordRegex, $pass)) {
        $passwordError = "Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character, and be at least 6 characters long.";
    }

    if (empty($emailError) && empty($passwordError)) {
        $email = stripslashes($email);
        $email = addslashes($email);
        $pass = stripslashes($pass);
        $pass = addslashes($pass);
        $email = mysqli_real_escape_string($con, $email);
        $pass = mysqli_real_escape_string($con, $pass);

        $str = "SELECT * FROM user WHERE email='$email' and password='$pass'";
        $result = mysqli_query($con, $str);

        if(mysqli_num_rows($result) != 1) {
            $emailError = "Invalid email or password";
        } else {
            $_SESSION['logged'] = $email;
            $row = mysqli_fetch_array($result);
            $_SESSION['name'] = $row[1];
            $_SESSION['id'] = $row[0];
            $_SESSION['email'] = $row[2];
            $_SESSION['password'] = $row[3];
            header('location: welcome.php?q=1');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Login | Online Quiz System</title>
		<link rel="stylesheet" href="scripts/bootstrap/bootstrap.min.css">
		<link rel="stylesheet" href="scripts/ionicons/css/ionicons.min.css">
		<link rel="stylesheet" href="css/form.css">
        <style type="text/css">
            body{
                  width: 100%;
                  background: url(image/book.png) ;
                  background-position: center center;
                  background-repeat: no-repeat;
                  background-attachment: fixed;
                  background-size: cover;
                }
				.text-danger{
					color: red;
				}
          </style>
	</head>

	<body>
		<section class="login first grey">
            <div class="container">
                <div class="box-wrapper">
                    <div class="box box-border">
                        <div class="box-body">
						<center> <h5 style="font-family: Noto Sans;">Login to </h5><h4 style="font-family: Noto Sans;">Online Quiz System</h4></center><br>
                            <form method="post" action="login.php" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Enter Your Email Id <span class="text-danger">*</span></label>
                                    <input type="text" name="email" class="form-control">
                                    <span class="error text-danger"><?php echo $emailError; ?></span>
                                </div>
                                <div class="form-group">
                                    <label class="fw">Enter Your Password <span class="text-danger">*</span>
                                        <a href="javascript:void(0)" class="pull-right">Forgot Password?</a>
                                    </label>
                                    <input type="password" name="password" class="form-control">
                                    <span class="error text-danger"><?php echo $passwordError; ?></span>
                                </div>
								<div class="form-group text-right">
									<button class="btn btn-primary btn-block" name="submit">Login</button>
								</div>
								<div class="form-group text-center">
									<span class="text-muted">Don't have an account?</span> <a href="register.php">Register</a> Here..
								</div>
								<div class="form-group text-center">
									<span class="text-muted">For Admin Login?</span> <a href="admin.php">Login</a> Here..
								</div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

		<script src="js/jquery.js"></script>
		<script src="scripts/bootstrap/bootstrap.min.js"></script>
	</body>
</html>