<?php
session_start();
include "includes/config.php";

if (empty($_SESSION['id'])==0) {
    header('location:index.php');
}
else {?>

<?php include "includes/header.php";?>

    <div class="container">
        <div class="row">
            <?php 
            $fname = $_SESSION['id'];
            $query = "SELECT * FROM users WHERE fname=:fname";
            $query=$dbh->prepare($query);
            $query->bindParam(':fname', $fname, PDO::PARAM_STR);
            $query->execute();
            while($row=$query->fetch(PDO::FETCH_ASSOC)){
                $fname=$row['fname'];
               }
               ?>

               <div class="intro">
                <p> Welcome back <?php echo $fname;?></p>
                <a href="logout.php"> Log out here</a>
               </div>
    


            
            
        </div>
    </div>
<?php }?>


