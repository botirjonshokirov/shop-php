<?php include("../inc/connect.inc.php"); ?>
<?php
ob_start();
session_start();
if (!isset($_SESSION['admin_login'])) {
	header("location: login.php");
	$user = "";
} else {
	$user = $_SESSION['admin_login'];
	$result = mysqli_query($con, "SELECT * FROM admin WHERE id='$user'");
	$get_user_email = mysqli_fetch_assoc($result);
	$uname_db = $get_user_email['firstName'];
	$utype_db = $get_user_email['type'];
	if ($utype_db == 'staff') {
		header("location: login.php");
	}
}

?>


<!doctype html>
<html>

<head>
	<title>Welcome to ebuybd online shop</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css">

	<style>
		.table-container {
			max-height: 400px;
			overflow-y: auto;
			margin-bottom: 20px;
		}

		.settingsleftcontent {
			background-color: #f8f9fa;
			padding: 10px;
			border-radius: 5px;
		}

		.settingsleftcontent ul {
			list-style-type: none;
			margin: 0;
			padding: 0;
		}

		.settingsleftcontent li {
			padding: 5px;
		}

		.settingsleftcontent a {
			display: block;
			text-decoration: none;
			color: #ffffff;
			background-color: #007bff;
			padding: 10px;
			border-radius: 5px;
		}

		.settingsleftcontent a:hover {
			background-color: #0056b3;
		}
	</style>
</head>

<body class="home-welcome-text">

	<?php include("./components/admin-navbar.php") ?>

	<?php include("./components/category-list.php") ?>
	<div class="container mt-4">
		<div class="row">
			<div class="col-md-5">
				<div class="settingsleftcontent">
					<ul class="list-unstyled d-flex justify-content-between">
						<li><?php echo '<a href="report.php" class="btn btn-primary">List Of Products</a>'; ?></li>
						<li><?php echo '<a href="all_customer.php" class="btn btn-primary">All Customers</a>'; ?></li>
						<li><?php echo '<a href="sales_report.php" class="btn btn-primary">Sales Reports</a>'; ?></li>
					</ul>
				</div>
			</div>

			<div class="col-md-10">
				<div class="table-responsive">
					<table class="table table-striped">
						<thead class="thead-dark">
							<tr>
								<th>Customer Id</th>
								<th>Customer Name</th>
								<th>Payment</th>
							</tr>
						</thead>
						<tbody>
							<?php include("../inc/connect.inc.php");
							$total = 0;
							$query = "SELECT * FROM orders WHERE dstatus='yes' ORDER BY id DESC";
							$run = mysqli_query($con, $query);
							while ($row = mysqli_fetch_assoc($run)) {
								$uid = $row['uid'];
								$productId = $row['pid'];
								$quantity = $row['quantity'];
								$query1 = "SELECT * FROM user WHERE id='$uid'";
								$run1 = mysqli_query($con, $query1);
								$row1 = mysqli_fetch_assoc($run1);
								$firstName = $row1['firstName'];

								$query2 = "SELECT * FROM products WHERE id='$productId'";
								$run2 = mysqli_query($con, $query2);
								$row2 = mysqli_fetch_assoc($run2);
								$pPrice = $row2['price'];
								$payment = $pPrice * $quantity;
								$total += $payment;
							?>
								<tr>
									<td><?php echo $uid; ?></td>
									<td><?php echo $firstName; ?></td>
									<td><?php echo $payment; ?> Php</td>
								</tr>
							<?php } ?>
							<tr class="font-weight-bold" colspan="3" bgcolor="#4DB849">
								<th>Total Sales</th>
								<th></th>
								<th><?php echo $total; ?> Php</th>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

</body>

</html>