<?php include("../inc/connect.inc.php"); ?>
<?php

ob_start();
session_start();
if (!isset($_SESSION['admin_login'])) {
	$user = "";
	header("location: login.php?ono=" . $epid . "");
} else {
	if (isset($_REQUEST['epid'])) {

		$epid = $_REQUEST['epid'];
	} else {
		header('location: index.php');
	}
	$user = $_SESSION['admin_login'];
	$stmt = $pdo->prepare("SELECT * FROM admin WHERE id=:user");
	$stmt->execute(['user' => $user]);
	$get_user_email = $stmt->fetch(PDO::FETCH_ASSOC);
	$uname_db = $get_user_email['firstName'];
	$utype_db = $get_user_email['type'];
}
$stmt = $pdo->prepare("SELECT * FROM products WHERE id=:epid");
$stmt->execute(['epid' => $epid]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($stmt->rowCount() > 0) {
	$id = $row['id'];
	$pName = $row['pName'];
	$piece = $row['piece'];
	$price = $row['price'];
	$description = $row['description'];
	$picture = $row['picture'];
	$item = $row['item'];
	$itemu = ucwords($row['item']);
	$type = $row['type'];
	$typeu = ucwords($row['type']);
	$category = $row['category'];
	$categoryu = ucwords($row['category']);
	$code = $row['pCode'];
	$available = $row['available'];
}

//update product
if (isset($_POST['updatepro'])) {
	$pname = $_POST['pname'];
	$price = $_POST['price'];
	$piece = $_POST['piece'];
	$available = $_POST['available'];
	$category = $_POST['category'];
	$type = $_POST['type'];
	$item = $_POST['item'];
	$pCode = $_POST['code'];
	//triming name
	$_POST['pname'] = trim($_POST['pname']);

	$stmt = $pdo->prepare("UPDATE products SET pName=:pname, price=:price, description=:descri, available=:available, category=:category, type=:type, item=:item, pCode=:code WHERE id=:epid");
	$stmt->execute([
		'pname' => $_POST['pname'],
		'price' => $_POST['price'],
		'descri' => $_POST['descri'],
		'available' => $_POST['available'],
		'category' => $_POST['category'],
		'type' => $_POST['type'],
		'item' => $_POST['item'],
		'code' => $_POST['code'],
		'epid' => $epid
	]);

	header("Location: editproduct.php?epid=" . $epid . "");
	exit();
}
if (isset($_POST['updatepic'])) {

	if ($_FILES['profilepic']['name'] == "") {

		echo "not changed";
	} else {
		//finding file extension
		$profile_pic_name = $_FILES['profilepic']['name'];
		$file_basename = substr($profile_pic_name, 0, strripos($profile_pic_name, '.'));
		$file_ext = substr($profile_pic_name, strripos($profile_pic_name, '.'));

		if (((@$_FILES['profilepic']['type'] == 'image/jpeg') || (@$_FILES['profilepic']['type'] == 'image/png') || (@$_FILES['profilepic']['type'] == 'image/jpg') || (@$_FILES['profilepic']['type'] == 'image/gif')) && (@$_FILES['profilepic']['size'] < 1000000)) {

			$item = $item;
			if (!file_exists("../image/product/$item")) {
				mkdir("../image/product/$item");
			}

			$filename = strtotime(date('Y-m-d H:i:s')) . $file_ext;

			if (file_exists("../image/product/$item/" . $filename)) {
				echo @$_FILES["profilepic"]["name"] . "Already exists";
			} else {
				if (move_uploaded_file(@$_FILES["profilepic"]["tmp_name"], "../image/product/$item/" . $filename)) {
					$photos = $filename;

					$stmt = $pdo->prepare("UPDATE products SET picture=:photos WHERE id=:epid");
					$stmt->execute(['photos' => $photos, 'epid' => $epid]);

					$delete_file = unlink("../image/product/$item/" . $picture);
					header("Location: editproduct.php?epid=" . $epid . "");
					exit();
				} else {
					echo "Something went wrong during upload!";
				}
			}
		} else {
			$error_message = "Choose a picture!";
		}
	}
}

if (isset($_POST['delprod'])) {
	//triming name
	$stmt = $pdo->prepare("SELECT pid FROM orders WHERE pid=:epid");
	$stmt->execute(['epid' => $epid]);
	$getposts1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
	if ($ttl = count($getposts1)) {
		$error_message = "You cannot delete this product.<br>Someone has ordered this.";
	} else {
		$stmt = $pdo->prepare("DELETE FROM products WHERE id=:epid");
		$stmt->execute(['epid' => $epid]);
		header('location: orders.php');
		exit();
	}
}

$search_value = "";

?>

<!DOCTYPE html>
<html>

<head>
	<title>Edit Product</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>

<body>
	<?php include("./components/admin-navbar.php") ?>

	<?php include("./components/category-list.php") ?>

	<div class="container" style="padding-top: 20px;">
		<div class="row">
			<div class="col-md-6">
				<h2>Edit Product Info</h2>
				<form action="" method="POST" class="registration">
					<div class="form-group">
						<label for="pname">Product Name:</label>
						<input type="text" class="form-control" id="pname" name="pname" value="<?php echo $pName; ?>" required>
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
						<label for="available">Available Quantity:</label>
						<input type="text" class="form-control" id="available" name="available" value="<?php echo $available; ?>" required>
					</div>
					<div class="form-group">
						<label for="descri">Description:</label>
						<input type="text" class="form-control" id="descri" name="descri" value="<?php echo $description; ?>" required>
					</div>
					<div class="form-group">
						<label for="type">Type:</label>
						<select class="form-control" id="type" name="type">
							<option value="<?php echo $type; ?>" selected><?php echo $typeu; ?></option>
							<option value="clothing">Clothing</option>
							<option value="other">Other</option>
						</select>
					</div>
					<div class="form-group">
						<label for="item">Item:</label>
						<select class="form-control" id="item" name="item" required>
							<option value="<?php echo $item; ?>" selected><?php echo $itemu; ?></option>
							<option value="Bolttron">Bolttron</option>
							<option value="Nexus Prime">Nexus Prime</option>
							<option value="Sparklebot">Sparklebot</option>
							<option value="TurboX">TurboX</option>
							<option value="RoboRover">RoboRover</option>
							<option value="ElectraTech">ElectraTech</option>
							<option value="AstroByte">AstroByte</option>
							<option value="DynaBot">DynaBot</option>
						</select>
					</div>
					<div class="form-group">
						<label for="code">Product Code:</label>
						<input type="text" class="form-control" id="code" name="code" value="<?php echo $code; ?>" required>
					</div>
					<button type="submit" class="btn btn-primary" name="updatepro">Update Product</button>
					<button type="submit" class="btn btn-danger" name="delprod">Delete This Product</button>
					<div class="signup_error_msg">
						<?php
						if (isset($error_message)) {
							echo $error_message;
						}
						?>
					</div>
				</form>
				<?php
				if (isset($success_message)) {
					echo $success_message;
				}
				?>
			</div>
			<div class="col-md-6">
				<ul class="list-unstyled">
					<li>
						<div class="home-prodlist-img prodlist-img">
							<?php
							echo '<img src=https://robohash.org/' . $id . '" class="home-prodlist-imgi">';
							?>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>

</body>

</html>