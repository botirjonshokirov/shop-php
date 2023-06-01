<?php include("inc/connect.inc.php"); ?>
<?php

if (isset($_REQUEST['poid'])) {
	$poid = $_REQUEST['poid'];
} else {
	header('location: index.php');
	exit();
}

session_start();

if (!isset($_SESSION['user_login'])) {
	header("location: login.php?ono=" . $poid . "");
	exit();
}

$user = $_SESSION['user_login'];

$stmt = $pdo->prepare("SELECT * FROM user WHERE id=:user");
$stmt->bindValue(':user', $user);
$stmt->execute();
$get_user_email = $stmt->fetch(PDO::FETCH_ASSOC);

$uname_db = $get_user_email['firstName'];
$ulast_db = $get_user_email['lastName'];
$uemail_db = $get_user_email['email'];
$umob_db = $get_user_email['mobile'];
$uadd_db = $get_user_email['address'];

$stmt = $pdo->prepare("SELECT * FROM products WHERE id=:poid");
$stmt->bindValue(':poid', $poid);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$id = $row['id'];
$pName = $row['pName'];
$price = $row['price'];
$description = $row['description'];
$picture = $row['picture'];
$item = $row['item'];
$category = $row['category'];
$available = $row['available'];

if (isset($_POST['order'])) {
	$mbl = $_POST['mobile'];
	$addr = $_POST['address'];
	$quan = $_POST['Quantity'];
	$del = $_POST['Delivery'];

	try {
		if (empty($_POST['mobile'])) {
			throw new Exception('Mobile cannot be empty');
		}
		if (empty($_POST['address'])) {
			throw new Exception('Address cannot be empty');
		}
		if (empty($_POST['Quantity'])) {
			throw new Exception('Quantity cannot be empty');
		}
		if (empty($_POST['Delivery'])) {
			throw new Exception('Type of Delivery cannot be empty');
		}

		$d = date("Y-m-d");

		$msg = "
            Your Order successful.
        ";

		$stmt = $pdo->prepare("INSERT INTO orders (uid, pid, quantity, oplace, mobile, odate, delivery) VALUES (:user, :poid, :quan, :address, :mobile, :odate, :delivery)");
		$stmt->bindValue(':user', $user);
		$stmt->bindValue(':poid', $poid);
		$stmt->bindValue(':quan', $quan);
		$stmt->bindValue(':address', $_POST['address']);
		$stmt->bindValue(':mobile', $_POST['mobile']);
		$stmt->bindValue(':odate', $d);
		$stmt->bindValue(':delivery', $del);

		if ($stmt->execute()) {
			$success_message = '
                <div class="signupform_content">
                    <h2><font face="bookman"></font></h2>
                    <script>
                        alert("We will call you for confirmation very soon");
                    </script>
                    <div class="signupform_text" style="font-size: 18px; text-align: center;">
                        <font face="bookman"></font>
                    </div>
                </div>';
		}
	} catch (Exception $e) {
		$error_message = $e->getMessage();
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Noodles & Canned</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
	<div class="container-fluid">
		<?php include("./components/navbar.php") ?>
		<div class="row">
			<div class="col-lg-2">

			</div>
			<div class="col-lg-10">
				<div class="holecontainer" style="padding: 20px;">
					<div class="container signupform_content">
						<div>
							<div style="float: right;">
								<?php
								if (isset($success_message)) {
									echo $success_message;
									echo '<h3 style="color:#169E8F;font-size:45px;">Payment & Delivery</h3>';

									echo '<h3 style="color:black;font-size:25px;">First Name:</h3>';
									echo '<span style="color:#34ce6c;font-size:25px;">' . $uname_db . '</span>';
									echo '<h3 style="color:black;font-size:25px;">Last Name:</h3>';
									echo '<span style="color:#34ce6c;font-size:25px;">' . $ulast_db . '</span>';
									echo '<h3 style="color:black;font-size:25px;">Email:</h3>';
									echo '<span style="color:#34ce6c;font-size:25px;">' . $uemail_db . '</span>';
									echo '<h3 style="color:black;font-size:25px;">Contact Number:</h3>';
									echo '<span style="color:#34ce6c;font-size:25px;">' . $umob_db . '</span>';
									echo '<h3 style="color:black;font-size:25px;">Home Address:</h3>';
									echo '<span style="color:#34ce6c;font-size:25px;">' . $uadd_db . '</span>';

									$del = $_POST['Delivery'];
									echo '<h3 style="color:black;font-size:25px;">Types of Delivery:</h3>';
									echo '<span style="color:#34ce6c;font-size:25px;">' . $del . '</span>';
									$quan = $_POST['Quantity'];
									echo '<h3 style="color:black;font-size:25px;">Quantity:</h3>';
									echo '<span style="color:#34ce6c;font-size:25px;">' . $quan . '</span>';

									echo '<h3 style="color:#169E8F;font-size:45px;">Total: ' . $quan * $price . ' Php</h2>';
								} else {
									echo '
                                        <div class="signupform_text"></div>
                                        <div>
                                            <form action="" method="POST" class="registration">
                                                <div class="signup_form">
                                                    <h3 style="color:red;font-size:18px;padding:5px;">Accepting Cash On Delivery Only</h3>
                                                    <div class="form-group">
                                                        <input name="fullname" placeholder="Your name" required="required" class="form-control" type="text" value="' . $uname_db . '">
                                                    </div>
                                                    <div class="form-group">
                                                        <input name="lastname" placeholder="Your last name" required="required" class="form-control" type="text" value="' . $ulast_db . '">
                                                    </div>
                                                    <div class="form-group">
                                                        <input name="mobile" placeholder="Your mobile number" required="required" class="form-control" type="text" value="' . $umob_db . '">
                                                    </div>
                                                    <div class="form-group">
                                                        <input name="address" id="password-1" required="required" placeholder="Write your full address" class="form-control" type="text" value="' . $uadd_db . '">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="delivery">Types of Delivery:</label><br>
                                                        <input name="Delivery" required="required" value="Express Delivery +100php upon cash on delivery" type="radio"> Express Delivery<br>
                                                        <input name="Delivery" type="radio" value="Standard Delivery" required="required"> Standard Delivery<br>
                                                    </div>
                                                    <div class="form-group">
                                                        <input name="Quantity" required="required" type="number" min="1" class="form-control" placeholder="Quantity">
                                                    </div>
                                                    <div class="form-group">
                                                        <input name="order" class="btn btn-primary" type="submit" value="Confirm Order">
                                                    </div>
                                                    <div class="signup_error_msg">';
									if (isset($error_message)) {
										echo $error_message;
									}
									echo '</div>
                                                </div>
                                            </form>
                                        </div>
                                    ';
								}
								?>
							</div>
						</div>
					</div>
					<div style="float: left; font-size: 23px;">
						<div>
							<?php
							echo '
                            <ul style="float: left;">
                                <li style="float: left; padding: 0px 25px 25px 25px;">
                                    <div class="home-prodlist-img">
                                        <a href="' . $category . '/view_product.php?pid=' . $id . '">
                                            <img src="https://robohash.org/' . $id . '" class="home-prodlist-imgi">
                                        </a>
                                        <div style="text-align: center; padding: 0 0 6px 0;">
                                            <span style="font-size: 15px;">' . $pName . '</span><br>
                                            Price: ' . $price . ' Php
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        ';
							?>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</body>

</html>