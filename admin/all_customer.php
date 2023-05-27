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
}

?>


<!doctype html>
<html>

<head>
	<title>RoboHash</title>
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
								<th>Id</th>
								<th>First Name</th>
								<th>Last Name</th>
								<th>Email</th>
								<th>Mobile</th>
								<th>Address</th>
								<th>Activation</th>
							</tr>
						</thead>
						<tbody>
							<?php include("../inc/connect.inc.php");
							$query = "SELECT * FROM user ORDER BY id DESC";
							$run = mysqli_query($con, $query);
							while ($row = mysqli_fetch_assoc($run)) {
								$id = $row['id'];
								$fname = $row['firstName'];
								$lname = $row['lastName'];
								$email = $row['email'];
								$mobile = $row['mobile'];
								$address = $row['address'];
								$active = $row['activation'];
							?>
								<tr>
									<td><?php echo $id; ?></td>
									<td><?php echo $fname; ?></td>
									<td><?php echo $lname; ?></td>
									<td><?php echo $email; ?></td>
									<td><?php echo $mobile; ?></td>
									<td><?php echo $address; ?></td>
									<td><?php echo $active; ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

</body>

</html>