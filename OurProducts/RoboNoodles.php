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
?>

<!DOCTYPE html>
<html>

<head>
	<title>Noodles & Canned</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
	<?php include("../inc/mainheader.inc.php"); ?>
	<?php include("../components/categolis.php"); ?>
	<div class="container" style="padding: 15px 0px; font-size: 15px;">
		<div class="row">
			<?php
			$getposts = mysqli_query($con, "SELECT * FROM products WHERE available >= '1' AND item = 'noodles' ORDER BY id DESC LIMIT 10") or die(mysqli_error($con));
			if (mysqli_num_rows($getposts)) {
				while ($row = mysqli_fetch_assoc($getposts)) {
					$id = $row['id'];
					$pName = $row['pName'];
					$price = $row['price'];
					$description = $row['description'];
					$picture = $row['picture'];

					echo '
					<div class="col-md-3">
						<div class="card mb-3">
							<img src="../image/product/noodles/' . $picture . '" class="card-img-top" alt="' . $pName . '">
							<div class="card-body">
								<h5 class="card-title">' . $pName . '</h5>
								<p class="card-text">Price: ' . $price . ' Php</p>
								<a href="view_product.php?pid=' . $id . '" class="btn btn-primary">View Details</a>
							</div>
						</div>
					</div>
					';
				}
			} else {
				echo '<div class="col-md-12"><p>No products found.</p></div>';
			}
			?>
		</div>
	</div>

	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>