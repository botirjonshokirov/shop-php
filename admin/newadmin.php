<?php include("../inc/connect.inc.php"); ?>
<?php
ob_start();
session_start();
if (!isset($_SESSION['admin_login'])) {
	header("location: login.php");
	$user = "";
} else {
	$user = $_SESSION['admin_login'];
	$stmt = $pdo->prepare("SELECT * FROM admin WHERE id=:user");
	$stmt->execute(['user' => $user]);
	$get_user_email = $stmt->fetch(PDO::FETCH_ASSOC);
	$uname_db = $get_user_email['firstName'];
	$utype_db = $get_user_email['type'];
	if ($utype_db == 'staff') {
		header("location: login.php");
	}
}
if (isset($_POST['signup'])) {
	//declere veriable
	$u_fname = $_POST['first_name'];
	$u_lname = $_POST['last_name'];
	$u_email = $_POST['email'];
	$u_mobile = $_POST['mobile'];
	$u_address = $_POST['signupaddress'];
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
		if (empty($_POST['admintype'])) {
			throw new Exception('Admin Type can not be empty');
		}
		if (empty($_POST['signupaddress'])) {
			throw new Exception('Address can not be empty');
		}

		// Check if email already exists
		$stmt = $pdo->prepare("SELECT email FROM admin WHERE email=:u_email");
		$stmt->execute(['u_email' => $u_email]);
		$email_check = $stmt->rowCount();

		if (strlen($_POST['first_name']) > 2 && strlen($_POST['first_name']) < 16) {
			if ($email_check == 0) {
				if (strlen($_POST['password']) > 4) {
					$d = date("Y-m-d"); //Year - Month - Day
					$_POST['first_name'] = ucwords($_POST['first_name']);
					$_POST['last_name'] = ucwords($_POST['last_name']);
					$_POST['password'] = md5($_POST['password']);
					$confirmCode   = substr(rand() * 900000 + 100000, 0, 6);
					// send email
					$msg = "
                    Assalamu Alaikum...

                    Your activation code: " . $confirmCode . "
                    Signup email: " . $_POST['email'] . "

                    ";
					//if (@mail($_POST['email'],"eBuyBD Activation Code",$msg, "From:eBuyBD <no-reply@ebuybd.xyz>")) {

					$stmt = $pdo->prepare("INSERT INTO admin (firstName,lastName,email,mobile,address,password,type,confirmCode) VALUES (:first_name,:last_name,:email,:mobile,:signupaddress,:password,:admintype,:confirmCode)");
					$stmt->execute([
						'first_name' => $_POST['first_name'],
						'last_name' => $_POST['last_name'],
						'email' => $_POST['email'],
						'mobile' => $_POST['mobile'],
						'signupaddress' => $_POST['signupaddress'],
						'password' => $_POST['password'],
						'admintype' => $_POST['admintype'],
						'confirmCode' => $confirmCode
					]);

					//success message
					$success_message = '
                    <div class="signupform_content"><h2><font face="bookman">Admin Registration Successfull!</font></h2>
                    <div class="signupform_text" style="font-size: 18px; text-align: center;">
                    <font face="bookman">
                        Email: ' . $u_email . '<br>
                        Account Successfully Created. <br>
                    </font></div></div>';
					//}else {
					//    throw new Exception('Email is not valid!');
					//}
				} else {
					throw new Exception('Password must be 5 or more then 5 characters!');
				}
			} else {
				throw new Exception('Email already taken!');
			}
		} else {
			throw new Exception('Firstname must be 2-15 characters!');
		}
	} catch (Exception $e) {
		$error_message = $e->getMessage();
	}
}
$search_value = "";
?>


<!doctype html>
<html>

<head>
	<title>RoboHash</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body class="home-welcome-text">
	<?php include("./components/admin-navbar.php") ?>

	<?php include("./components/category-list.php") ?>

	<?php
	if (isset($success_message)) {
		echo $success_message;
	} else {
		echo '
            <div class="container mt-4">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="text-center">New Admin Form!</h2>
                            </div>
                            <div class="card-body">
                                <form action="" method="POST" class="registration">
                                    <div class="form-group">
                                        <label for="first_name">First Name</label>
                                        <input name="first_name" id="first_name" class="form-control" type="text" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <input name="last_name" id="last_name" class="form-control" type="text" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input name="email" id="email" class="form-control" type="email" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Mobile</label>
                                        <input name="mobile" id="mobile" class="form-control" type="text" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="signupaddress">Address</label>
                                        <input name="signupaddress" id="signupaddress" class="form-control" type="text" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input name="password" id="password" class="form-control" type="password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="admintype">Admin Type</label>
                                        <select name="admintype" id="admintype" class="form-control">
                                            <option value="admin">Admin</option>
                                            <option value="staff">Staff</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input name="signup" class="btn btn-primary btn-block" type="submit" value="Add Admin!">
                                    </div>
                                </form>
                                <div class="signup_error_msg">
                                    <?php 
                                    if (isset($error_message)) {
                                        echo $error_message;
                                    }
                                    ?>
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