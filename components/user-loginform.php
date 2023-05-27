<div class="container signupform_content" style="background-color: #f8f9fa; padding: 20px;">
  <div>
    <div>
      <?php
      if (isset($success_message)) {
        echo $success_message;
        echo '<h3 style="color:#169E8F;font-size:45px;">Payment & Delivery</h3>';
        $user = $_SESSION['user_login'];
        $result = mysqli_query($con, "SELECT * FROM user WHERE id='$user'");
        $get_user_email = mysqli_fetch_assoc($result);
        $uname_db = $get_user_email['firstName'];
        $ulast_db = $get_user_email['lastName'];
        $uemail_db = $get_user_email['email'];
        $umob_db = $get_user_email['mobile'];
        $uadd_db = $get_user_email['address'];
        echo '<h3 style="color:black;font-size:25px;">First Name:</h3>';
        echo '<span style="color:#34ce6c;font-size:25px;">' . $uname_db . '</span>';
        echo '<h3 style="color:black;font-size:25px;">Last Name:</h3>';
        echo '<span style="color:#34ce6c;font-size:25px;">' . $ulast_db . '</span>';
        echo '<h3 style="color:black;font-size:25px;">Email:</h3>';
        echo '<span style="color:#34ce6c;font-size:25px;">' . $uemail_db . '</span>';
        echo '<h3 style="color:black;font-size:25px;">Contact Number:</h3>';
        echo '<span style="color:#34ce6c;font-size:25px;">' . $umob_db . '</span>';
        echo '<h3 style="color:black;font-size:25px;">Home Address:</h3>';
        echo '<span style="color:#34ce6c;font-size:25px;">' . $uadd_db . '</span>';
        $del = $_POST['Delivery'];
        echo '<h3 style="color:black;font-size:25px;">Types of Delivery:</h3>';
        echo '<span style="color:#34ce6c;font-size:25px;">' . $del . '</span>';
        echo '<h3 style="color:#169E8F;font-size:35px;">Total:' . $_SESSION['total'] . ' Php</h2>';
      } else {
        echo '
        <div class="signupform_text"></div>
        <form action="" method="POST" class="registration">
          <div class="signup_form">
            <h3 style="color:red;font-size:18px; padding: 5px;">Accepting Cash On Delivery Only</h3>
            <div class="form-group">
              <label for="fullname" style="color:black;">First Name:</label>
              <input name="fullname" id="fullname" placeholder="Your name" required="required" class="form-control" type="text" size="30" value="' . $uname_db . '">
            </div>
            <div class="form-group">
              <label for="lastname" style="color:black;">Last Name:</label>
              <input name="lastname" id="lastname" placeholder="Your last name" required="required" class="form-control" type="text" size="30" value="' . $ulast_db . '">
            </div>
            <div class="form-group">
              <label for="mobile" style="color:black;">Mobile Number:</label>
              <input name="mobile" id="mobile" placeholder="Your mobile number" required="required" class="form-control" type="text" size="30" value="' . $umob_db . '">
            </div>
            <div class="form-group">
              <label for="address" style="color:black;">Home Address:</label>
              <input name="address" id="address" required="required" placeholder="Write your full address" class="form-control" type="text" size="30" value="' . $uadd_db . '">
            </div>
            <div class="form-group">
              <label for="delivery" style="color:black;">Types of Delivery:</label>
              <div class="form-check">
                <input name="Delivery" required="required" value="Express Delivery +100php upon cash on delivery" type="radio" class="form-check-input" id="express_delivery">
                <label class="form-check-label" for="express_delivery" style="color:black;">Express Delivery</label>
              </div>
              <div class="form-check">
                <input name="Delivery" type="radio" value="Standard Delivery" required="required" class="form-check-input" id="standard_delivery">
                <label class="form-check-label" for="standard_delivery" style="color:black;">Standard Delivery</label>
              </div>
            </div>
            <div class="form-group">
              <input onclick="myFunction()" name="order" class="btn btn-primary" type="submit" value="Confirm Order">
            </div>
            <div class="signup_error_msg">';
        if (isset($error_message)) {
          echo $error_message;
        }
        echo '</div>
          </div>
        </form>
      </div>
    </div>';
      }
      ?>
      </h3>
    </div>
  </div>
</div>