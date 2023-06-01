<?php
session_start();
// Include database connection file
require_once "inc/connect.inc.php";

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
	$uname_db = $get_user_email['firstName'];
	$uemail_db = $get_user_email['email'];
	$umob_db = $get_user_email['mobile'];
	$uadd_db = $get_user_email['address'];
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

$search_value = "";
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
	<div class="container" style="margin-top: 20px;">
		<div class="table-responsive">
			<table class="table">
				<thead class="thead-dark">
					<tr>
						<th>Product Name</th>
						<th>Delivery Date</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$query = "SELECT * FROM orders WHERE uid=:user ORDER BY id DESC";
					$stmt = $pdo->prepare($query);
					$stmt->bindValue(':user', $user);
					$stmt->execute();

					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$pid = $row['pid'];
						$quantity = $row['quantity'];
						$oplace = $row['oplace'];
						$mobile = $row['mobile'];
						$odate = $row['odate'];
						$ddate = $row['ddate'];
						$dstatus = $row['dstatus'];

						// Get product info
						$query1 = "SELECT * FROM products WHERE id=:pid";
						$stmt1 = $pdo->prepare($query1);
						$stmt1->bindValue(':pid', $pid);
						$stmt1->execute();
						$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
						$pId = $row1['id'];
						$pName = substr($row1['pName'], 0, 50);
						$price = $row1['price'];
						$picture = $row1['picture'];
						$item = $row1['item'];
						$category = $row1['category'];
					?>
						<tr>
							<td><?php echo $pName; ?></td>
							<td><?php echo $ddate; ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>


</body>

</html>