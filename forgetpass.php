<?php
ob_start();
session_start();

// Include the necessary files and establish a database connection
include("./inc/connect.inc.php");

if (isset($_POST['searchId'])) {
	$email = $_POST['username'];

	// Validate the email format
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$error_message = "Invalid email format";
	} else {
		// Check if the email exists in the database
		$query = "SELECT * FROM user WHERE email=:email";
		$stmt = $pdo->prepare($query);
		$stmt->bindParam(':email', $email);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			$_SESSION['email'] = $email;
			$_SESSION['reset'] = true;
			$success_message = "User found! Please enter a new password.";
		} else {
			$error_message = "Account not found. Please check your email and try again.";
		}
	}
}

if (isset($_POST['resetPassword'])) {
	if (isset($_SESSION['reset']) && $_SESSION['reset'] === true && isset($_SESSION['email'])) {
		$newPassword = $_POST['newPassword'];
		$confirmPassword = $_POST['confirmPassword'];

		if ($newPassword === $confirmPassword) {
			// Hash the new password before storing it in the database
			$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
			$email = $_SESSION['email'];

			// Update the user's password in the database
			$updateQuery = "UPDATE user SET password=:password WHERE email=:email";
			$stmt = $pdo->prepare($updateQuery);
			$stmt->bindParam(':password', md5($newPassword));
			$stmt->bindParam(':email', $email);
			$updateResult = $stmt->execute();

			if ($updateResult) {
				$success_message = "Password reset successfully!";
				// Clear session variables
				unset($_SESSION['email']);
				unset($_SESSION['reset']);
				// Redirect to login page
				header("Location: login.php");
				exit(); // Make sure to exit after redirecting
			} else {
				$error_message = "Failed to reset password. Please try again.";
			}
		} else {
			$error_message = "Passwords do not match. Please try again.";
		}
	} else {
		$error_message = "Invalid reset request. Please try again.";
	}
}

// Function to generate a temporary password
function generateTempPassword()
{
	// Generate a random temporary password
	$tempPassword = substr(md5(uniqid(rand(), true)), 0, 8);

	return $tempPassword;
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Password Recovery</title>
	<link rel="icon" href="image/title.png" type="image/x-icon">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="./css/style.css">
</head>

<body>
	<?php include("./components/min-navbar.php") ?>

	<div class="container">
		<div class="card">
			<div class="card-body">
				<?php if (isset($_SESSION['reset']) && $_SESSION['reset'] === true && isset($_SESSION['email'])) { ?>
					<h2 class="card-title">Reset Password</h2>
					<div class="card-text">
						<?php if (isset($success_message)) { ?>
							<div class="alert alert-success"><?php echo $success_message; ?></div>
						<?php } elseif (isset($error_message)) { ?>
							<div class="alert alert-danger"><?php echo $error_message; ?></div>
						<?php } ?>
						<form method="POST" action="">
							<div class="form-group">
								<label for="newPassword">New Password</label>
								<input type="password" class="form-control" name="newPassword" required>
							</div>
							<div class="form-group">
								<label for="confirmPassword">Confirm Password</label>
								<input type="password" class="form-control" name="confirmPassword" required>
							</div>
							<button type="submit" class="btn btn-primary" name="resetPassword">Reset Password</button>
						</form>
					</div>
				<?php } else { ?>
					<h2 class="card-title">Forgot Password</h2>
					<div class="card-text">
						<?php if (isset($success_message)) { ?>
							<div class="alert alert-success"><?php echo $success_message; ?></div>
						<?php } elseif (isset($error_message)) { ?>
							<div class="alert alert-danger"><?php echo $error_message; ?></div>
						<?php } ?>
						<form method="POST" action="">
							<div class="form-group">
								<label for="username">Email</label>
								<input type="text" class="form-control" name="username" required>
							</div>
							<button type="submit" class="btn btn-primary" name="searchId">Search</button>
						</form>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</body>

</html>