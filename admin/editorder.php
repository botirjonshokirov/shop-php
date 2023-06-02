<?php
include("../inc/connect.inc.php");

ob_start();
session_start();
if (!isset($_SESSION['admin_login'])) {
	$user = "";
	header("location: login.php?ono=" . $eoid . "");
} else {
	if (isset($_REQUEST['eoid'])) {

		$eoid = $_REQUEST['eoid'];
		$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = :eoid");
		$stmt->execute(['eoid' => $eoid]);
		if ($stmt->rowCount() > 0) {
		} else {
			header('location: index.php');
		}
	} else {
		header('location: index.php');
	}
	$user = $_SESSION['admin_login'];
	$stmt = $pdo->prepare("SELECT * FROM admin WHERE id = :user");
	$stmt->execute(['user' => $user]);
	$get_user_email = $stmt->fetch();

	$uname_db = $get_user_email['firstName'];
	$type_db = $get_user_email['type'];
	$utype_db = $get_user_email['type'];


	$stmt1 = $pdo->prepare("SELECT * FROM orders WHERE id = :eoid");
	$stmt1->execute(['eoid' => $eoid]);
	$get_order_info = $stmt1->fetch();
	$eouid = $get_order_info['uid'];
	$eopid = $get_order_info['pid'];
	$eoquantity = $get_order_info['quantity'];
	$eoplace = $get_order_info['oplace'];
	$eomobile = $get_order_info['mobile'];
	$eodstatus = $get_order_info['dstatus'];
	$eodustatus = ucwords($get_order_info['dstatus']);
	$eodate = $get_order_info['odate'];
	$eddate = $get_order_info['ddate'];

	$stmt2 = $pdo->prepare("SELECT * FROM user WHERE id = :eouid");
	$stmt2->execute(['eouid' => $eouid]);
	$get_order_info2 = $stmt2->fetch();
	$euname = $get_order_info2['firstName'];
	$euemail = $get_order_info2['email'];
	$eumobile = $get_order_info2['mobile'];
}

$stmt3 = $pdo->prepare("SELECT * FROM products WHERE id = :eopid");
$stmt3->execute(['eopid' => $eopid]);
$row = $stmt3->fetch();
$id = $row['id'];
$pName = $row['pName'];
$price = $row['price'];
$piece = $row['piece'];
$description = $row['description'];
$picture = $row['picture'];
$item = $row['item'];
$category = $row['category'];
$available = $row['available'];

//order

if (isset($_POST['order'])) {
	//declere veriable
	$eodstatus = $_POST['dstatus'];
	$dquantity = $_POST['quantity'];
	$ddate = $_POST['ddate'];
	//triming name
	try {
		if (empty($_POST['dstatus'])) {
			throw new Exception('Status can not be empty');
		}
		$stmt4 = $pdo->prepare("UPDATE orders SET dstatus = :eodstatus, ddate = :ddate, quantity = :dquantity WHERE id = :eoid");
		$stmt4->execute(['eodstatus' => $eodstatus, 'ddate' => $ddate, 'dquantity' => $dquantity, 'eoid' => $eoid]);

		header('location: editorder.php?eoid=' . $eoid . '');
		$success_message = '
			<div class="signupform_content"><h2><font face="bookman">Change successful!</font></h2>
			</div>';
	} catch (Exception $e) {
		$error_message = $e->getMessage();
	}
}
if (isset($_POST['delorder'])) {
	//triming name
	$stmt5 = $pdo->prepare("DELETE FROM orders WHERE id = :eoid");
	$stmt5->execute(['eoid' => $eoid]);

	header('location: orders.php');
}

$search_value = "";
?>

<!DOCTYPE html>
<html>

<head>
	<title>SAREE</title>
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
				<h2 style="padding-bottom: 20px;">Change Delivery Status</h2>
				<form action="" method="POST" class="registration">
					<div class="form-group">
						<label for="ddate">Delivery Date</label>
						<input name="ddate" id="ddate" placeholder="Delivery date" required="required" class="form-control" type="date" value="<?php echo $eddate; ?>">
					</div>
					<div class="form-group">
						<label for="dstatus">Delivery Status</label>
						<select name="dstatus" id="dstatus" required="required" class="form-control">
							<option selected value="<?php echo $eodstatus; ?>"><?php echo $eodustatus; ?></option>
							<option value="No">No</option>
							<option value="Yes">Yes</option>
							<option value="Cancel">Cancel</option>
						</select>
					</div>
					<div class="form-group">
						<label for="quantity">Quantity</label>
						<select name="quantity" id="quantity" required="required" class="form-control">
							<option selected value="<?php echo $eoquantity; ?>">Quantity: <?php echo $eoquantity; ?></option>
							<?php for ($i = 1; $i <= $available; $i++) { ?>
								<option value="<?php echo $i; ?>">Quantity: <?php echo $i; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<input name="order" class="btn btn-primary" type="submit" value="Confirm Change">
						<input name="delorder" class="btn btn-danger" type="submit" value="Delete Order">
					</div>
					<div class="signup_error_msg">
						<?php if (isset($error_message)) {
							echo $error_message;
						} ?>
					</div>
				</form>
				<?php if (isset($success_message)) {
					echo $success_message;
				} ?>
			</div>
			<div class="col-md-6">
				<ul class="list-unstyled">
					<li>
						<div class="home-prodlist-img">
							<img src="https://robohash.org/<?php echo $id; ?>" class="home-prodlist-imgi">
							<div class="text-center"><?php echo $pName; ?></div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
</body>

</html>