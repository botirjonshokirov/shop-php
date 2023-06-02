<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../inc/connect.inc.php");
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
?>

<!DOCTYPE html>
<html>

<head>
	<title>TurboX</title>
	<link rel="stylesheet" type="text/css" href="./style.css">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
	<?php include("../components/navbar.php"); ?>


	<div class="container">
		<div class="row">
			<?php
			$stmt = $pdo->prepare("SELECT * FROM products WHERE available >= '1' AND item = 'TurboX' ORDER BY id DESC LIMIT 10");
			$stmt->execute();
			$getposts = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($getposts) > 0) {
				foreach ($getposts as $row) {
					$id = $row['id'];
					$pName = $row['pName'];
					$price = $row['price'];
					$description = $row['description'];


					// Generating the RoboHash image URL
					$imageUrl = "https://robohash.org/" . $id;

					echo '
						<div class="col-md-4">
							<div class="card card-container">
								<img src="' . $imageUrl . '" class="card-img-top">
								<div class="card-body">
									<h5 class="card-title">' . $pName . '</h5>
									<p class="card-text">Description: ' . $description . '</p>
									<p class="card-text">Price: ' . $price . '</p>
									<a href="view_product.php?pid=' . $id . '" class="btn btn-primary">View</a>
								</div>
							</div>
						</div>
					';
				}
			}
			?>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>