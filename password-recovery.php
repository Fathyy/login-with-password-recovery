<?php
include "includes/config.php";
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception; 

require 'vendor/autoload.php';

$mail = new PHPMailer;
if (isset($_POST['send'])) {
    $femail = $_POST['femail'];
    $sql = "SELECT email, password, fname FROM users WHERE email:femail";
    $query=$dbh->prepare($sql);
    $query=bindParam('email', $femail, PDO::PARAM_STR);
    $query->execute();
    if ($results->query->fetch()) {
        $toemail=$results('email');
        $fname==$results('fname');
        $subject= "Information about your password";
        $password=$results('$password');
        $message="Your password is " .$password;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';             // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                     // Enable SMTP authentication
        $mail->Username = 'your gmail id here';    // SMTP username
        $mail->Password = 'your gmail password here'; // SMTP password
        $mail->SMTPSecure = 'tls';                  // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                          // TCP port to connect to
        $mail->setFrom('your gmail id here','your name here');
        $mail->addAddress($toemail);   // Add a recipient
        $mail->isHTML(true);  // Set email format to HTML
        $bodyContent=$message;
        $mail->Subject =$subject;
        $bodyContent = 'Dear'." ".$fname;
        $bodyContent .='<p>'.$message.'</p>';
        $mail->Body = $bodyContent;
        if (!$mail->send()) {
            echo  "<script>alert('Message could not be sent');</script>";
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
        else{
            echo  "<script>alert('Your Password has been sent Successfully');</script>";
        }


    }

      
}


?>

<?php include "includes/header.php";?>
<div class="container">
    <div class="row">
    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" class="form-control" name="femail" placeholder="name@example.com" required>
        </div>
        
        <button type="submit" class="btn btn-primary" name="send">Reset Password</button>
        <div>
            <a href="signup.php">Need an account? Signup </a>
            <a href="index.php">Back to Home</a>
        </div>
</form>

    </div>
</div>



<?php include "includes/footer.php";?>
