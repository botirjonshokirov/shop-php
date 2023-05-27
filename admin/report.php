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
	<title>RoboHash</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

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

<body>

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

			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-striped">
						<thead class="thead-dark">
							<tr>
								<th>Id</th>
								<th>Product Name</th>
								<th>Description</th>
								<th>Price</th>
								<th>Available</th>
								<th>Category</th>
								<th>Type</th>
								<th>Item</th>
								<th>Product Code</th>
								<th>Edit</th>
							</tr>
						</thead>
						<tbody>
							<?php include("../inc/connect.inc.php");
							$query = "SELECT * FROM products ORDER BY id DESC";
							$run = mysqli_query($con, $query);
							while ($row = mysqli_fetch_assoc($run)) {
								$id = $row['id'];
								$pName = substr($row['pName'], 0, 50);
								$descri = $row['description'];
								$price = $row['price'];
								$available = $row['available'];
								$category = $row['category'];
								$type = $row['type'];
								$item = $row['item'];
								$pCode = $row['pCode'];
								$picture = $row['picture'];
							?>
								<tr>
									<td><?php echo $id; ?></td>
									<td><?php echo $pName; ?></td>
									<td><?php echo $descri; ?></td>
									<td><?php echo $price; ?></td>
									<td><?php echo $available; ?></td>
									<td><?php echo $category; ?></td>
									<td><?php echo $type; ?></td>
									<td><?php echo $item; ?></td>
									<td><?php echo $pCode; ?></td>
									<td><?php echo '<div class="home-prodlist-img"><a href="editproduct.php?epid=' . $id . '">
                                  <img src="https://robohash.org/' . $id . '" class="home-prodlist-imgi" style="height: 75px; width: 75px;">
                                  </a>
                                </div>' ?></td>
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