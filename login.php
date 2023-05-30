<?php
session_start();
include "includes/config.php";

if (isset($_POST['submit'])) {
    $email=$_POST['email'];
    $password=$_POST['password'];
    $sql= "SELECT * FROM users WHERE email=:email";
    $query=$dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $results = $query -> fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
      if ($password === $_POST['password']) {
        $_SESSION["login"] =true;
        $_SESSION['id']=$id;
        header("location:login_success.php");
      }
      else {
        echo "wrong password";
      }
}
else {
  echo "User not registered";
}
}
?>

<?php include "includes/header.php";?>
<div class="form-div">
  <form method="POST" action="">
    <div class="mb-3">
      <label for="email" class="form-label">Email address</label>
      <input type="text" class="form-control" name="email" id="email">
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" class="form-control" name="password" for="password">
    </div>
    
    <button type="submit" class="btn btn-primary" name="submit">Login</button>
  </form>
</div>

<?php include "includes/footer.php";?>