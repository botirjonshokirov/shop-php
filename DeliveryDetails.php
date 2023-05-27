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

if (isset($_REQUEST['cid'])) {
	$cid = mysqli_real_escape_string($con, $_REQUEST['cid']);
	if (mysqli_query($con, "DELETE FROM orders WHERE pid='$cid' AND uid='$user'")) {
		header('location: mycart.php?uid=' . $user . '');
	} else {
		header('location: index.php');
	}
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
		<div class="card" style="width: 900px; margin: 0 auto;">
			<div class="card-body">
				<h4 class="card-title">Product List</h4>
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr style="font-weight: bold;" bgcolor="#3A5487">
								<th>Product Name</th>
								<th>Price</th>
								<th>Quantity</th>
								<th>Description</th>
								<th>Image</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							include("inc/connect.inc.php");
							$query = "SELECT * FROM cart WHERE uid='$user' ORDER BY id DESC";
							$run = mysqli_query($con, $query);
							while ($row = mysqli_fetch_assoc($run)) {
								$pid = $row['pid'];
								$quantity = $row['quantity'];

								// Get product info
								$query1 = "SELECT * FROM products WHERE id='$pid'";
								$run1 = mysqli_query($con, $query1);
								$row1 = mysqli_fetch_assoc($run1);
								$pId = $row1['id'];
								$pName = substr($row1['pName'], 0, 50);
								$price = $row1['price'];
								$description = $row1['description'];
								$picture = $row1['picture'];
								$item = $row1['item'];
								$category = $row1['category'];
							?>
								<tr>
									<td><?php echo $pName; ?></td>
									<td><?php echo $price; ?></td>
									<td><?php echo $quantity; ?></td>
									<td><?php echo $description; ?></td>
									<td>
										<div class="home-prodlist-img">
											<a href="<?php echo $category . '/view_product.php?pid=' . $pId; ?>">
												<img src="image/product/<?php echo $item . '/' . $picture; ?>" class="home-prodlist-imgi" style="height: 75px; width: 75px;">
											</a>
										</div>
									</td>
									<td>
										<div class="home-prodlist-img">
											<a href="delete_cart.php?cid=<?php echo $pId; ?>" style="text-decoration: none;">X</a>
										</div>
									</td>
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