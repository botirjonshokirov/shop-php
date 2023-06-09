<?php include("inc/connect.inc.php"); ?>

<?php
ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
} else {
	header("location: index.php");
	exit();
}
$emails = "";
$passs = "";
if (isset($_POST['login'])) {
	if (isset($_POST['email']) && isset($_POST['password'])) {
		$user_login = $_POST['email'];
		$user_login = mb_convert_case($user_login, MB_CASE_LOWER, "UTF-8");
		$password_login = $_POST['password'];
		$num = 0;
		$password_login_md5 = md5($password_login);
		$stmt = $pdo->prepare("SELECT * FROM user WHERE (email=:user_login) AND password=:password_login_md5 AND activation='yes'");
		$stmt->bindParam(':user_login', $user_login);
		$stmt->bindParam(':password_login_md5', $password_login_md5);
		$stmt->execute();
		$num = $stmt->rowCount();
		$get_user_email = $stmt->fetch(PDO::FETCH_ASSOC);
		$get_user_uname_db = $get_user_email['id'];
		if ($num > 0) {
			$_SESSION['user_login'] = $get_user_uname_db;
			setcookie('user_login', $user_login, time() + (365 * 24 * 60 * 60), "/");

			if (isset($_REQUEST['ono'])) {
				$ono = $_REQUEST['ono'];
				header("location: orderform.php?poid=" . $ono . "");
			} else {
				header('location: index.php');
			}
			exit();
		} else {
			$stmt = $pdo->prepare("SELECT * FROM user WHERE (email=:user_login) AND password=:password_login_md5 AND activation='no'");
			$stmt->bindParam(':user_login', $user_login);
			$stmt->bindParam(':password_login_md5', $password_login_md5);
			$stmt->execute();
			$num1 = $stmt->rowCount();
			$get_user_email1 = $stmt->fetch(PDO::FETCH_ASSOC);
			$get_user_uname_db1 = $get_user_email1['id'];
			if ($num1 > 0) {
				$emails = $user_login;
				$activacc = '';
			} else {
				$emails = $user_login;
				$passs = $password_login;
				$error_message = '<br><br>
				<div class="maincontent_text" style="text-align: center; font-size: 18px;">
				<font face="bookman">Email or Password incorrect.<br>
				</font></div>';
			}
		}
	}
}
$acemails = "";
$acccode = "";
if (isset($_POST['activate'])) {
	if (isset($_POST['actcode'])) {
		$user_login = $_POST['acemail'];
		$user_login = mb_convert_case($user_login, MB_CASE_LOWER, "UTF-8");
		$user_acccode = $_POST['actcode'];
		$stmt = $pdo->prepare("SELECT * FROM user WHERE (email=:user_login) AND confirmCode=:user_acccode");
		$stmt->bindParam(':user_login', $user_login);
		$stmt->bindParam(':user_acccode', $user_acccode);
		$stmt->execute();
		$num3 = $stmt->rowCount();
		echo $user_login;
		if ($num3 > 0) {
			$get_user_email = $stmt->fetch(PDO::FETCH_ASSOC);
			$get_user_uname_db = $get_user_email['id'];
			$_SESSION['user_login'] = $get_user_uname_db;
			setcookie('user_login', $user_login, time() + (365 * 24 * 60 * 60), "/");
			$update_stmt = $pdo->prepare("UPDATE user SET confirmCode='0', activation='yes' WHERE email=:user_login");
			$update_stmt->bindParam(':user_login', $user_login);
			$update_stmt->execute();
			if (isset($_REQUEST['ono'])) {
				$ono = $_REQUEST['ono'];
				header("location: orderform.php?poid=" . $ono . "");
			} else {
				header('location: index.php');
			}
			exit();
		} else {
			$emails = $user_login;
			$error_message = '<br><br>
				<div class="maincontent_text" style="text-align: center; font-size: 18px;">
				<font face="bookman">Code not matched!<br>
				</font></div>';
		}
	} else {
		$error_message = '<br><br>
				<div class="maincontent_text" style="text-align: center; font-size: 18px;">
				<font face="bookman">Activation code not matched!<br>
				</font></div>';
	}
}

?>

<!doctype html>
<html>

<head>
	<title>RoboHash</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<style>
		body {
			background: linear-gradient(to right, #e66465, #9198e5);
		}

		.container {
			max-width: 400px;
			margin-top: 100px;
		}

		.login-form {
			background-color: #fff;
			padding: 40px;
			border-radius: 5px;
		}

		.login-form h2 {
			text-align: center;
			margin-bottom: 30px;
		}

		.login-form .form-group {
			margin-bottom: 20px;
		}

		.login-form label {
			font-weight: bold;
		}

		.login-form input[type="email"],
		.login-form input[type="password"] {
			height: 45px;
			border-radius: 5px;
		}

		.login-form .btn-primary {
			width: 100%;
			padding: 12px;
			border-radius: 5px;
		}

		.login-form .forgetpass {
			float: right;
			color: #666;
		}
	</style>
</head>

<body>
	<div class="container">
		<div class="login-form">
			<?php
			if (isset($activacc)) {
				echo '<h2>Activation Form</h2>';
			} else {
				echo '<h2>Login Form</h2>';
			}
			?>
			<form action="" method="POST">
				<div class="form-group">
					<?php
					if (isset($activacc)) {
						echo '
                        <input name="acemail" placeholder="Enter Your Email" required="required" class="form-control" type="email" value="' . $emails . '">
                    ';
					} else {
						echo '
                        <input name="email" placeholder="Enter Your Email" required="required" class="form-control" type="email" value="' . $emails . '">
                    ';
					}
					?>
				</div>
				<div class="form-group">
					<input name="password" required="required" placeholder="Enter Password" class="form-control" type="password" value="<?php echo $passs; ?>">
				</div>
				<div class="form-group">
					<?php
					if (isset($activacc)) {
						echo '
                        <input name="actcode" placeholder="Activation Code" required="required" class="form-control" type="text" value="' . $acccode . '">
                    ';
					} else {
						echo '
                        <input name="login" class="btn btn-primary" type="submit" value="Log In">
                    ';
					}
					?>
					<?php if (!isset($activacc)) : ?>
						<a class="forgetpass" href="forgetpass.php">Forgot your password?</a>
					<?php endif; ?>
				</div>
				<div class="text-danger">
					<?php if (isset($error_message)) echo $error_message; ?>
				</div>
			</form>
		</div>
	</div>
</body>

</html>