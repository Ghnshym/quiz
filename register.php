<?php
include("database.php");
session_start();

$nameError = $emailError = $passwordError = $collegeError = "";

if(isset($_POST['submit']))
{	
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $college = $_POST['college'];

    if (empty($name)) {
        $nameError = "Name is required";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Please enter a valid email address";
    }

    $passwordRegex = '/^(?=.*[!@#$%^&*])(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{6,}$/';
    if (!preg_match($passwordRegex, $password)) {
        $passwordError = "Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character, and be at least 6 characters long.";
    }

    if (empty($college)) {
        $collegeError = "College is required";
    }

    if (empty($nameError) && empty($emailError) && empty($passwordError) && empty($collegeError)) {
        $str = "SELECT email from user WHERE email='$email'";
        $result = mysqli_query($con, $str);

        if(mysqli_num_rows($result) > 0) {
            $emailError = "This email is already registered";
        } else {
            $str = "INSERT INTO user SET name='$name', email='$email', password='$password', college='$college'";
            if(mysqli_query($con, $str)) {
                echo "<center><h3><script>alert('Congrats.. You have successfully registered !!');</script></h3></center>";
                header('location: welcome.php?q=1');
                exit;
            }
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
		<title>Register | Online Quiz System</title>
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
							<center> <h5 style="font-family: Noto Sans;">Register to </h5><h4 style="font-family: Noto Sans;">Online Quiz System</h4></center><br>
							<form method="post" action="register.php" enctype="multipart/form-data">
							<div class="form-group">
								<label>Enter Your Username <span class="text-danger">*</span></label>
								<input type="text" name="name" class="form-control"  />
								<span class="error text-danger"><?php echo $nameError; ?></span>
							</div>
							<div class="form-group">
								<label>Enter Your Email Id <span class="text-danger">*</span></label>
								<input type="text" name="email" class="form-control"  />
								<span class="error text-danger"><?php echo $emailError; ?></span>
							</div>
							<div class="form-group">
								<label>Enter Your Password <span class="text-danger">*</span></label>
								<input type="password" name="password" class="form-control"  />
								<span class="error text-danger"><?php echo $passwordError; ?></span>
							</div>
							<div class="form-group">
								<label>Enter Your College Name <span class="text-danger">*</span></label>
								<input type="text" name="college" class="form-control"  />
								<span class="error text-danger"><?php echo $collegeError; ?></span>
							</div>

							<div class="form-group text-right">
								<button class="btn btn-primary btn-block" name="submit">Register</button>
							</div>
							<div class="form-group text-center">
								<span class="text-muted">Already have an account! </span> <a href="login.php">Login </a> Here..
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