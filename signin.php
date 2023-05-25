<?php include("inc/connect.inc.php"); ?>
<?php
ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
} else {
	header("location: index.php");
}

$u_fname = "";
$u_lname = "";
$u_email = "";
$u_mobile = "";
$u_address = "";
$u_pass = "";

if (isset($_POST['signup'])) {
	//declere veriable
	$u_fname = $_POST['first_name'];
	$u_lname = $_POST['last_name'];
	$u_email = $_POST['email'];
	$u_mobile = $_POST['mobile'];
	$u_address = $_POST['signupaddress'];
	$u_pass = $_POST['password'];
	//triming name
	$_POST['first_name'] = trim($_POST['first_name']);
	$_POST['last_name'] = trim($_POST['last_name']);
	try {
		if (empty($_POST['first_name'])) {
			throw new Exception('Fullname can not be empty');
		}
		if (is_numeric($_POST['first_name'][0])) {
			throw new Exception('Please write your correct name!');
		}
		if (empty($_POST['last_name'])) {
			throw new Exception('Lastname can not be empty');
		}
		if (is_numeric($_POST['last_name'][0])) {
			throw new Exception('lastname first character must be a letter!');
		}
		if (empty($_POST['email'])) {
			throw new Exception('Email can not be empty');
		}
		if (empty($_POST['mobile'])) {
			throw new Exception('Mobile can not be empty');
		}
		if (empty($_POST['password'])) {
			throw new Exception('Password can not be empty');
		}
		if (empty($_POST['signupaddress'])) {
			throw new Exception('Address can not be empty');
		}


		// Check if email already exists

		$check = 0;
		$e_check = mysqli_query($con, "SELECT email FROM `user` WHERE email='$u_email'");
		$email_check = mysqli_num_rows($e_check);
		if (strlen($_POST['first_name']) > 2 && strlen($_POST['first_name']) < 20) {
			if (strlen($_POST['last_name']) > 2 && strlen($_POST['last_name']) < 20) {
				if ($check == 0) {
					if ($email_check == 0) {
						if (strlen($_POST['password']) > 1) {
							$d = date("Y-m-d"); //Year - Month - Day
							$_POST['first_name'] = ucwords($_POST['first_name']);
							$_POST['last_name'] = ucwords($_POST['last_name']);
							$_POST['last_name'] = ucwords($_POST['last_name']);
							$_POST['email'] = mb_convert_case($u_email, MB_CASE_LOWER, "UTF-8");
							$_POST['password'] = md5($_POST['password']);
							$confirmCode   = substr(rand() * 900000 + 100000, 0, 6);
							// send email
							$msg = "
						...
						
						Your activation code: " . $confirmCode . "
						Signup email: " . $_POST['email'] . "
						
						";
							//if (@mail($_POST['email'],"eBuyBD Activation Code",$msg, "From:eBuyBD <no-reply@ebuybd.xyz>")) {

							$result = mysqli_query($con, "INSERT INTO user (firstName,lastName,email,mobile,address,password,confirmCode) VALUES ('$_POST[first_name]','$_POST[last_name]','$_POST[email]','$_POST[mobile]','$_POST[signupaddress]','$_POST[password]','$confirmCode')");

							//success message
							$success_message = '
						<div class="signupform_content"><h2><font face="bookman">Registration successfull!</font></h2>
						<div class="signupform_text" style="font-size: 18px; text-align: center;">
						<font face="bookman">
							Email: ' . $u_email . '<br>
							Activation code sent to your email. <br>
							Your activation code: ' . $confirmCode . '
						</font></div></div>';
							//}else {
							//throw new Exception('Email is not valid!');
							//}


						} else {
							throw new Exception('Make strong password!');
						}
					} else {
						throw new Exception('Email already taken!');
					}
				} else {
					throw new Exception('Username already taken!');
				}
			} else {
				throw new Exception('Lastname must be 2-20 characters!');
			}
		} else {
			throw new Exception('Firstname must be 2-20 characters!');
		}
	} catch (Exception $e) {
		$error_message = $e->getMessage();
	}
}


?>


<!doctype html>
<html>

<head>
	<title>Welcome to ebuybd online shop</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<style>
		body {
			background: linear-gradient(to right, #e66465, #9198e5);
		}

		.container {
			max-width: 400px;
			margin-top: 100px;
		}

		.signup-form {
			background-color: #fff;
			padding: 40px;
			border-radius: 5px;
		}

		.signup-form h2 {
			text-align: center;
			margin-bottom: 30px;
		}

		.signup-form .form-group {
			margin-bottom: 20px;
		}

		.signup-form label {
			font-weight: bold;
		}

		.signup-form input[type="text"],
		.signup-form input[type="email"],
		.signup-form input[type="password"] {
			height: 45px;
			border-radius: 5px;
		}

		.signup-form .btn-primary {
			width: 100%;
			padding: 12px;
			border-radius: 5px;
		}

		.signup-form .signup_error_msg {
			color: red;
			text-align: center;
			margin-top: 10px;
		}

		.navbar {
			background-color: #fff;
			padding: 15px;
		}

		.navbar-brand {
			font-size: 24px;
			font-weight: bold;
		}
	</style>
</head>

<body>

	<div class="container">
		<?php
		if (isset($success_message)) {
			echo $success_message;
		} else {
			echo '
                    <div class="signup-form">
                        <h2>Sign Up Form!</h2>
                        <form action="" method="POST">
                            <div class="form-group">
                                <input name="first_name" id="first_name" placeholder="First Name" required="required" class="form-control" type="text" value="' . $u_fname . '">
                            </div>
                            <div class="form-group">
                                <input name="last_name" id="last_name" placeholder="Last Name" required="required" class="form-control" type="text" value="' . $u_lname . '">
                            </div>
                            <div class="form-group">
                                <input name="email" placeholder="Enter Your Email" required="required" class="form-control" type="email" value="' . $u_email . '">
                            </div>
                            <div class="form-group">
                                <input name="mobile" placeholder="Enter Your Mobile" required="required" class="form-control" type="text" value="' . $u_mobile . '">
                            </div>
                            <div class="form-group">
                                <input name="signupaddress" placeholder="Write Your Full Address" required="required" class="form-control" type="text" value="' . $u_address . '">
                            </div>
                            <div class="form-group">
                                <input name="password" id="password-1" required="required" placeholder="Enter New Password" class="form-control" type="password" value="' . $u_pass . '">
                            </div>
                            <div class="form-group">
                                <button name="signup" class="btn btn-primary" type="submit">Sign Me Up!</button>
                            </div>
                            <div class="signup_error_msg">';

			if (isset($error_message)) {
				echo $error_message;
			}

			echo '</div>
                        </form>
                    </div>
                ';
		}
		?>
	</div>
</body>

</html>