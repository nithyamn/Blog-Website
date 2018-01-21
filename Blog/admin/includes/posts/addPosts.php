<?php
//    $post_status=null;
    if(isset($_POST['create_post'])){
        $post_title=$_POST['title'];
        $post_author=$_SESSION['user_id'];
        $post_category_id=$_POST['post_category_id'];
        $post_status=$_POST['status'];
        if($post_status=="" || !isset($post_status)){
            $post_status="draft";
        }
        $post_image=$_FILES['image']['name'];
        $post_image_temp=$_FILES['image']['tmp_name'];
        $post_tags=$_POST['tags'];
        $post_content=$_POST['post_content'];
        //$post_date=date('d-m-y'); now() is by sql
        $post_comment_count=0;
        move_uploaded_file($post_image_temp,"../images/$post_image");
        
        $query="insert into posts(post_category_id,post_title,post_author,post_date,post_image,post_content,post_tags,post_comment_count,post_status) value('$post_category_id','$post_title','$post_author',now(),'$post_image','$post_content','$post_tags','$post_comment_count','$post_status')";
//        if($post_title && $post_author){
                $create_post_query=mysqli_query($conn,$query);
                confirmQuery($create_post_query);
                header("Location: posts.php");
                //echo "<div class='alert alert-success'>Published</div>";
//        }   
//        else{
//            echo "No blank Enteries allowed";
//        }
   }
?>
<form id="addPost" action="" method="POST" enctype="multipart/form-data">
<!--enctype is for telling http that sirf data nai hai uske alawa bhi kuch hai like we want to uplaod any image or text file-->
    <div class="form-group">
        <label for="post_title">Post Title</label>
            <input type="text" class="form-control" name="title" id="post_title">
    </div>
    <div class="form-group">
        <label for="post_category">Post Category Id</label>
        <select class="form-control" name="post_category_id" id="post_category">
           <?php
                $query="select * from categories";
                $fetchQuery=mysqli_query($conn,$query);
                while($row=mysqli_fetch_assoc($fetchQuery)){
                    $cat_id=$row['cat_id'];
                    $cat_title=$row['cat_title'];
                    if($post_category_id==$cat_id){
                        echo "<option value='$cat_id' selected>$cat_title</option>";
                    }else{
                        echo "<option value='$cat_id'>$cat_title</option>";
                    }
                            
                }
            ?>
           
        </select>
    </div>
    <div class="form-group">
        <label for="post_status">Post Status</label>
        <select class="form-control" name="status" id="post_status">
            <option value="draft" selected>Draft</option>
            <option value="published">Published</option>
        </select>
    </div>
<!--image ka name and id should be always different!-->
    <div class="form-group">
        <label for="post_image">Post Image</label>
            <input type="file" class="form-control" name="image" id="post_image">
    </div>
    
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
            <input type="text" class="form-control" name="tags" id="post_tags">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name="post_content" id="post_content" cols="30" rows="10"></textarea>
    </div>
    
    <div class="form-group">
        <div class="col-md-9 col-md-offset-3">
            <div id="messages"></div>
        </div>
    </div>
    
    <div class="form-group">
            <input type="submit" class="btn btn-primary" name="create_post" value="Publish Post">
    </div>
</form>