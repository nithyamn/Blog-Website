<?php
    if(isset($_POST['edit_user'])){
        $edit_id=$_GET['edit_id'];
        $user_firstname=$_POST['user_firstname'];
        $user_lastname=$_POST['user_lastname'];
        $user_email=$_POST['user_email'];
        $username=$_POST['username'];
        $user_password=$_POST['password'];
        
        $user_role=$_POST['user_role'];
        $user_image=$_FILES['user_image']['name'];
        $user_image_temp=$_FILES['user_image']['tmp_name'];
        move_uploaded_file($user_image_temp,"images/users/$user_image");
        if($user_image==null){
            $imageQuery="select user_image from users where user_id=$edit_id";
            $imageResult=mysqli_query($conn,$imageQuery);
            $row=mysqli_fetch_assoc($imageResult);
            $user_image=$row['user_image'];
        }
        //check password
//        $old_password=$_POST['oldpassword'];
//        $new_password=$_POST['newpassword'];
//        $query="select user_password from users where user_id='$edit_id'";
//        $pwdCheck=mysqli_query($conn,$query);
//        $row=mysqli_fetch_assoc($pwdCheck);
        
//        $options = [
//                'cost' => 10,
//                'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
//        ];
//        $hashedPass=password_hash($user_password,PASSWORD_BCRYPT, $options);
//    
//        $updatePassword="update users set user_password='$hashedPass' where user_id='$edit_id'";
//        if($old_password===$row['user_password']){
//            if($old_password==$new_password){
//                echo "Enter a new password!";
//            }
//            else{
//                $updatePasswordQuery=mysqli_query($conn,$updatePassword);
//                confirmQuery($updatePasswordQuery);
//            }
//        }
//        else{
//            echo "Old password entered Wrong!";
//        }
//        //end of check password
        
        $passwordQuery="select user_password from users where user_id=$edit_id";
        $passwordResult=mysqli_query($conn,$passwordQuery);
        $row=mysqli_fetch_assoc($passwordResult);
        
        $query="update users set user_firstname='$user_firstname', user_lastname='$user_lastname', user_email='$user_email', username='$username', user_role='$user_role',user_image='$user_image' where user_id='$edit_id'";
        if(password_verify($user_password,$row['user_password'])){ 
            $edit_user_query=mysqli_query($conn,$query);
            confirmQuery($edit_user_query);
            header("Location: users.php");   
        }else{
            echo "Password does not match!";
        }
    }

    if(isset($_GET['edit_id'])){
        $edit_user_id=$_GET['edit_id'];
        $query="select * from users where user_id=$edit_user_id";
        $edit_user_query=mysqli_query($conn,$query);
        if($row=mysqli_fetch_assoc($edit_user_query)){
            $user_id = $row['user_id'];
            $username = $row['username'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_password = $row['user_password'];
            $user_role = $row['user_role'];
            $user_image = $row['user_image'];
        }
    }

?>

<form ation="" method="POST" enctype="multipart/form-data">
<!--enctype is for telling http that sirf data nai hai uske alawa bhi kuch hai like we want to uplaod any image or text file-->
    <div class="form-group">
        <label for="first-name">First name</label>
            <input type="text" class="form-control" name="user_firstname" id="first-name" value="<?php echo $user_firstname;?>">
    </div>
    <div class="form-group">
        <label for="last-name">last name</label>
            <input type="text" class="form-control" name="user_lastname" id="last-name" value="<?php echo $user_lastname;?>">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
            <input type="email" class="form-control" name="user_email" id="email" value="<?php echo $user_email;?>">
    </div>
<!--image ka name and id should be always different!-->
    <div class="form-group">
        <label for="roles">User Role</label>
        <select class="form-control" name="user_role" id="roles">
            <option value="subscriber" <?php if($user_role=="subscriber"){echo "selected";}?>>Subscriber</option>
            <option value="admin" <?php if($user_role=="admin"){echo "selected";}?>>Admin</option>
        </select>
    </div>
    <div class="form-group">
        <label for="username">Username</label>
            <input type="text" class="form-control" name="username" id="username" value="<?php echo $username;?>"> 
    </div>
<!--
    <div class="form-group" id="confirmPassword">
        <label for="password">Revised Password</label>
        <input type="text" class="form-control" name="user_password" id="password">
        <a href="javascript:changePassword()">Change Password</a>
    </div>
-->
     
<!--    <button class="btn btn-default" id="change">Change Password</button>-->
    
<!--
    <div class="form-group" id="change-password" style="display:none;">
        <label for="old-password">Enter Old Password</label>
        <input type="password" class="form-control" id="old-password" name="oldpassword">
        <label for="new-password">Enter new Password</label>
        <input type="password" class="form-control" id="new-password" name="newpassword">
    </div>
-->

     <div class="form-group">
        <label for="image">Current Image</label>
            <img src="images/users/<?php echo $user_image; ?>" alt="" height="100px" width="100px" class='img-responsive'> 
    </div>
    <div class="form-group">
        <label for="image">New Image</label>
        <input type="file" class="form-control" name="user_image" id="image">
    </div>
    
     <div class="form-group">
        <label for="password">Current Password</label>
            <input type="password" class="form-control" name="password" id="password"> 
    </div>
    
    <div class="form-group">
            <input type="submit" class="btn btn-primary" name="edit_user" value="Edit User">
    </div>
    
<!--Modal-->
</form>
 <script
            src="https://code.jquery.com/jquery-3.1.1.min.js"
            integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
            crossorigin="anonymous"> </script>
        
<!--
<script>
function changePassword() {
    var x = document.getElementById("change-password");
    if (x.style.display === "none"){
        x.style.display = "block";
        
    } else {
        x.style.display = "none";
    }
}
//$(document).ready(function(){
//    $("#change-password").hide();
//    $("#change").click(function(){
//        $("#change-password").show();
//    });
//});
</script>-->
