<?php
require_once "inc/connect.inc.php";

ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
	header("location: login.php");
	exit;
} else {
	$user = $_SESSION['user_login'];
	$query = "SELECT * FROM user WHERE id=:user";
	$stmt = $pdo->prepare($query);
	$stmt->bindValue(':user', $user);
	$stmt->execute();
	$get_user_email = $stmt->fetch(PDO::FETCH_ASSOC);
	$uname_db = $get_user_email != null ? $get_user_email['firstName'] : null;
	$uemail_db = $get_user_email != null ? $get_user_email['email'] : null;
	$ulast_db = $get_user_email != null ? $get_user_email['lastName'] : null;
	$umob_db = $get_user_email != null ? $get_user_email['mobile'] : null;
	$uadd_db = $get_user_email != null ? $get_user_email['address'] : null;
}

if (isset($_REQUEST['uid'])) {
	$user2 = $_REQUEST['uid'];
	if ($user != $user2) {
		header('location: index.php');
		exit;
	}
} else {
	header('location: index.php');
	exit;
}

if (isset($_REQUEST['cid'])) {
	$cid = $_REQUEST['cid'];
	$query = "DELETE FROM orders WHERE pid=:cid AND uid=:user";
	$stmt = $pdo->prepare($query);
	$stmt->bindValue(':cid', $cid);
	$stmt->bindValue(':user', $user);
	if ($stmt->execute()) {
		header('location: mycart.php?uid=' . $user . '');
	} else {
		header('location: index.php');
	}
}

$search_value = "";

// Order
if (isset($_POST['order'])) {
	// Declare variables
	$mbl = $_POST['mobile'];
	$addr = $_POST['address'];
	$del = $_POST['Delivery'];

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

		$d = date("Y-m-d"); // Year - Month - Day

		$result = $pdo->query("SELECT * FROM cart WHERE uid='$user'");
		$t = $result->rowCount();
		if ($t <= 0) {
			throw new Exception('No product in cart. Add product first.');
		}

		$success_message = '';

		while ($get_p = $result->fetch(PDO::FETCH_ASSOC)) {
			$num = $get_p['quantity'];
			$pid = $get_p['pid'];

			$query = "INSERT INTO orders (uid, pid, quantity, oplace, mobile, odate, delivery) VALUES (:user, :pid, :num, :address, :mobile, :odate, :del)";
			$stmt = $pdo->prepare($query);
			$stmt->bindValue(':user', $user);
			$stmt->bindValue(':pid', $pid);
			$stmt->bindValue(':num', $num);
			$stmt->bindValue(':address', $_POST['address']);
			$stmt->bindValue(':mobile', $_POST['mobile']);
			$stmt->bindValue(':odate', $d);
			$stmt->bindValue(':del', $_POST['Delivery']);

			if ($stmt->execute()) {
				$success_message = '
					<div class="signupform_content">
						<h2><font face="bookman"></font></h2>
						<div class="signupform_text" style="font-size: 18px; text-align: center;">
							<font face="bookman">
								Your Order successful.
							</font>
						</div>
					</div>';
			}
		}

		$query = "DELETE FROM cart WHERE uid=:user";
		$stmt = $pdo->prepare($query);
		$stmt->bindValue(':user', $user);
		$stmt->execute();
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