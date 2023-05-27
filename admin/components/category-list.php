<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item ">
        <a href="index.php" class="nav-link ">Home</a>
      </li>
      <li class="nav-item ">
        <a href="addproduct.php" class="nav-link ">Add Product</a>
      </li>
      <li class="nav-item ">
        <a href="orders.php" class="nav-link ">Orders</a>
      </li>
      <li class="nav-item ">
        <a href="DeliveryRecords.php" class="nav-link ">Delivery Records</a>
      </li>
      <?php if ($utype_db == 'admin') : ?>
        <li class="nav-item ">
          <a href="report.php" class="nav-link ">Reports</a>
        </li>
        <li class="nav-item">
          <a href="newadmin.php" class="nav-link ">New Admin</a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
</nav>