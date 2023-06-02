<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="../index.php">
        <h4>ROBO HASH</h4>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <?php
            $pages = array(
                "AstroByte" => "AstroByte.php",
                "Bolttron" => "Bolttron.php",
                "DynaBot" => "DynaBot.php",
                "ElectraTech" => "ElectraTech.php",
                "NexusPrime" => "NexusPrime.php",
                "RoboRover" => "RoboRover.php",
                "Sparklebot" => "Sparklebot.php",
                "TurboX" => "TurboX.php"
            );

            foreach ($pages as $name => $link) {
                $isActive = (basename($_SERVER['PHP_SELF']) == "OurProducts/" . $link) ? "active" : "";
                echo '<li class="nav-item ' . $isActive . '">';
                echo '<a class="nav-link" href="../OurProducts/' . $link . '">' . $name . '</a>';
                echo '</li>';
            }
            ?>
        </ul>

        <ul class="navbar-nav ml-auto">
            <?php
            if ($user != "") {
                // Fetch the user's name from the database using PDO
                $stmt = $pdo->prepare("SELECT firstName FROM user WHERE id = :user_id");
                $stmt->bindParam(':user_id', $user);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $uname_db = $row['firstName'];

                echo '
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php?uid=' . $user . '">Hi ' . $uname_db . '</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Log Out</a>
                    </li>
                ';
            } else {
                echo '
                    <li class="nav-item">
                        <a class="nav-link" href="signin.php">Sign In</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Log In</a>
                    </li>
                ';
            }
            ?>
        </ul>
    </div>
</nav>