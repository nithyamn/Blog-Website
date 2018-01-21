<div class="col-xs-12">
    <table class="table table-bordered table-hover">
       <tr>
            <th>ID</th>
            <th>Author</th>
            <th>Comment</th>
            <th>Email</th>
            <th>Status</th>
            <th>In response to</th>
            <th>Date</th>
            <th>Approve</th>
            <th>Unapprove</th>
            <th>Delete</th>
        </tr>
       
        <tbody>
        <?php
            $user_role=$_SESSION['user_role'];
            if($user_role=="admin"){
                 $query="select * from comments";   
            }else{
                $user_id=$_SESSION['user_id'];
                $query="select * from comments where comment_post_id in (select posts.post_id from posts where post_author=$user_id)";
            }
            $select_all_comments_query=mysqli_query($conn,$query);
            while($row=mysqli_fetch_assoc($select_all_comments_query)){
                $comment_id = $row['comment_id'];
                $comment_post_id=$row['comment_post_id'];
                $comment_author = $row['comment_author'];
                $comment_content=$row['comment_content'];
                $comment_email= $row['comment_email'];
                $comment_status = $row['comment_status'];
                $comment_date = $row['comment_date'];
    
                echo "<tr>";
                echo "<td>$comment_id</td>";
                echo "<td>$comment_author</td>";
                echo "<td>$comment_content</td>";
                echo "<td>$comment_email</td>";
                echo "<td>$comment_status</td>";
                $query="select * from posts where post_id=$comment_post_id";
                $select_comment_query=mysqli_query($conn,$query);
                $row=mysqli_fetch_assoc($select_comment_query);
                    $comment_post_title=$row['post_title'];
                echo "<td><a href='../post.php?p_id=$comment_post_id'>$comment_post_title</a></td>";
                echo "<td>$comment_date</td>";
                echo "<td><a class='btn btn-success' href='comments.php?approve=$comment_id'><span class='fa fa-check-circle'></span></a></td>";
                echo "<td><a class='btn btn-warning' href='comments.php?unapprove=$comment_id'><span class='fa fa-times-circle'></span></a></td>";
                echo "<td><a class='btn btn-danger' href='comments.php?delete=$comment_id'><span class='fa fa-trash'></span></a></td>";
                echo "</tr>";
            }
        ?>    
        </tbody>
    </table>
    <?php
        
        if(isset($_GET['approve'])){
            $approve_comment_id=$_GET['approve'];
            $query="update comments set comment_status='approved' where comment_id=$approve_comment_id";
            $approve_query=mysqli_query($conn,$query);
            confirmQuery($approve_query);
            header("Location: comments.php");
        }
        
        if(isset($_GET['unapprove'])){
            $unapprove_comment_id=$_GET['unapprove'];
            $query="update comments set comment_status='unapproved' where comment_id=$unapprove_comment_id";
            $unapprove_query=mysqli_query($conn,$query);
            confirmQuery($unapprove_query);
            header("Location: comments.php");
        }
    
        if(isset($_GET['delete'])){
            $delete_comment_id=$_GET['delete'];
            $query="update posts set post_comment_count=post_comment_count-1 where post_id=(select comment_post_id from comments where comment_id=$delete_comment_id)";
            $update_comment_count_query=mysqli_query($conn,$query);
            $query="delete from comments where comment_id=($delete_comment_id)";
            $delete_query=mysqli_query($conn,$query);
            confirmQuery($delete_query);
            header("Location: comments.php");
        }
    ?>
    
</div>