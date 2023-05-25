<?php include("../inc/connect.inc.php"); ?>

<?php
ob_start();
session_start();
if (!isset($_SESSION['admin_login'])) {
} else {
	header("location: index.php");
}

if (isset($_POST['login'])) {
	if (isset($_POST['email']) && isset($_POST['password'])) {
		$user_login = mysqli_real_escape_string($con, $_POST['email']);
		$user_login = mb_convert_case($user_login, MB_CASE_LOWER, "UTF-8");
		$password_login = mysqli_real_escape_string($con, $_POST['password']);
		$num = 0;
		$password_login_md5 = md5($password_login);
		$result = mysqli_query($con, "SELECT * FROM admin WHERE (email='$user_login') AND password='$password_login_md5'");
		$num = mysqli_num_rows($result);
		$get_user_email = mysqli_fetch_assoc($result);
		$get_user_uname_db = $get_user_email['id'];
		if ($num > 0) {
			$_SESSION['admin_login'] = $get_user_uname_db;
			setcookie('admin_login', $user_login, time() + (365 * 24 * 60 * 60), "/");
			header('location: index.php');
			exit();
		} else {
			$error_message = '<br><br>
                <div class="maincontent_text" style="text-align: center; font-size: 18px;">
                <font face="bookman">Username or Password incorrect.<br>
                </font></div>';
		}
	}
}

$search_value = "";

?>

<!doctype html>
<html>

<head>
	<title>Welcome to ebuybd online shop</title>
	<link rel="stylesheet" type="text/css" href="./styles.css">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
	<div class="container">
		<div class="row">
			<div class="col-md-6 offset-md-3">
				<div class="holecontainer">
					<div class="signupform_content">
						<h2>Admin Login</h2>
						<div class="signupform_text"></div>
						<div>
							<form action="" method="POST" class="registration">
								<div class="signup_form">
									<div class="form-group">
										<input name="email" placeholder="Enter Your Email" required="required" class="form-control" type="email" value="">
									</div>
									<div class="form-group">
										<input name="password" required="required" placeholder="Enter Password" class="form-control" type="password" value="">
									</div>
									<div class="form-group">
										<input name="login" class="btn btn-primary btn-block" type="submit" value="Log In">
									</div>
									<div class="signup_error_msg">
										<?php
										if (isset($error_message)) {
											echo $error_message;
										}
										?>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

</html>