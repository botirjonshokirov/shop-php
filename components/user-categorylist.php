<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a href="mycart.php?uid=<?php echo $user; ?>" class="nav-link">My Cart</a>
      </li>
      <li class="nav-item">
        <a href="profile.php?uid=<?php echo $user; ?>" class="nav-link">My Orders</a>
      </li>
      <li class="nav-item">
        <a href="my_delivery.php?uid=<?php echo $user; ?>" class="nav-link">My Delivery History</a>
      </li>
      <li class="nav-item">
        <a href="settings.php?uid=<?php echo $user; ?>" class="nav-link">Settings</a>
      </li>
    </ul>
  </div>
</nav>