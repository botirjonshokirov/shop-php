<?php include("../inc/connect.inc.php"); ?>
<?php
ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
	$user = "";
} else {
	$user = $_SESSION['user_login'];
	$result = mysqli_query($con, "SELECT * FROM user WHERE id='$user'");
	$get_user_email = mysqli_fetch_assoc($result);
	$uname_db = $get_user_email['firstName'];
}
if (isset($_REQUEST['pid'])) {

	$pid = mysqli_real_escape_string($con, $_REQUEST['pid']);
} else {
	header('location: index.php');
}


$getposts = mysqli_query($con, "SELECT * FROM products WHERE id ='$pid'") or die(mysqlI_error($con));
if (mysqli_num_rows($getposts)) {
	$row = mysqli_fetch_assoc($getposts);
	$id = $row['id'];
	$pName = $row['pName'];
	$price = $row['price'];
	$piece = $row['piece'];
	$description = $row['description'];
	$picture = $row['picture'];
	$item = $row['item'];
	$available = $row['available'];
}


if (isset($_POST['addcart'])) {
	$getposts = mysqli_query($con, "SELECT * FROM cart WHERE pid ='$pid' AND uid='$user'") or die(mysqlI_error($con));
	if (mysqli_num_rows($getposts)) {
		header('location: ../mycart.php?uid=' . $user . '');
	} else {
		if (mysqli_query($con, "INSERT INTO cart (uid,pid,quantity) VALUES ('$user','$pid', 1)")) {
			header('location: ../mycart.php?uid=' . $user . '');
		} else {
			header('location: index.php');
		}
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>View-Prod</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
	<?php include("../components/navbar.php"); ?>
	<div class="container">

		<div class="row mt-4">
			<div class="col-md-6">
				<div>
					<img src="https://robohash.org/<?php echo $pid; ?>" style="height: 500px; width: 500px; padding: 2px; border: 2px solid #c7587e;">
				</div>
			</div>
			<div class="col-md-6">
				<div class="card p-4">
					<h3 class="font-weight-bold"><?php echo $pName; ?></h3>
					<hr>
					<h4>Price: <?php echo $price; ?>Php</h4>
					<hr>
					<h4>Pieces: <?php echo $piece; ?></h4>
					<h4>Description:</h4>
					<p><?php echo $description; ?></p>
					<div class="mt-4">
						<h4>Want to buy this product?</h4>
						<div>
							<form method="post" action="">
								<input type="submit" name="addcart" value="Add to cart" class="btn btn-success">
							</form>
							<br>
							<form method="post" action="../orderform.php?poid=<?php echo $pid; ?>">
								<input type="submit" value="Order Now" class="btn btn-primary">
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

</html>