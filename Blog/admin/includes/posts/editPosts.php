<?php
    if(isset($_POST['edit_post'])){
        if(isset($_GET['p_id'])){
            $post_title=$_POST['title'];
            //$post_author=$_SESSION['user_id'];
            $post_category_id=$_POST['post_category_id'];
            $post_status=$_POST['status'];
            $post_image=$_FILES['image']['name'];
            
            $post_image_temp=$_FILES['image']['tmp_name'];
            $post_tags=$_POST['tags'];
            $post_content=$_POST['post_content'];

            move_uploaded_file($post_image_temp,"../images/$post_image");
            $edit_id=$_GET['p_id'];
            if($post_image==null){
                $imageQuery="select post_image from posts where post_id=$edit_id";
                $imageResult=mysqli_query($conn,$imageQuery);
                $row=mysqli_fetch_assoc($imageResult);
                $post_image=$row['post_image'];
            }
            $query="update posts set post_title='$post_title',post_category_id='$post_category_id',post_status='$post_status',post_image='$post_image',post_tags='$post_tags',post_content='$post_content' where post_id=$edit_id";
            if($post_title && $post_status){
                    $edit_post_query=mysqli_query($conn,$query);
                    confirmQuery($edit_post_query);
                    header("Location: posts.php");
                    //echo "<div class='alert alert-success'>Post Updated!</div>";
            }
            else{
                echo "No blank Enteries allowed";
            }
        }
    }

    if(isset($_GET['p_id'])){
        $edit_post_id=$_GET['p_id'];
        $query="select * from posts,users where posts.post_author=users.user_id and post_id=$edit_post_id";
        $edit_post_query=mysqli_query($conn,$query);
        if($row=mysqli_fetch_assoc($edit_post_query)){
            $post_title=$row['post_title'];
            $post_category_id=$row['post_category_id'];
            $post_author=$row['user_firstname']." ".$row['user_lastname'];
            $post_status=$row['post_status'];
            $post_image=$row['post_image'];
            $post_tags=$row['post_tags'];
            $post_content=$row['post_content'];
            $post_date=$row['post_date'];
        }
    }
?>

<form action="" method="POST" enctype="multipart/form-data">

<!--enctype is for telling http that sirf data nai hai uske alawa bhi kuch hai like we want to uplaod any image or text file-->
    <div class="form-group">
        <label for="post_title">Post Title</label>
            <input type="text" class="form-control" name="title" id="post_title" value="<?php echo $post_title; ?>">
    </div>
    <div class="form-group">
            <input type="hidden" class="form-control" name="author" id="post_author" value="<?php echo $post_author; ?>">
    </div>
    <div class="form-group">
        <input type="hidden" class="form-control" name="date" id="post_date" value="<?php echo $post_date; ?>">
    </div>
    <div class="form-group">
        <label for="post_category">Post Category</label>
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
            <option value="draft" <?php if($post_status=="draft"){echo "selected";}?>>Draft</option>
            <option value="published" <?php if($post_status=="published"){echo "selected";}?>>Published</option>
        </select>
    </div>
<!--image ka name and id should be always different!-->
    <div class="form-group">
    <label>Current Image</label>
       <img src="../images/<?php echo $post_image; ?>" alt="" height="100px" width="200px" class='img-responsive' id="current_image"> 
    </div>
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" class="form-control" name="image" id="post_image">
    </div>
    
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
            <input type="text" class="form-control" name="tags" id="post_tags" value="<?php echo $post_tags; ?>">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name="post_content" id="post_content" cols="30" rows="10"><?php echo $post_content; ?></textarea>
    </div>
     <div class="form-group">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal" name="preview" onclick="checkPreview()">Preview</button>
    </div>
    <div class="form-group">
            <input type="submit" class="btn btn-primary" name="edit_post" value="Edit Post">
    </div>
</form>
<!--Modal for Preview-->
 <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-body">
                <h2 id="postTitle"></h2>
                <p class="lead" id="postAuthor"></p>
                <p><span class="glyphicon glyphicon-time" id="postDate"></span></p>
                <hr>
                <img src="" id="postImage">
                 <hr>
                <p id="postContent"></p>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    function checkPreview(){
        var postTitle=document.getElementById("post_title").value;
        var postAuthor=document.getElementById("post_author").value;
        var postDate=document.getElementById("post_date").value;
        var postContent=document.getElementById("post_content").value;
        var postImage=document.getElementById("post_image").value;
        if(postImage==""){
            postImage=document.getElementById("current_image").src;
            document.getElementById("postImage").src=postImage;
        }else{
            postImage=postImage.substring(12);
            document.getElementById("postImage").src="images/"+postImage;
        }
        document.getElementById("postTitle").innerHTML=postTitle;
        document.getElementById("postAuthor").innerHTML=postAuthor;
        document.getElementById("postDate").innerHTML=postDate;
        document.getElementById("postContent").innerHTML=postContent;
    }
    
</script>