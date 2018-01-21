<?php
//    $post_status=null;
    if(isset($_POST['create_user'])){
        $user_firstname=$_POST['user_firstname'];
        $user_lastname=$_POST['user_lastname'];
        $user_email=$_POST['user_email'];
        $username=$_POST['username'];
        $user_password=$_POST['user_password'];
        $options = [
                'cost' => 10,
                'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
        ];
        $hashedPass=password_hash($user_password,PASSWORD_BCRYPT, $options);
        
        
        $user_password_confirm=$_POST['user_password_confirm'];
        $user_role=$_POST['user_role'];
        $user_image=$_FILES['user_image']['name'];
        $user_image_temp=$_FILES['user_image']['tmp_name'];
        if($user_password===$user_password_confirm){
            move_uploaded_file($user_image_temp,"images/users/$user_image");
            $query="insert into users(user_firstname, user_lastname, user_email, username, user_password, user_role, user_image) value('$user_firstname','$user_lastname','$user_email','$username','$hashedPass','$user_role','$user_image')";
            if($user_firstname && $user_email && $username && $user_password){
                    $create_user_query=mysqli_query($conn,$query);
                    confirmQuery($create_user_query);
                    header("Location: users.php");
                    //echo "<div class='alert alert-success'>Published</div>";
            }
            else{
                echo "No blank Enteries allowed";
            }
        }
        else{
            echo "Password doesnt match with Confirm Password";
        }
        
   }
?>

<form ation="" method="POST" enctype="multipart/form-data">
<!--enctype is for telling http that sirf data nai hai uske alawa bhi kuch hai like we want to uplaod any image or text file-->
    <div class="form-group">
        <label for="first-name">First name</label>
            <input type="text" class="form-control" name="user_firstname" id="first-name">
    </div>
    <div class="form-group">
        <label for="last-name">last name</label>
            <input type="text" class="form-control" name="user_lastname" id="last-name">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
            <input type="email" class="form-control" name="user_email" id="email">
    </div>
<!--image ka name and id should be always different!-->
    <div class="form-group">
        <label for="role">USer Role</label>
        <select name="user_role" id="role" class="form-control">
            <option value="subscriber">Subscriber</option>
            <option value="admin">Admin</option>
        </select>
    </div>
    <div class="form-group">
        <label for="username">Username</label>
            <input type="text" class="form-control" name="username" id="username">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="user_password" id="password">
    </div>
    <div class="form-group">
        <label for="confirm_password">Confirm Password</label>
        <input type="password" class="form-control" name="user_password_confirm" id="confirm_password">
    </div>
     <div class="form-group">
        <label for="image">User Image</label>
            <input type="file" class="form-control" name="user_image" id="image">
    </div>
    
    <div class="form-group">
            <input type="submit" class="btn btn-primary" name="create_user" value="Create User">
    </div>
</form>