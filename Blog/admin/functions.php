<?php
function confirmQuery($result){
    global $conn;
    if(!$result){
        die('QUERY FAILED: '.mysqli_error($conn));
    }
}

if(isset($_GET['onlineusers'])){
    session_start();
    include_once("../includes/db.php");
    checkUserSession();
}
function checkUserSession(){
    global $conn;
    if(!$conn){
        echo "Connection not found";
    }
        $session=session_id();
        $user_id=$_SESSION['user_id'];
        $time_out_in_secs=60;
        $time=time();
        $time_out = $time - $time_out_in_secs;
    
    
        $query="select * from users_online where session='$session'";
        $user_exists=mysqli_query($conn,$query);
        if(mysqli_num_rows($user_exists)==0){
            $query="insert into users_online(session,time,user_id) values('$session','$time','$user_id')";
            $insert_query=mysqli_query($conn,$query);
        }
//        else{
//            //making provision to auto log out if no activity conducted
//            $query="update users_online set time='$time' where session='$session'";
//            $update_query=mysqli_query($conn,$query);
//        }
        $query="select * from users_online where time > $time_out";
        $online_users_query=mysqli_query($conn,$query);
        $online_users_count=mysqli_num_rows($online_users_query);
        echo $online_users_count;   
}
function checkUser(){
    
    if(!isset($_SESSION['username'])){
        die("<p style='color:white'>You have logged in. Log in from <a href='../index.php'>here</a</p>");
    }else{
        $username=$_SESSION['username'];
        return $username;
    }
}
function addCategory(){
    global $conn;
    if(isset($_POST['submit'])){
        if(!$_POST['cat_title']){
            echo "Enter category";
        }
        else{
            $input_cat_title=$_POST['cat_title'];
            $checkQuery="select cat_title from categories where cat_title='$input_cat_title'";
            $resultQuery=mysqli_query($conn,$checkQuery);
            if(mysqli_num_rows($resultQuery)>0)
                echo "Category already Exists";
            else{
                $query="insert into categories(cat_title) value('$input_cat_title')";
                $add_cat_query=mysqli_query($conn,$query);
                if(!$add_cat_query)
                    die("QUERY FAILED: ".mysqli_error($conn)); 
                else
                     header("Location: categories.php");
            }
        }
    }
}

function editCategory(){
    global $conn;//bcoz external file se aa rha hai ye file for function ye global not local so specify
    $flag=0;
    if(isset($_POST['edit_submit'])){
        if(!$_POST['edit_cat_title']){
            echo "Enter category";
        }else{
            $input_cat_title=$_POST['edit_cat_title'];
            $input_cat_id=$_GET['edit'];
            $checkQuery="select cat_title from categories where cat_title='$input_cat_title'";
            $resultQuery=mysqli_query($conn,$checkQuery);
            if(mysqli_num_rows($resultQuery)>0)
            {
                $row=mysqli_fetch_assoc($resultQuery);
                    if(strcmp($input_cat_title,$row['cat_title'])!=0)
                        $flag=1;
            }
            if($flag==1)
            {
                $query="update categories set cat_title='$input_cat_title' where cat_id='$input_cat_id'";
                $update_cat_query=mysqli_query($conn,$query);
                if(!$update_cat_query)
                    die("QUERY FAILED: ".mysqli_error($conn)); 
                else
                    header("Location: categories.php");   
            }
            else{
                echo "Category already exists!";
            }
        }
    }
}
function fetchCategoryForEdit(){
    global $conn;           
//$edit_cat_title=""; //do not initialize when you want to check isset
                            
    if(isset($_GET['edit'])){
        $edit_cat_id=$_GET['edit'];
        $query="SELECT * FROM categories WHERE cat_id=$edit_cat_id";
        $edit_cat_result=mysqli_query($conn,$query);
        if($edit_cat_result){
            if(mysqli_num_rows($edit_cat_result)>0){
                if(mysqli_num_rows($edit_cat_result)>1){
                     echo "Error!:".mysqli_error($conn);
                }
                else{
                    if($row=mysqli_fetch_assoc($edit_cat_result)){
                        return $row['cat_title'];
                    }
                }
            }
        }
        else{
            echo "Error!: ".mysqli_error($conn);
        }
    }
}
?>