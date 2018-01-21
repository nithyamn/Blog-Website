<?php
// abc' or 1=1 #;
include('db.php');
session_start();
if(isset($_POST['login'])){
    $username=$_POST['username'];
    $password=$_POST['password'];
    $username=mysqli_real_escape_string($conn,$username);
    $password=mysqli_real_escape_string($conn,$password);
    $query="select * from users where username='$username'";
    $select_user_details=mysqli_query($conn,$query);
    
    if(mysqli_num_rows($select_user_details)>1){
        header("Location: ../index.php");
    }
    if($row=mysqli_fetch_assoc($select_user_details)){
        $user_id = $row['user_id'];
        $db_username = $row['username'];
        $db_hashed_password = $row['user_password'];
        $db_role = $row['user_role'];
        $token=$row['token'];
    }else{
        $db_hashed_password="";
    }
    if($token == ""){
        if(password_verify($password,$db_hashed_password) && $username===$db_username){
            $_SESSION['username']=$db_username;
            $_SESSION['user_role']=$db_role;
            $_SESSION['user_id']=$user_id;
            header("Location: ../admin/");
        }
        else{
            header("Location: ../index.php");
        }
    }else{
        echo "Cannot Login! You have clicked forgot password before!";
    }
}
?>