<!DOCTYPE html>
<html lang="en">

<?php
    $title="Study Link";
    include_once('includes/header.php');
    include_once('includes/db.php');
    
    if(isset($_POST['register'])){
       $username=$_POST['username'];
        $firstname=$_POST['firstname'];
        $lastname=$_POST['lastname'];
        $emailid=$_POST['emailid'];
        $password=$_POST['password'];
//        $image=$_FILES['image']['name'];
//        $image_temp=$_FILES['image']['tmp_name'];
//        move_uploaded_file($image_temp,"images/$image");
//        
       // echo $username." ".$firstname." ".$lastname." ".$emailid." ".$password;
        //cleaning all inputs   
        $username=mysqli_real_escape_string($conn,$username);
        $firstname=mysqli_real_escape_string($conn,$firstname);
        $lastname=mysqli_real_escape_string($conn,$lastname);
        $emailid=mysqli_real_escape_string($conn,$emailid);
        $password=mysqli_real_escape_string($conn,$password);
        
        $query="select username from users where username='$username'";
        $username_query=mysqli_query($conn,$query);
        if(mysqli_num_rows($username_query)>0){
            echo "Username Already Exists!";
            
        }else{
             $options = [
                'cost' => 10,
                'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
             ];
            $hashedPass=password_hash($password,PASSWORD_BCRYPT, $options);
            
            if($firstname && $lastname && emailid && $username && $password){
                $query="insert into users (username,user_password,user_firstname,user_lastname,user_email,user_role) values('$username','$hashedPass','$firstname','$lastname','$emailid','subscriber',)";
                $insert_query=mysqli_query($conn,$query);
                if(!$insert_query){
                    die("QUERY FAILED: ".mysqli_error($conn));
                }else{
                    echo "Inserted Successfully!";
                    header("Location: register.php");
                }   
            }else{
                echo "No blank fields!";
            }
        }
    }
?>

<body>

    <!-- Navigation -->
    <?php //include_once("includes/navigation.php");?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <form action="" method="post" role="form">
                    <legend>Register</legend>
                    <div class="form-group">
                        <label for="firstname">First name</label>
                       <input type="text" name="firstname" id="firstname" placeholder="Enter First Name" class="form-control"> 
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last name</label>
                       <input type="text" name="lastname" id="lastname" placeholder="Enter Last Name" class="form-control"> 
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                       <input type="text" name="username" id="username" placeholder="Enter Username" class="form-control"> 
                    </div>
                    <div class="form-group">
                       <label for="emailid">Email</label>
                       <input type="email" name="emailid" placeholder="example@gmail.com" class="form-control" id="emailid"> 
                    </div>
                    <div class="form-group">
                       <label for="password">Password</label>
                       <input type="password" name="password" placeholder="Enter Password" class="form-control" id="password"> 
                    </div>
                    
                    <div class="form-group">
                       <label for="image">Image</label>
                       <input type="file" name="image" class="form-control" id="image"> 
                    </div>
            
                    <button class="btn btn-primary" type="submit" name="register">Submit</button>
                </form>
            </div>
        

        <!-- Footer -->
       <?php include_once("includes/footer.php"); ?>

    </div>
    
    <!-- /.container -->
    </div>
    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
