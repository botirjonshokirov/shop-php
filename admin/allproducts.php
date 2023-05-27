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

$search_value = "";

?>


<!doctype html>
<html>

<head>
	<title>Welcome to ebuybd online shop</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>

<body class="home-welcome-text">
	<?php include("./components/admin-navbar.php") ?>

	<?php include("./components/category-list.php") ?>

	<div class="table-responsive">
		<table class="table">
			<thead class="thead-dark">
				<tr>
					<th scope="col">Id</th>
					<th scope="col">P Name</th>
					<th scope="col">Description</th>
					<th scope="col">Price</th>
					<th scope="col">Piece</th>
					<th scope="col">Available</th>
					<th scope="col">Category</th>
					<th scope="col">Type</th>
					<th scope="col">Item</th>
					<th scope="col">P Code</th>
					<th scope="col">Edit</th>
				</tr>
			</thead>
			<tbody>
				<?php
				include("../inc/connect.inc.php");
				$query = "SELECT * FROM products ORDER BY id DESC";
				$run = mysqli_query($con, $query);
				while ($row = mysqli_fetch_assoc($run)) {
					$id = $row['id'];
					$pName = substr($row['pName'], 0, 50);
					$descri = $row['description'];
					$price = $row['price'];
					$piece = $row['piece'];
					$available = $row['available'];
					$category = $row['category'];
					$type = $row['type'];
					$item = $row['item'];
					$pCode = $row['pCode'];
					$picture = $row['picture'];
				?>
					<tr>
						<th scope="row"><?php echo $id; ?></th>
						<td><?php echo $pName; ?></td>
						<td><?php echo $descri; ?></td>
						<td><?php echo $price; ?></td>
						<td><?php echo $piece; ?></td>
						<td><?php echo $available; ?></td>
						<td><?php echo $category; ?></td>
						<td><?php echo $type; ?></td>
						<td><?php echo $item; ?></td>
						<td><?php echo $pCode; ?></td>
						<td>
							<div class="home-prodlist-img">
								<a href="editproduct.php?epid=<?php echo $id; ?>">
									<img src="https://robohash.org/' . $id . '" class="home-prodlist-imgi" style="height: 75px; width: 75px;">
								</a>
							</div>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>

</body>

</html>