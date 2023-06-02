<?php
ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
	header("location: login.php");
} else {
	$user = $_SESSION['user_login'];
	$stmt = $pdo->prepare("SELECT * FROM user WHERE id=:user");
	$stmt->bindParam(':user', $user);
	$stmt->execute();
	$get_user_email = $stmt->fetch(PDO::FETCH_ASSOC);
	$uname_db = $get_user_email['firstName'];
	$uemail_db = $get_user_email['email'];
	$umob_db = $get_user_email['mobile'];
	$uadd_db = $get_user_email['address'];
}

if (isset($_REQUEST['cid'])) {
	$cid = $_REQUEST['cid'];
	$stmt = $pdo->prepare("DELETE FROM cart WHERE pid=:cid AND uid=:user");
	$stmt->bindParam(':cid', $cid);
	$stmt->bindParam(':user', $user);
	if ($stmt->execute()) {
		header('location: mycart.php?uid=' . $user . '');
	} else {
		header('location: index.php');
	}
}

if (isset($_REQUEST['aid'])) {
	$aid = $_REQUEST['aid'];
	$stmt = $pdo->prepare("SELECT * FROM cart WHERE pid=:aid");
	$stmt->bindParam(':aid', $aid);
	$stmt->execute();
	$get_p = $stmt->fetch(PDO::FETCH_ASSOC);
	$num = $get_p['quantity'];
	$num += 1;
	$stmt = $pdo->prepare("UPDATE cart SET quantity=:num WHERE pid=:aid AND uid=:user");
	$stmt->bindParam(':num', $num);
	$stmt->bindParam(':aid', $aid);
	$stmt->bindParam(':user', $user);
	if ($stmt->execute()) {
		header('location: mycart.php?uid=' . $user . '');
	} else {
		header('location: index.php');
	}
}

if (isset($_REQUEST['sid'])) {
	$sid = $_REQUEST['sid'];
	$stmt = $pdo->prepare("SELECT * FROM cart WHERE pid=:sid");
	$stmt->bindParam(':sid', $sid);
	$stmt->execute();
	$get_p = $stmt->fetch(PDO::FETCH_ASSOC);
	$num = $get_p['quantity'];
	$num -= 1;
	if ($num <= 0) {
		$num = 1;
	}
	$stmt = $pdo->prepare("UPDATE cart SET quantity=:num WHERE pid=:sid AND uid=:user");
	$stmt->bindParam(':num', $num);
	$stmt->bindParam(':sid', $sid);
	$stmt->bindParam(':user', $user);
	if ($stmt->execute()) {
		header('location: mycart.php?uid=' . $user . '');
	} else {
		header('location: index.php');
	}
}
