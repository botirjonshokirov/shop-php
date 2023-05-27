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

$pname = "";
$price = "";
$piece = "";
$available = "";
$category = "";
$type = "";
$item = "";
$pCode = "";
$descri = "";

if (isset($_POST['signup'])) {
	// Declare variables
	$pname = $_POST['pname'];
	$price = $_POST['price'];
	$piece = $_POST['piece'];
	$available = $_POST['available'];
	$type = $_POST['type'];
	$item = $_POST['item'];
	$pCode = $_POST['code'];
	$descri = $_POST['descri'];

	// Store picture code from robohash
	$picture = $_POST['picture'];

	// Store the product in the database
	$result = mysqli_query($con, "INSERT INTO products(pName, price, piece, description, available, category, type, item, pCode, picture) VALUES ('$pname', '$price', '$piece', '$descri', '$available', '$category', '$type', '$item', '$pCode', '$picture')");

	if ($result) {
		header("Location: allproducts.php");
		exit;
	} else {
		$error_message = 'Error adding the product';
	}
}

$search_value = "";

?>

<!doctype html>
<html>

<head>
	<title>Welcome to nita's online grocery</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<style>
		.container {
			margin-top: 20px;
		}

		.error-message {
			color: red;
			margin-top: 10px;
		}
	</style>
</head>

<body>
	<div class="container">
		<h2>Add Product Form</h2>
		<form action="" method="POST">
			<div class="form-group">
				<label for="pname">Product Name:</label>
				<input type="text" class="form-control" id="pname" name="pname" value="<?php echo $pname; ?>" required>
			</div>
			<div class="form-group">
				<label for="price">Price:</label>
				<input type="text" class="form-control" id="price" name="price" value="<?php echo $price; ?>" required>
			</div>
			<div class="form-group">
				<label for="piece">Piece(unit):</label>
				<input type="text" class="form-control" id="piece" name="piece" value="<?php echo $piece; ?>" required>
			</div>
			<div class="form-group">
				<label for="available">Available:</label>
				<input type="text" class="form-control" id="available" name="available" value="<?php echo $available; ?>" required>
			</div>
			<div class="form-group">
				<label for="descri">Description:</label>
				<input type="text" class="form-control" id="descri" name="descri" value="<?php echo $descri; ?>" required>
			</div>
			<div class="form-group">
				<label for="type">Type:</label>
				<input type="text" class="form-control" id="type" name="type" value="<?php echo $type; ?>" required>
			</div>
			<div class="form-group">
				<label for="item">Item:</label>
				<select class="form-control" id="item" name="item" required>
					<option value="noodles" selected>Noodles/Canned</option>
					<option value="seasoning">Condiments</option>
					<option value="drink">Drinks</option>
					<option value="soap">Soap/Detergents</option>
					<option value="sweet">Sweets</option>
					<option value="snack">Snacks</option>
					<option value="shampoo">Shampoo</option>
					<option value="hygiene">Hygiene</option>
				</select>
			</div>
			<div class="form-group">
				<label for="code">Product Code:</label>
				<input type="text" class="form-control" id="code" name="code" value="<?php echo $pCode; ?>" required>
			</div>
			<div class="form-group">
				<label for="picture">Picture Code:</label>
				<input type="text" class="form-control" id="picture" name="picture" value="<?php echo $picture; ?>" required>
			</div>
			<button type="submit" class="btn btn-primary" name="signup">Add Product</button>
			<span class="error-message"><?php echo $error_message; ?></span>
		</form>
	</div>
</body>

</html>