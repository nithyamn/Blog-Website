<?php
include_once('includes/db.php');
if(!isset($_GET['forgot'])){
    header("Location: index.php");
}
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['email'])){
        $email=$_POST['email'];
        $length=50;
        $token=bin2hex(openssl_random_pseudo_bytes($length));
        //this token will be stored in users table. If token is not set thenonly login allowed else forgot password kia tha!
        
        //chech whether email id exists!
        $query="select * from users where user_email='$email'";
        $user=mysqli_query($conn,$query);
        if(mysqli_num_rows($user)){
            $query="update users set token='$token'  where user_email='$email'";
            $updateToken=mysqli_query($conn,$query);
            if(!$updateToken){
                die("QUERY FAILED".mysqli_error($conn));
            }
            
            $headers = 'MIME-Version: 1.0'."\r\n";
            $headers .= 'From: Nithya Mani <nithya@studylink.com>'."\r\n";
            $headers .= 'Content-type: text/html; charset-iso-8859-1'."\r\n";

            $to=$email;
            $subject="Study Link Forgot Password";
            $body="Please Click the link below to reset password.<br/>
            <a href='http://localhost/Blog/reset.php?email=$email&token=$token'>http://localhost/Blog/reset.php?email=$email&token=$token</a>";
            
            
            $sentStatus=mail($to,$subject,$body,$headers);
            if(!$sentStatus){
                echo error_get_last()['message'];
            }else{
                echo "<div class='alert alert-success'>Sent!</div>";
            }
            
            
        }else{
            echo "Issue with email id! Or no such user found!";
        }
    }
}
?>
<html>
    <?php
        $title="Forgot Password";
        include_once('includes/header.php');
    ?>
    <body>
        <?php include_once('includes/navigation.php');?>
        
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="text-center">
                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">
                                    Forgot Password?
                                </h2>
                                <p>You can reset your password.</p>
                                <div class="panel-body">
                                    <form action="" role="form" method="POST">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-lock"></i>
                                                </span>
                                                <input type="email" id="email" name="email" placeholder="Please enter your email!" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-lg btn-primary btn-block" name="reset-submit">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </body>
</html>