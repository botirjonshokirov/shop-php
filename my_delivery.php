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
					<?php include("inc/connect.inc.php");
					$query = "SELECT * FROM orders WHERE uid='$user' ORDER BY id DESC";
					$run = mysqli_query($con, $query);
					while ($row = mysqli_fetch_assoc($run)) {
						$pid = $row['pid'];
						$quantity = $row['quantity'];
						$oplace = $row['oplace'];
						$mobile = $row['mobile'];
						$odate = $row['odate'];
						$ddate = $row['ddate'];
						$dstatus = $row['dstatus'];

						//get product info
						$query1 = "SELECT * FROM products WHERE id='$pid'";
						$run1 = mysqli_query($con, $query1);
						$row1 = mysqli_fetch_assoc($run1);
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