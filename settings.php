<?php
ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
	header("location: login.php");
} else {
	$user = $_SESSION['user_login'];
	include("inc/connect.inc.php");
	$stmt = $pdo->prepare("SELECT * FROM user WHERE id = ?");
	$stmt->execute([$user]);
	$get_user_email = $stmt->fetch(PDO::FETCH_ASSOC);
	$uname_db = $get_user_email['firstName'];
	$uemail_db = $get_user_email['email'];
	$upass = $get_user_email['password'];
	$umob_db = $get_user_email['mobile'];
	$uadd_db = $get_user_email['address'];
}

if (isset($_REQUEST['uid'])) {
	$user2 = $_REQUEST['uid'];
	if ($user != $user2) {
		header('location: index.php');
	}
} else {
	header('location: index.php');
}

if (isset($_POST['changesettings'])) {
	// declare variables
	$email = $_POST['email'];
	$opass = $_POST['opass'];
	$npass = $_POST['npass'];
	$npass1 = $_POST['npass1'];
	// trimming name
	try {
		if (empty($_POST['email'])) {
			throw new Exception('Email cannot be empty');
		}
		if (isset($opass) && isset($npass) && isset($npass1) && ($opass != "" && $npass != "" && $npass1 != "")) {
			if (md5($opass) == $upass) {
				if ($npass == $npass1) {
					$npass = md5($npass);
					$stmt = $pdo->prepare("UPDATE user SET password = ? WHERE id = ?");
					$stmt->execute([$npass, $user]);
					$success_message = '
                        <div class="signupform_text" style="font-size: 18px; text-align: center;">
                            <font face="bookman">
                                Password changed.
                            </font>
                        </div>';
				} else {
					$success_message = '
                        <div class="signupform_text" style="color: red; font-size: 18px; text-align: center;">
                            <font face="bookman">
                                New password not matched!
                            </font>
                        </div>';
				}
			} else {
				$success_message = '
                    <div class="signupform_text" style="color: red; font-size: 18px; text-align: center;">
                        <font face="bookman">
                            Fill up password field exactly.
                        </font>
                    </div>';
			}
		} else {
			$success_message = '
                <div class="signupform_text" style="color: red; font-size: 18px; text-align: center;">
                    <font face="bookman">
                        Fill up password field exactly.
                    </font>
                </div>';
		}

		if ($uemail_db != $email) {
			$stmt = $pdo->prepare("UPDATE user SET email = ? WHERE id = ?");
			$stmt->execute([$email, $user]);
			$success_message = '
                <div class="signupform_text" style="font-size: 18px; text-align: center;">
                    <font face="bookman">
                        Settings change successful.
                    </font>
                </div>';
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