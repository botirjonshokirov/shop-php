<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="index.php">
      <h5>ROBO HASH STORE</h5>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <?php
          // Check if user is logged in
          if ($user != "") {
            echo '<a class="nav-link" href="logout.php">LOG OUT</a>';
          } else {
            echo '<a class="nav-link" href="signin.php">SIGN UP</a>';
          }
          ?>
        </li>
        <li class="nav-item">
          <?php
          // Check if user is logged in
          if ($user != "") {
            // Fetch the user's name from the database using PDO
            $stmt = $pdo->prepare("SELECT name FROM users WHERE id = :user_id");
            $stmt->bindParam(':user_id', $user);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $uname_db = $row['name'];

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