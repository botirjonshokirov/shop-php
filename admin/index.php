<?php
include("../inc/connect.inc.php");
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

<!DOCTYPE html>
<html>

<head>
	<title>Welcome to Admin Panel</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<style>
		.home-welcome {
			padding: 40px 0;
		}
	</style>
</head>

<body>
	<?php include("./components/admin-navbar.php") ?>



	<?php include("./components/category-list.php") ?>

	<div class="container">
		<div class="home-welcome">
			<div class="home-welcome-text">
				<h1>Welcome To Admin Panel</h1>
				<h2>You have all permission to do!</h2>
			</div>
		</div>
	</div>

	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>