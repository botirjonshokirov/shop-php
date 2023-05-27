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
	$uname_db = $get_user_email != null ? $get_user_email['firstName'] : null;
	$uemail_db = $get_user_email != null ? $get_user_email['email'] : null;
	$ulast_db = $get_user_email != null ? $get_user_email['lastName'] : null;

	$umob_db = $get_user_email != null ? $get_user_email['mobile'] : null;
	$uadd_db = $get_user_email != null ? $get_user_email['address'] : null;
}

if (isset($_REQUEST['uid'])) {

	$user2 = mysqli_real_escape_string($con, $_REQUEST['uid']);
	if ($user != $user2) {
		header('location: index.php');
	}
} else {
	header('location: index.php');
}

if (isset($_REQUEST['cid'])) {
	$cid = mysqli_real_escape_string($con, $_REQUEST['cid']);
	if (mysqli_query($con, "DELETE FROM orders WHERE pid='$cid' AND uid='$user'")) {
		header('location: mycart.php?uid=' . $user . '');
	} else {
		header('location: index.php');
	}
}

$search_value = "";


//order

if (isset($_POST['order'])) {
	//declere veriable
	$mbl = $_POST['mobile'];
	$addr = $_POST['address'];
	$del = $_POST['Delivery'];
	//triming name
	try {
		if (empty($_POST['mobile'])) {
			throw new Exception('Mobile can not be empty');
		}
		if (empty($_POST['address'])) {
			throw new Exception('Address can not be empty');
		}
		if (empty($_POST['Delivery'])) {
			throw new Exception('Type of Delivery can not be empty');
		}


		// Check if email already exists


		$d = date("Y-m-d"); //Year - Month - Day

		// send email
		$msg = "
					
						Your Order suc

						
						";
		//if (@mail($uemail_db,"eBuyBD Product Order",$msg, "From:eBuyBD <no-reply@ebuybd.xyz>")) {
		$result = mysqli_query($con, "SELECT * FROM cart WHERE uid='$user'");
		$t = mysqli_num_rows($result);
		if ($t <= 0) {
			throw new Exception('No product in cart. Add product first.');
		}
		while ($get_p = mysqli_fetch_assoc($result)) {
			$num = $get_p['quantity'];
			$pid = $get_p['pid'];

			mysqli_query($con, "INSERT INTO orders (uid,pid,quantity,oplace,mobile,odate,delivery) VALUES ('$user','$pid',$num,'$_POST[address]','$_POST[mobile]','$d','$del')");
		}

		if (mysqli_query($con, "DELETE FROM cart WHERE uid='$user'")) {

			//success message

			$success_message = '
						<div class="signupform_content">
						<h2><font face="bookman"></font></h2>

						<div class="signupform_text" style="font-size: 18px; text-align: center;">
						<font face="bookman">

						</font></div></div>
						';
		}
		//}

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

	<div style="margin-top: 20px; padding: 0 10%;">
		<?php include("./components/user-table.php") ?>
		<div class="holecontainer" style="float: right;width: 35%;">
			<?php include("./components/user-loginform.php") ?>
		</div>
	</div>


</body>

</html>