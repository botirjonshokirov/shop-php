<?php
ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
	$user = "";
} else {
	$user = $_SESSION['user_login'];
	$stmt = $pdo->prepare("SELECT * FROM user WHERE id=:user");
	$stmt->bindParam(':user', $user);
	$stmt->execute();
	$get_user_email = $stmt->fetch(PDO::FETCH_ASSOC);
	$uname_db = $get_user_email['firstName'];
}
if (isset($_REQUEST['pid'])) {
	$pid = $_REQUEST['pid'];
} else {
	header('location: index.php');
}

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = :pid");
$stmt->bindParam(':pid', $pid);
$stmt->execute();
$getposts = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (count($getposts) > 0) {
	$row = $getposts[0];
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
	$stmt = $pdo->prepare("SELECT * FROM cart WHERE pid = :pid AND uid = :user");
	$stmt->bindParam(':pid', $pid);
	$stmt->bindParam(':user', $user);
	$stmt->execute();
	$getposts = $stmt->fetchAll(PDO::FETCH_ASSOC);
	if (count($getposts) > 0) {
		header('location: ../mycart.php?uid=' . $user . '');
	} else {
		$stmt = $pdo->prepare("INSERT INTO cart (uid, pid, quantity) VALUES (:user, :pid, 1)");
		$stmt->bindParam(':user', $user);
		$stmt->bindParam(':pid', $pid);
		if ($stmt->execute()) {
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