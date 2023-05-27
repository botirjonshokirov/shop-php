<div class="categolis">
  <table>
    <tr>
      <?php
      // Define an array of category links
      $categories = array(
        "AstroByte.php" => "AstroByte",
        "Bolttron.php" => "Bolttron",
        "DynaBot.php" => "DynaBot",
        "ElectraTech.php" => "ElectraTech",
        "NexusPrime.php" => "NexusPrime",
        "RoboRover.php" => "RoboRover",
        "Sparklebot.php" => "Sparklebot",
        "TurboX.php" => "TurboX"
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