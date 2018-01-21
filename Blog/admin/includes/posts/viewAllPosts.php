<?php
if(isset($_POST['checkboxArray'])){
    $bulk_options=$_POST['bulk_options'];
    foreach($_POST['checkboxArray'] as $postValueId){
        switch($bulk_options){
            case 'published':
            case 'draft':
                $query="update posts set post_status = '$bulk_options' where post_id='$postValueId'";
                $update_to_status=mysqli_query($conn,$query);
                header("Location: posts.php");
                break;
            case 'delete':
                $query="delete from posts where post_id='$postValueId'";
                $delete_posts=mysqli_query($conn,$query);
                header("Location: posts.php");
                break;
            
        }
    }
}
?>
<div class="col-xs-12">
   <form action="" method="POST" class="form-group">
    <table class="table table-bordered table-hover">
      <div  class="col-xs-4" id="bulkOptionsContainer">
          <select name="bulk_options" id="" class="form-control">
              <option value="">Select Option</option>
              <option value="published">Publish</option>
              <option value="draft">Draft</option>
              <option value="delete">Delete</option>
          </select>
      </div>
      <div class="col-xs-4">
          <input type="submit" name="submit_bulk_options" class="btn btn-primary" value="Apply">
          <a class="btn btn-warning" href="posts.php?source=add_post">Add New</a>
      </div>
<!--
      <div  class="col-xs-4" id="postsPerPage">
          <select name="noOfPosts" id="" class="form-control">
              <option value="">Select Option</option>
              <option value="published">10</option>
              <option value="draft">Draft</option>
              <option value="delete">Delete</option>
          </select>
      </div>
-->
       <tr>
           <th><input class="form-control"type="checkbox" id="selectAllBoxes"></th>
            <th>ID</th>
            <th>Author</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Date</th>
           <th></th>
           <th></th>
        </tr>
     
        <tbody>
        <?php
            $user_role=$_SESSION['user_role'];
            if($user_role=="admin"){
                $query="select * from posts,users where posts.post_author=users.user_id order by posts.post_id DESC";   
            }else{
                $user_id=$_SESSION['user_id'];
                $query="select * from posts,users where posts.post_author=users.user_id and posts.post_author='$user_id' order by posts.post_id DESC";
            }
            $select_all_posts_query=mysqli_query($conn,$query);
            while($row=mysqli_fetch_assoc($select_all_posts_query)){
                $post_id = $row['post_id'];
                $post_author = $row['user_firstname']." ".$row['user_lastname'];
                $post_title=$row['post_title'];
                $post_category_id = $row['post_category_id'];
                $post_status = $row['post_status'];
                $post_image = $row['post_image'];
                $post_tags = $row['post_tags'];
                $post_comment_count = $row['post_comment_count'];
                $post_date = $row['post_date'];

                echo "<tr>";
                echo "<td><input class='checkBoxes' type='checkbox' name='checkboxArray[]' value='$post_id'></td>";
                echo "<td>$post_id</td>";
                echo "<td>$post_author</td>";
                echo "<td>$post_title</td>";
                //echo "<td>$post_category_id</td>";
                $query="select * from categories where cat_id=$post_category_id";
                $fetchQuery=mysqli_query($conn,$query);
                if($row=mysqli_fetch_assoc($fetchQuery)){
                    $post_category_title=$row['cat_title'];
                }
                echo "<td>$post_category_title</td>";
                echo "<td>$post_status</td>";
                echo "<td><img src='images/$post_image' alt='post image' height='80px'></td>";//class='img-responsive'
                echo "<td>$post_tags</td>";
                echo "<td>$post_comment_count</td>";
                echo "<td>$post_date</td>";
                 echo "<td><a class='btn btn-danger' data-toggle='modal' data-target='#$post_id'><span class='fa fa-trash'></span></a></td>";
                echo "<td><a class='btn btn-primary' href='posts.php?source=edit_post&p_id=$post_id'><span class='fa fa-pencil'></span></a></td>";
                echo "</tr>"; 
                //Modal
                echo "<div class='modal fade' id='$post_id' role='dialog'>";
                echo "<div class='modal-dialog modal-sm'>";
                echo "<div class='modal-content'>";
                echo "<div class='modal-header'>";
                echo "<button type='button' class='close' data-dismiss='modal'>&times;</button>";
                echo "<h4 class='modal-body'>Are you sure you want to delete $post_title?</h4>";
                echo "</div>";
                echo "<div class='modal-footer'>";
                echo "<a type='button' class='pull-left btn btn-warning' href='posts.php?delete=$post_id'>Yes</a>";
                echo "<button type='button' class='btn btn-success' data-dismiss='modal'>No</button>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                //End of Modal
            }
        ?>    
        </tbody>
    </table>
    </form>
    <?php
        if(isset($_GET['delete'])){
            $delete_post_id=$_GET['delete'];
            $query="delete from posts where post_id=($delete_post_id)";
            $delete_query=mysqli_query($conn,$query);
            confirmQuery($delete_query);
            header("Location: posts.php");
        }
    ?>
    
</div>