<?php
session_start();
include "includes/config.php";

 if (isset($_POST['account'])) {
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $email=$_POST['email'];
    $cnumber=$_POST['cnumber'];
    $password=md5($_POST['password']);
    $cpassword=md5($_POST['cpassword']);

    //checking if the username exists
    $sql2="SELECT * FROM users WHERE email=:email OR fname=:fname";
    $query0=$dbh->prepare($sql2);
    $query0->bindParam(':email', $email, PDO::PARAM_STR);
    $query0->bindParam(':fname', $fname, PDO::PARAM_STR);
    $query0->execute();
    if ($query0->rowCount() > 0) {
      echo "This email or username already exists";
    }
    
    else{
      if ($password === $cpassword) {
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
      $_SESSION['userlogin']=$_POST['email'];
      echo "You have signed up well";
    }
    else
    {
      echo "Something went wrong.Please try again";
    }
  }
  else {
    echo "Passwords don't match";
  }
}
 
}
?>

<?php include "includes/header.php";?>
<form method="POST">

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
    <input type="email" class="form-control" name="email" id="emailaddress">
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

<?php include "includes/footer.php";?>