<div class="categolis">
  <table>
    <tr>
      <?php
      // Define an array of category links
      $categories = array(
        "RoboNoodles.php" => "Noodles & Canned",
        "RoboSeasonings.php" => "Seasonings",
        "RoboDrinks.php" => "Drinks",
        "RoboSnacks.php" => "Snacks",
        "RoboSweets.php" => "Sweets",
        "RoboSoap&Detergent.php" => "Soap & Detergent",
        "RoboShampoo.php" => "Shampoo",
        "RoboHygiene.php" => "Hygiene"
      );

      // Loop through the categories and generate the navigation links
      foreach ($categories as $url => $label) {
        echo '<th><a href="' . $url . '" class="btn ';
        echo ($url == basename($_SERVER['PHP_SELF'])) ? 'btn-success' : 'btn-primary';
        echo '">' . $label . '</a></th>';
      }
      ?>
    </tr>
  </table>
</div>