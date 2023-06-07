<?php
session_start();
include "includes/config.php";

 if (isset($_POST['account'])) {
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $email=$_POST['email'];
    $cnumber=$_POST['cnumber'];
    $password=$_POST['password'];
    $cpassword=$_POST['cpassword'];

    // sanitization and validation of data
    if (!$fname || !$lname || !$email || !$cnumber || !$password || !$cpassword) {
      $_SESSION['error'] = "This field should not be empty!";
    }
    else {
      // sanitise and validate the email
      $sanitizedEmail = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
      if ($sanitizedEmail) {
        $validatedEmail = filter_var($sanitizedEmail, FILTER_VALIDATE_EMAIL);
        if ($validatedEmail == false) {
          $_SESSION['error'] = "Bad email format";
        }
      }

      // check if the password contains 8 characters and has letters and numbers.
      if (! preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z]{8,}$/',$_POST["password"])) {
          echo  "Password must contain numbers and letters and must be at least 8 characters long!";
      }
      if ($password !== $cpassword) {
        $_SESSION['error'] = "Passwords should match";
      }
    }

    if (empty($_SESSION['error'])) {
      $sql="INSERT INTO users (fname, lname, email, password, contactno)
     VALUES (:fname, :lname, :email, :password, :cnumber)";
     $query=$dbh->prepare($sql);
     $query->bindParam(':fname', $fname, PDO::PARAM_STR);
     $query->bindParam(':lname', $lname, PDO::PARAM_STR);
     $query->bindParam(':email', $email, PDO::PARAM_STR);
     $query->bindParam(':password', $password, PDO::PARAM_STR);
     $query->bindParam(':cnumber', $cnumber, PDO::PARAM_STR);
     $query->execute();
     $lastInsertId = $dbh->lastInsertId();
    if($lastInsertId)
    {
      echo "You have signed up successfully";
      header('Location: index.php');
      exit;
    }
    else
    {
      echo "Something went wrong.Please try again";
    }
    }
}
?>

<?php include "includes/header.php";?>
<div class="container">
    <form method="POST">
      <?php
      if (isset($_SESSION['error'])) :?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['error']?> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <?php unset($_SESSION['error']);?>
      </div>
      <?php endif ?>
      
      <div class="mb-3">
        <label for="firstname" class="form-label">First Name</label>
        <input type="text" class="form-control" name="fname" id="firstname">
      </div>

      <div class="mb-3">
        <label for="lastname" class="form-label">Last Name</label>
        <input type="text" class="form-control" name="lname" id="lastname">
      </div>

      <div class="mb-3">
        <label for="emailaddress" class="form-label">Email Address</label>
        <input type="text" class="form-control" name="email" id="emailaddress">
      </div>

      <div class="mb-3">
        <label for="contactnumber" class="form-label">Contact Number</label>
        <input type="phone" class="form-control" name="cnumber" id="contactnumber">
      </div>

      <div class="mb-3">
        <label for="passsword" class="form-label">Password</label>
        <input type="password" class="form-control" name="password" id="passsword">
      </div>

      <div class="mb-3">
        <label for="confirmpassword" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" name="cpassword" id="confirmpassword">
      </div>

      <button type="submit" class="btn btn-primary" name="account">Create Account</button>
    </form>
</div>


<?php include "includes/footer.php";?>