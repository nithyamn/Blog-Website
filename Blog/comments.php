 <!-- Blog Comments -->
<?php

    if(isset($_POST['create_comment'])){
        $comment_post_id=$_GET['p_id'];
        $comment_author=$_POST['comment_author'];
        $comment_email=$_POST['comment_email'];
        $comment_content=$_POST['comment_content'];
        if($comment_email && $comment_content){
            $query="insert into comments (comment_post_id,comment_author,comment_email,comment_content,comment_status,comment_date) values('$comment_post_id','$comment_author','$comment_email','$comment_content','unapproved',now())";
            $create_comment_query=mysqli_query($conn,$query);
            if(!$create_comment_query)
                die("Query Failed".mysqli_error($conn));
        }
        else{
            echo "Enter comments!";
        }
        $query="update posts set post_comment_count=post_comment_count+1 where post_id=$comment_post_id";
        $increment_comment_count=mysqli_query($conn,$query);
        header("Location: post.php?p_id=$comment_post_id");
    }
?>


<!-- Comments Form -->
<div class="well">
    <h4>Leave a Comment:</h4>
    <form role="form" action="" method="post">
       <div class="form-group">
           <label for="author">Author</label>
           <input type="text" name="comment_author" class="form-control" id="author">
       </div>
       <div class="form-group">
           <label for="email">Email</label>
           <input type="text" name="comment_email" class="form-control" id="email">
       </div>
       <div class="form-group">
           <label for="comment">Your Comment</label>
           <textarea id="comment" name="comment_content" class="form-control" rows="3"></textarea>
       </div>
        <button type="submit" class="btn btn-primary" name="create_comment">Submit</button>
    </form>
</div>
<!--End of Comment form-->
<hr>

<!-- Posted Comments -->

<?php
    $comment_post_id=$_GET['p_id'];
    $query="select * from comments where comment_post_id=$comment_post_id and comment_status='approved' order by comment_id desc";
    $select_all_comments=mysqli_query($conn,$query);
    while($row=mysqli_fetch_assoc($select_all_comments)){
        $comment_author=$row['comment_author'];
        $comment_date=$row['comment_date'];
        $comment_content=$row['comment_content'];
?>


<!-- Comment -->
<div class="media">
    <a class="pull-left" href="#">
        <img class="media-object" src="http://placehold.it/64x64" alt="">
    </a>
    <div class="media-body">
        <h4 class="media-heading"><?php echo $comment_author; ?>
            <small><?php echo $comment_date;?></small>
        </h4>
        <?php echo $comment_content; ?>
    </div>
</div>
<?php
    }//end of while
?>

