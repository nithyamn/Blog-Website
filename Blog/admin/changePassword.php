<!--ADMIN-->
<!DOCTYPE html>
<html lang="en">
<?php
    $page="changePassword";
    include_once('includes/header.php');
    include_once('functions.php');
    $output="";
    if(isset($_POST['changePassword'])){
        $user_id=$_SESSION['user_id'];
        $oldpassword=$_POST['oldpassword'];
        $newpassword=$_POST['newpassword'];
        $confirmpassword=$_POST['confirmpassword'];
        $oldpassword=mysqli_real_escape_string($conn,$oldpassword);
        $newpassword=mysqli_real_escape_string($conn,$newpassword);
        $confirmpassword=mysqli_real_escape_string($conn,$confirmpassword);
        
        $query="select user_password from users where user_id='$user_id'";
        $oldpassword_result=mysqli_query($conn,$query);
//        $count=mysqli_num_rows($oldpassword_result);
//        echo $count;
        $row=mysqli_fetch_assoc($oldpassword_result);
    
        
        if(password_verify($oldpassword,$row['user_password'])){
            if($newpassword && $confirmpassword){
                if($newpassword == $confirmpassword){
                    $options = [
                    'cost' => 10,
                    'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
                ];
                $hashedPass=password_hash($newpassword,PASSWORD_BCRYPT, $options);
                $query="update users set user_password='$hashedPass' where user_id='$user_id'";
                $newpassword_result=mysqli_query($conn,$query);
                $output="Changed Password";
                }else{
                    $output= "New and Confirm password does not match!";
                }
            }else{
                $output= "Enter new and confirm password";
            }
        }else{
            $output= "Old password does not match!";
        }
    }
?>
<body>
    
    <div id="wrapper">

        <!--Navigation -->
        <?php
            include_once('includes/navigation.php');
        ?>
        <!--End of navigation-->

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h2>Change Password</h2>
                       <?php
                        if(!empty($output)){
                        ?>
                        <p class="alert alert-warning"><?php echo $output;?></p>
                        <?php
                        }
                        ?>  
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="oldpassword">Old Password</label>
                            <input type="password" name="oldpassword" id="oldpassword" class="form-control">
                        </div> 
                        <div class="form-group">
                            <label for="newpassword">New Password</label>
                            <input type="password" name="newpassword" id="newpassword" class="form-control">
                        </div> 
                        <div class="form-group">
                            <label for="confirmpassword">Confirm Password</label>
                            <input type="password" name="confirmpassword" id="confirmpassword" class="form-control">
                        </div>    
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" name="changePassword" value="Change Password">
                        </div> 
                    </form>
                    
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->
    
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    
    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <script src="js/scripts.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
