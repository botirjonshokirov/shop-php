<?php
include("../inc/connect.inc.php");
session_start();

if (!isset($_SESSION['admin_login'])) {
	header("location: login.php");
	$user = "";
} else {
	$user = $_SESSION['admin_login'];
	$stmt = $con->prepare("SELECT * FROM admin WHERE id = :user");
	$stmt->bindParam(':user', $user);
	$stmt->execute();
	$get_user_email = $stmt->fetch(PDO::FETCH_ASSOC);
	$uname_db = $get_user_email['firstName'];
	$utype_db = $get_user_email['type'];
	$ulast_name = $get_user_email['lastName'];
	$email = $get_user_email['email'];
	$mobile = $get_user_email['mobile'];
	$address = $get_user_email['address'];
}

if (isset($_POST['signup'])) {
	$u_fname = $_POST['first_name'];
	$u_lname = $_POST['last_name'];
	$u_email = $_POST['email'];
	$u_mobile = $_POST['mobile'];
	$u_address = $_POST['signupaddress'];

	try {
		if (empty($_POST['first_name'])) {
			throw new Exception('Fullname cannot be empty');
		}
		if (is_numeric($_POST['first_name'][0])) {
			throw new Exception('Please write your correct name!');
		}
		if (empty($_POST['last_name'])) {
			throw new Exception('Lastname cannot be empty');
		}
		if (is_numeric($_POST['last_name'][0])) {
			throw new Exception('Lastname first character must be a letter!');
		}
		if (empty($_POST['email'])) {
			throw new Exception('Email cannot be empty');
		}
		if (empty($_POST['mobile'])) {
			throw new Exception('Mobile cannot be empty');
		}
		if (empty($_POST['password'])) {
			throw new Exception('Password cannot be empty');
		}
		if ($utype_db == 'admin') {
			if (empty($_POST['admintype'])) {
				throw new Exception('Admin Type cannot be empty');
			}
		}
		if (empty($_POST['signupaddress'])) {
			throw new Exception('Address cannot be empty');
		}

		$stmt = $con->prepare("SELECT email FROM admin WHERE email = :u_email");
		$stmt->bindParam(':u_email', $u_email);
		$stmt->execute();
		$email_check = $stmt->rowCount();

		if (strlen($_POST['first_name']) > 2 && strlen($_POST['first_name']) < 16) {
			if ($email_check == 0) {
				if (strlen($_POST['password']) > 4) {
					$d = date("Y-m-d");
					$_POST['first_name'] = ucwords($_POST['first_name']);
					$_POST['last_name'] = ucwords($_POST['last_name']);
					$_POST['password'] = md5($_POST['password']);
					$confirmCode = substr(rand() * 900000 + 100000, 0, 6);

					if ($utype_db == 'admin') {
						$stmt = $con->prepare("UPDATE admin SET firstName=:first_name, lastName=:last_name, email=:u_email, mobile=:u_mobile, address=:u_address, password=:u_password, type=:u_admin_type WHERE id=:user");
						$stmt->bindParam(':first_name', $_POST['first_name']);
						$stmt->bindParam(':last_name', $_POST['last_name']);
						$stmt->bindParam(':u_email', $u_email);
						$stmt->bindParam(':u_mobile', $u_mobile);
						$stmt->bindParam(':u_address', $u_address);
						$stmt->bindParam(':u_password', $_POST['password']);
						$stmt->bindParam(':u_admin_type', $_POST['admintype']);
						$stmt->bindParam(':user', $user);
						$stmt->execute();
					} else {
						$stmt = $con->prepare("UPDATE admin SET firstName=:first_name, lastName=:last_name, email=:u_email, mobile=:u_mobile, address=:u_address, password=:u_password WHERE id=:user");
						$stmt->bindParam(':first_name', $_POST['first_name']);
						$stmt->bindParam(':last_name', $_POST['last_name']);
						$stmt->bindParam(':u_email', $u_email);
						$stmt->bindParam(':u_mobile', $u_mobile);
						$stmt->bindParam(':u_address', $u_address);
						$stmt->bindParam(':u_password', $_POST['password']);
						$stmt->bindParam(':user', $user);
						$stmt->execute();
					}

					echo '<script>alert("Your profile has been updated successfully!")</script>';
					echo '<script>window.location.href = "edit_profile.php";</script>';
				} else {
					throw new Exception('Password must be at least 5 characters long');
				}
			} else {
				throw new Exception('Email already exists');
			}
		} else {
			throw new Exception('Firstname must be between 3 and 15 characters long');
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
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

	<?php include("./components/admin-navbar.php") ?>

	<?php include("./components/category-list.php") ?>

	<?php
	if (isset($success_message)) {
		echo $success_message;
	} else {
		echo '
					<div class="holecontainer" style="float: right; margin-right: 36%; padding-top: 20px;">
						<div class="container">
							<div>
								<div>
									<div class="signupform_content">
										<h2>Update Admin</h2>
										<div class="signupform_text"></div>
										<div>
											<form action="" method="POST" class="registration">
												<div class="signup_form">
													<div>
														<td >
															<input name="first_name" id="first_name" placeholder="First Name" required="required" class="first_name signupbox" type="text" size="30" value="' . $uname_db . '" >
														</td>
													</div>
													<div>
														<td >
															<input name="last_name" id="last_name" placeholder="Last Name" required="required" class="last_name signupbox" type="text" size="30" value="' . $ulast_name . '" >
														</td>
													</div>
													<div>
														<td>
															<input name="email" placeholder="Enter Your Email" required="required" class="email signupbox" type="email" size="30" value="' . $email . '">
													</td>
														</div>
													<div>
														<td>
															<input name="mobile" placeholder="Enter Your Mobile" required="required" class="email signupbox" type="text" size="30" value="' . $mobile . '">
														</td>
													</div>
													<div>
														<td>
															<input name="signupaddress" placeholder="Write Your Full Address" required="required" class="email signupbox" type="text" size="30" value="' . $address . '">
														</td>
													</div>
													<div>
														<td>
															<input name="password" id="password-1" required="required"  placeholder="Enter New Password" class="password signupbox " type="password" size="30" value="">
														</td>
													</div>';
		if ($utype_db == 'admin') {
			echo '<div>
														<td>
															<select name="admintype" required="required" style=" font-size: 20px;
														font-style: italic;margin-bottom: 3px;margin-top: 0px;padding: 14px;line-height: 25px;border-radius: 4px;border: 1px solid #169E8F;color: #169E8F;margin-left: 0;width: 300px;background-color: transparent;" class="">
																<option selected value="admin">Admin</option>
																<option value="staff">Staff</option>
																
															</select>
														</td>
													</div>';
		}

		echo ' <div>
														<input name="signup" class="uisignupbutton signupbutton" type="submit" value="Update Admin">
													</div>
													<div class="signup_error_msg">
														<?php 
															if (isset($error_message)) {echo $error_message;}
															
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
				';
	}
	?>
</body>

</html>