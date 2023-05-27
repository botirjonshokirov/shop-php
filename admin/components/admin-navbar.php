<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="#">Admin Panel</a>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <?php if ($user != "") : ?>
            <a class="nav-link" href="update_admin.php">Hi <?php echo $uname_db; ?></a>
          <?php endif; ?>
        </li>
        <li class="nav-item">
          <?php if ($user != "") : ?>
            <a class="nav-link" href="logout.php">Log Out</a>
          <?php else : ?>
            <a class="nav-link" href="login.php">Log In</a>
          <?php endif; ?>
        </li>
      </ul>
    </div>
  </div>
</nav>