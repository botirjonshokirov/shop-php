<?php
include("../inc/connect.inc.php");
ob_start();
session_start();
if (!isset($_SESSION['admin_login'])) {
	header("location: login.php");
	$user = "";
} else {
	$user = $_SESSION['admin_login'];
	$stmt = $pdo->prepare("SELECT * FROM admin WHERE id = :user");
	$stmt->execute(['user' => $user]);
	$get_user_email = $stmt->fetch();

	$uname_db = $get_user_email['firstName'];
	$utype_db = $get_user_email['type'];
}

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

	<div class="container">
		<table class="table table-striped">
			<thead class="thead-dark">
				<tr>
					<th>Product Name</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Payment</th>
					<th>Date of Delivery</th>
					<th>Type of Delivery</th>
					<th>Delivery Address</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$stmt = $pdo->query("SELECT * FROM orders WHERE dstatus='Yes' ORDER BY id DESC");
				while ($row = $stmt->fetch()) {
					$oid = $row['id'];
					$ouid = $row['uid'];
					$opid = $row['pid'];
					$deliv = $row['delivery'];

					// Getting product info
					$stmt3 = $pdo->prepare("SELECT * FROM products WHERE id = :opid");
					$stmt3->execute(['opid' => $opid]);
					$row3 = $stmt3->fetch();
					$pname = $row3['pName'];

					$oquantity = $row['quantity'];
					$oplace = $row['oplace'];
					$omobile = $row['mobile'];
					$odstatus = $row['dstatus'];
					$odate = $row['odate'];
					$ddate = $row['ddate'];

					// Getting user info
					$stmt1 = $pdo->prepare("SELECT * FROM user WHERE id = :ouid");
					$stmt1->execute(['ouid' => $ouid]);
					$row1 = $stmt1->fetch();
					$ofname = $row1['firstName'];
					$olname = $row1['lastName'];
					$oumobile = $row1['mobile'];
					$ouemail = $row1['email'];
				?>
					<tr>
						<td><?php echo $pname; ?></td>
						<td><?php echo $ofname; ?></td>
						<td><?php echo $olname; ?></td>
						<td><?php echo '' . $oquantity . ' * ' . $oprice . ' = ' . $oquantity * $oprice . ''; ?></td>
						<td><?php echo $ddate; ?></td>
						<td><?php echo $deliv; ?></td>
						<td><?php echo $oplace; ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>

</body>

</html>