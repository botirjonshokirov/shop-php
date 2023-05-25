<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <h5>ROBO HASH STORE</h5>
        </a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <?php
                    if ($user != "") {
                        echo '<a class="nav-link" href="logout.php">LOG OUT</a>';
                    } else {
                        echo '<a class="nav-link" href="signin.php">SIGN UP</a>';
                    }
                    ?>
                </li>
                <li class="nav-item">
                    <?php
                    if ($user != "") {
                        echo '<a class="nav-link" href="profile.php?uid=' . $user . '">Hi ' . $uname_db . '</a>';
                    } else {
                        echo '<a class="nav-link" href="login.php">LOG IN</a>';
                    }
                    ?>
                </li>
            </ul>
        </div>
    </div>
</nav>