<?php include("../inc/connect.inc.php"); ?>
<?php
ob_start();
session_start();
if (!isset($_SESSION['admin_login'])) {
	header("location: login.php");
	$user = "";
} else {
	$user = $_SESSION['admin_login'];
	$stmt = $pdo->prepare("SELECT * FROM admin WHERE id=:user");
	$stmt->bindValue(':user', $user);
	$stmt->execute();
	$get_user_email = $stmt->fetch(PDO::FETCH_ASSOC);
	$uname_db = $get_user_email['firstName'];
	$utype_db = $get_user_email['type'];
}

?>
<!doctype html>
<html>

<head>
	<title>RoboHash</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body class="home-welcome-text">
	<?php include("./components/admin-navbar.php") ?>

	<?php include("./components/category-list.php") ?>

	<br /><br />
	<div class="container">
		<table class="table table-striped">
			<thead class="thead-dark">
				<tr>
					<th>Id</th>
					<th>User Id</th>
					<th>Product Id</th>
					<th>Q*P=T</th>
					<th>Order Place</th>
					<th>Mobile</th>
					<th>Order Status</th>
					<th>Order Date</th>
					<th>Delivery Date</th>
					<th>User Name</th>
					<th>User Mobile</th>
					<th>User Email</th>
					<th>Edit</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$query = "SELECT * FROM orders ORDER BY id DESC";
				$stmt = $pdo->prepare($query);
				$stmt->execute();
				$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
				foreach ($rows as $row) {
					$oid = $row['id'];
					$ouid = $row['uid'];
					$opid = $row['pid'];
					$oquantity = $row['quantity'];
					$oplace = $row['oplace'];
					$omobile = $row['mobile'];
					$odstatus = $row['dstatus'];
					$odate = $row['odate'];
					$ddate = $row['ddate'];

					// Getting user info
					$query1 = "SELECT * FROM user WHERE id=:ouid";
					$stmt1 = $pdo->prepare($query1);
					$stmt1->bindValue(':ouid', $ouid);
					$stmt1->execute();
					$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
					$ofname = $row1['firstName'];
					$oumobile = $row1['mobile'];
					$ouemail = $row1['email'];

					// Product info
					$query2 = "SELECT * FROM products WHERE id=:opid";
					$stmt2 = $pdo->prepare($query2);
					$stmt2->bindValue(':opid', $opid);
					$stmt2->execute();
					$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
					$opcate = $row2['category'];
					$opitem = $row2['item'];
					$oppicture = $row2['picture'];
					$oprice = $row2['price'];
				?>
					<tr>
						<td><?php echo $oid; ?></td>
						<td><?php echo $ouid; ?></td>
						<td><?php echo $opid; ?></td>
						<td><?php echo '' . $oquantity . ' * ' . $oprice . ' = ' . $oquantity * $oprice . ''; ?></td>
						<td><?php echo $oplace; ?></td>
						<td><?php echo $omobile; ?></td>
						<td><?php echo $odstatus; ?></td>
						<td><?php echo $odate; ?></td>
						<td><?php echo $ddate; ?></td>
						<td><?php echo $ofname; ?></td>
						<td><?php echo $oumobile; ?></td>
						<td><?php echo $ouemail; ?></td>
						<td>
							<div class="home-prodlist-img">
								<a href="editorder.php?eoid=<?php echo $oid; ?>">
									<img src="https://robohash.org/<?php echo $oid; ?>" class="home-prodlist-imgi" style="height: 75px; width: 75px;">
								</a>
							</div>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>

</body>

</html>