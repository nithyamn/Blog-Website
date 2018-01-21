<?php
include_once('includes/db.php');

if(!isset($_GET['token']) || !isset($_GET['email'])){
    header("Location: index.php");
}else{
    $token=$_GET['token'];
    $email=$_GET['email'];
    $query="select * from users where token='$token'";
    $updatePasswordUser=mysqli_query($conn,$query);
    if(mysqli_num_rows($updatePasswordUser) == 0){
        header("Location: index.php");
    }
}
if(isset($_POST['reset-password'])){
    $password=$_POST['password'];
    $password2=$_POST['password2'];

    if($password == $password2){
        $options = [
            'cost' => 10,
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
        ];
        $hashedPass=password_hash($password,PASSWORD_BCRYPT, $options);
        //echo $hashedPass;
        
        $query="update users set token='',user_password='$hashedPass' where token='$token' and user_email='$email'";
        $resetPassword=mysqli_query($conn,$query);
        if(!$resetPassword){
            die("QUERY FAILED".mysqli_error($conn));
        }else{
            echo "Password changed successfully!";
        }
    }else{
        echo "Password does not match!";
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
                                    Reset Password
                                </h2>
                                <div class="panel-body">
                                    <form action="" role="form" method="POST">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-lock"></i>
                                                </span>
                                                <input type="password" id="password" name="password" placeholder="Please enter new Password!" class="form-control">
                                            </div>
                                        </div>
                                        
                                         <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-lock"></i>
                                                </span>
                                                <input type="password" id="password2" name="password2" placeholder="Please re-enter new Password!" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-lg btn-primary btn-block" name="reset-password">
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