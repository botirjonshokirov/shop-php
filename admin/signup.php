<?php
// Include the database connection file
include("../inc/connect.inc.php");

// Check if the form is submitted
if (isset($_POST['insert'])) {
  // Retrieve the form data
  $firstName = mysqli_real_escape_string($con, $_POST['firstName']);
  $lastName = mysqli_real_escape_string($con, $_POST['lastName']);
  $email = mysqli_real_escape_string($con, $_POST['email']);
  $mobile = mysqli_real_escape_string($con, $_POST['mobile']);
  $address = mysqli_real_escape_string($con, $_POST['address']);
  $password = mysqli_real_escape_string($con, $_POST['password']);
  $type = mysqli_real_escape_string($con, $_POST['type']);
  $confirmCode = mysqli_real_escape_string($con, $_POST['confirmCode']);

  // Generate the MD5 hash of the password
  $passwordMd5 = md5($password);

  // Create the INSERT query
  $query = "INSERT INTO admin (firstName, lastName, email, mobile, address, password, type, confirmCode) VALUES ('$firstName', '$lastName', '$email', '$mobile', '$address', '$passwordMd5', '$type', '$confirmCode')";

  // Execute the query
  $result = mysqli_query($con, $query);

  if ($result) {
    // Insertion successful
    $successMessage = "Admin inserted successfully.";
  } else {
    // Insertion failed
    $errorMessage = "Admin insertion failed. Please try again.";
  }
}
?>

<!doctype html>
<html>

<head>
  <title>Admin Insert Form</title>
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f8f9fa;
    }

    .container {
      max-width: 400px;
      margin-top: 100px;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="text-center mb-4">
      <h2>Admin Insert Form</h2>
    </div>
    <form action="" method="POST">
      <div class="form-group">
        <input name="firstName" placeholder="First Name" required="required" class="form-control" type="text">
      </div>
      <div class="form-group">
        <input name="lastName" placeholder="Last Name" required="required" class="form-control" type="text">
      </div>
      <div class="form-group">
        <input name="email" placeholder="Email" required="required" class="form-control" type="email">
      </div>
      <div class="form-group">
        <input name="mobile" placeholder="Mobile" required="required" class="form-control" type="text">
      </div>
      <div class="form-group">
        <input name="address" placeholder="Address" required="required" class="form-control" type="text">
      </div>
      <div class="form-group">
        <input name="password" placeholder="Password" required="required" class="form-control" type="password">
      </div>
      <div class="form-group">
        <input name="type" placeholder="Type" required="required" class="form-control" type="text">
      </div>
      <div class="form-group">
        <input name="confirmCode" placeholder="Confirm Code" required="required" class="form-control" type="text">
      </div>
      <div class="form-group">
        <input name="insert" class="btn btn-primary btn-block" type="submit" value="Insert">
      </div>
      <div class="text-center">
        <?php
        if (isset($successMessage)) {
          // Display success message
          echo '<div class="alert alert-success">' . $successMessage . '</div>';
        } elseif (isset($errorMessage)) {
          // Display error message
          echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
        }
        ?>
      </div>
    </form>
  </div>
</body>

</html>