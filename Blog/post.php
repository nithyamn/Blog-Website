<!DOCTYPE html>
<html lang="en">
<?php
    ob_start(); 
    $title="Individual Posts";
    session_start();
    include_once('includes/header.php');
    include_once('includes/db.php');
    //include_once('admin/functions.php');
?>

<body>

    <!-- Navigation -->
    <?php include_once('includes/navigation.php');?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Post Content Column -->
            <div class="col-lg-8">

                <!-- Blog Post -->
                <?php
                    if(isset($_GET['p_id'])){
                        $post_id=$_GET['p_id'];
                         $query="select * from posts,users where posts.post_author = users.user_id and posts.post_id=$post_id";
                        
                        $select_all_posts_query=mysqli_query($conn,$query); 
                        if($row=mysqli_fetch_assoc($select_all_posts_query)){
                        
                        $post_title = $row['post_title'];
                        $post_author = $row['user_firstname']." ".$row['user_lastname'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];
                        $post_author_id=$row['post_author'];
                    
                ?>

                <!-- Title -->
                <h1><?php echo $post_title;?></h1>
                
                <!-- Author -->
                <p class="lead">
                    by <a href="#"><?php echo $post_author;?>
                        <?php
                            if(isset($_SESSION['user_id'])){
                                $user_id=$_SESSION['user_id'];
                                if($user_id == $post_author_id){
                        ?>
                        <a class="fa fa-pencil btn btn-warning" href="admin/posts.php?source=edit_post&p_id=<?php echo $post_id;?>">Edit Post</a>
                        <?php
                                }
                            }
                        ?>
                    </a>
                </p>
                
                <hr>

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date;?></p>

                <hr>

                <!-- Preview Image -->
                <img class="img-responsive" src="images/<?php echo $post_image;?>" alt="<?php echo $post_title;?>" width="400px" height="400px">

                <hr>

                <!-- Post Content -->
                <p class="lead"><?php echo $post_content;?></p>

                <hr>
                <!--BLOG COMMENTS-->
                
                <!--End of Blog Comments-->
               <?php
                        }//if closed
                    }//isset closed
                    include_once('comments.php');
                ?>
            </div>

            <!-- Blog Sidebar Widgets Column -->
              <?php include_once('includes/sidebar.php');?>

        </div>
       
        <!-- /.row -->

        <hr>

        <!-- Footer -->
       <?php include_once('includes/footer.php');?>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
