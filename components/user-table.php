<div style="margin: 0 auto; width: 55%; float: left;">
  <ul class="list-group">
    <li class="list-group-item" style="background-color: #fff;">
      <div>
        <div>
          <table class="table table-bordered">
            <thead class="thead-dark">
              <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Pieces</th>
                <th>Description</th>
                <th>View</th>
                <th>Remove</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $query = "SELECT * FROM cart WHERE uid = :user ORDER BY id DESC";
              $stmt = $pdo->prepare($query);
              $stmt->bindValue(':user', $user, PDO::PARAM_INT);
              $stmt->execute();
              $total = 0;
              while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $pid = $row['pid'];
                $quantity = $row['quantity'];

                // Get product info
                $query1 = "SELECT * FROM products WHERE id = :pid";
                $stmt1 = $pdo->prepare($query1);
                $stmt1->bindValue(':pid', $pid, PDO::PARAM_INT);
                $stmt1->execute();
                $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                $pId = $row1['id'];
                $pName = substr($row1['pName'], 0, 50);
                $price = $row1['price'];
                $description = $row1['description'];
                $picture = $row1['picture'];
                $item = $row1['item'];
                $category = $row1['category'];

                $total += ($quantity * $price);
                $_SESSION['total'] = $total;
              ?>
                <tr>
                  <td><?php echo $pName; ?></td>
                  <td><?php echo $price; ?></td>
                  <td>
                    <?php echo '<a href="delete_cart.php?sid=' . $pId . '" class="btn btn-sm btn-secondary">-</a>' ?>
                    <?php echo $quantity; ?>
                    <?php echo '<a href="delete_cart.php?aid=' . $pId . '" class="btn btn-sm btn-secondary">+</a>' ?>
                  </td>
                  <td><?php echo $description; ?></td>
                  <td>
                    <div class="home-prodlist-img">
                      <a href="OurProducts/view_product.php?pid=<?php echo $pId; ?>">
                        <img src="https://robohash.org/' . $id . '" class="home-prodlist-imgi" style="height: 75px; width: 75px;">
                      </a>
                    </div>
                  </td>
                  <td>
                    <div class="home-prodlist-img">
                      <a href="delete_cart.php?cid=<?php echo $pId; ?>" class="btn btn-sm btn-danger">X</a>
                    </div>
                  </td>
                </tr>
              <?php } ?>
              <tr class="thead-dark">
                <th>Total</th>
                <th></th>
                <th><?php echo $total ?> Php</th>
                <th></th>
                <th></th>
                <th></th>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </li>
  </ul>
</div>