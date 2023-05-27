<?php include("inc/connect.inc.php"); ?>
<?php
ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
    $user = "";
} else {
    $user = $_SESSION['user_login'];
    $result = mysqli_query($con, "SELECT * FROM user WHERE id='$user'");
    $get_user_email = mysqli_fetch_assoc($result);
    $uname_db = $get_user_email != null ? $get_user_email['firstName'] : null;
}
?>
<?php
$categoryNames = array(
    array('Bolttron', 1),
    array('Nexus Prime', 2),
    array('Sparklebot', 3),
    array('TurboX', 4),
    array('RoboRover', 5),
    array('ElectraTech', 6),
    array('AstroByte', 7),
    array('DynaBot', 8)
);

shuffle($categoryNames);

?>



<!DOCTYPE html>
<html>

<head>
    <title>Welcome to ROBO HASH Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./style.css">

</head>

<body>
    <div class="container-fluid">

        <?php include("./components/min-navbar.php"); ?>

    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="home-welcome">
                    <div class="home-welcome-text">
                        <div style="padding-top: 180px; padding-left: 20px;">
                            <div>
                                <h1>ROBO HASH STORE</h1>
                                <h2>You can buy any ROBO HASH photos</h2>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="home-prodlist">
                    <div>
                        <h3 class="text-center">Products Category</h3>
                    </div>
                    <div class="d-flex justify-content-center">
                        <ul class="list-inline">
                            <?php foreach ($categoryNames as $category) { ?>
                                <li class="list-inline-item">
                                    <div class="home-prodlist-card">
                                        <a href="OurProducts/<?php echo str_replace(' ', '', $category[0]); ?>.php">
                                            <img src="https://robohash.org/<?php echo $category[1]; ?>" class="home-prodlist-imgi">
                                            <div class="home-prodlist-overlay">
                                                <h4><?php echo $category[0]; ?>
                                            </div>
                                        </a>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>


                </div>
            </div>
        </div>
    </div>
</body>

</html>