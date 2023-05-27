<?php include("inc/connect.inc.php"); ?>
<?php

ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
	header("location: login.php");
} else {
	$user = $_SESSION['user_login'];
	$result = mysqli_query($con, "SELECT * FROM user WHERE id='$user'");
	$get_user_email = mysqli_fetch_assoc($result);
	$uname_db = $get_user_email['firstName'];
	$uemail_db = $get_user_email['email'];
	$upass = $get_user_email['password'];

	$umob_db = $get_user_email['mobile'];
	$uadd_db = $get_user_email['address'];
}

if (isset($_REQUEST['uid'])) {

	$user2 = mysqli_real_escape_string($con, $_REQUEST['uid']);
	if ($user != $user2) {
		header('location: index.php');
	}
} else {
	header('location: index.php');
}

if (isset($_POST['changesettings'])) {
	//declere veriable
	$email = $_POST['email'];
	$opass = $_POST['opass'];
	$npass = $_POST['npass'];
	$npass1 = $_POST['npass1'];
	//triming name
	try {
		if (empty($_POST['email'])) {
			throw new Exception('Email can not be empty');
		}
		if (isset($opass) && isset($npass) && isset($npass1) && ($opass != "" && $npass != "" && $npass1 != "")) {
			if (md5($opass) == $upass) {
				if ($npass == $npass1) {
					$npass = md5($npass);
					mysqli_query($con, "UPDATE user SET password='$npass' WHERE id='$user'");
					$success_message = '
						<div class="signupform_text" style="font-size: 18px; text-align: center;">
						<font face="bookman">
							Password changed.
						</font></div>';
				} else {
					$success_message = '
						<div class="signupform_text" style=" color: red; font-size: 18px; text-align: center;">
						<font face="bookman">
							New password not matched!
						</font></div>';
				}
			} else {
				$success_message = '
					<div class="signupform_text" style=" color: red; font-size: 18px; text-align: center;">
					<font face="bookman">
						Fillup password field exactly.
					</font></div>';
			}
		} else {
			$success_message = '
					<div class="signupform_text" style=" color: red; font-size: 18px; text-align: center;">
					<font face="bookman">
						Fillup password field exactly.
					</font></div>';
		}

		if ($uemail_db != $email) {
			if (mysqli_query($con, "UPDATE user SET  email='$email' WHERE id='$user'")) {
				//success message
				$success_message = '
					<div class="signupform_text" style="font-size: 18px; text-align: center;">
					<font face="bookman">
						Settings change successfull.
					</font></div>';
			}
		}
	} catch (Exception $e) {
		$error_message = $e->getMessage();
	}
}


?>

<!DOCTYPE html>
<html>

<head>
	<title>RoboHash</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
	<?php include("./components/min-navbar.php") ?>
	<?php include("./components/user-categorylist.php") ?>

	<div class="container mt-4">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<form action="" method="POST" class="registration">
					<div class="card">
						<div class="card-header">
							<h5 class="mb-0">Change Password:</h5>
						</div>
						<div class="card-body">
							<div class="form-group">
								<label for="opass">Old Password:</label>
								<input class="form-control" type="password" name="opass" placeholder="Old Password">
							</div>
							<div class="form-group">
								<label for="npass">New Password:</label>
								<input class="form-control" type="password" name="npass" placeholder="New Password">
							</div>
							<div class="form-group">
								<label for="npass1">Repeat Password:</label>
								<input class="form-control" type="password" name="npass1" placeholder="Repeat Password">
							</div>
							<hr>
							<div class="form-group">
								<h5>Change Email:</h5>
								<input class="form-control" required type="email" name="email" placeholder="New Email" value="<?php echo $uemail_db; ?>">
							</div>
							<div class="form-group">
								<input class="btn btn-primary" type="submit" name="changesettings" value="Update Settings">
							</div>
							<div>
								<?php if (isset($success_message)) {
									echo $success_message;
								} ?>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>

</html>