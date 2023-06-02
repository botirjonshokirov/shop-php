<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("./inc/connect.inc.php");
ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
	header("location: login.php");
} else {
	$user = $_SESSION['user_login'];
	include("inc/connect.inc.php");
	$stmt = $pdo->prepare("SELECT * FROM user WHERE id = ?");
	$stmt->execute([$user]);
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
	<link rel="stylesheet" type="text/css" href="./style.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
	<?php include("./components/min-navbar.php") ?>
	<?php include("./components/user-categorylist.php") ?>
	<div style="margin-top: 20px;">
		<div class="container">
			<ul class="list-group">
				<li class="list-group-item">
					<div>
						<div>
							<table class="table">
								<thead class="thead-dark">
									<tr>
										<th>Product Name</th>
										<th>Price</th>
										<th>Total Product</th>
										<th>Order Date</th>
										<th>Delivery Date</th>
										<th>Delivery Place</th>
										<th>Delivery Status</th>
										<th>View</th>
									</tr>
								</thead>
								<tbody>
									<?php
									include("inc/connect.inc.php");
									$stmt = $pdo->prepare("SELECT * FROM orders WHERE uid = ? ORDER BY id DESC");
									$stmt->execute([$user]);
									$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
									foreach ($rows as $row) {
										$pid = $row['pid'];
										$quantity = $row['quantity'];
										$oplace = $row['oplace'];
										$mobile = $row['mobile'];
										$odate = $row['odate'];
										$ddate = $row['ddate'];
										$dstatus = $row['dstatus'];

										// Get product info
										$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
										$stmt->execute([$pid]);
										$row1 = $stmt->fetch(PDO::FETCH_ASSOC);
										$pId = $row1['id'];
										$pName = substr($row1['pName'], 0, 50);
										$price = $row1['price'];
										$item = $row1['item'];
										$category = $row1['category'];
									?>
										<tr>
											<td><?php echo $pName; ?></td>
											<td><?php echo $price; ?></td>
											<td><?php echo $quantity; ?></td>
											<td><?php echo $odate; ?></td>
											<td><?php echo $ddate; ?></td>
											<td><?php echo $oplace; ?></td>
											<td><?php echo $dstatus; ?></td>
											<td>
												<div class="home-prodlist-img">
													<a href="OurProducts/view_product.php?pid=<?php echo $pId; ?>">
														<img src="https://robohash.org/<?php echo $id; ?>" class="home-prodlist-imgi" style="height: 75px; width: 75px;">
													</a>
												</div>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</div>
</body>

</html>