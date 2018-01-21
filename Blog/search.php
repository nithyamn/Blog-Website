<!--SEARCH.php-->
<!DOCTYPE html>
<html lang="en">

<?php
    $title="Study Link | Search";
    include_once('includes/header.php');
    include_once('includes/db.php');
?>

<body>

    <!-- Navigation -->
       <?php include_once("includes/navigation.php"); ?>
    

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <h1 class="page-header">Search Results</h1>
                <!-- Checking for posts related to search results -->
                <?php
                    if(isset($_POST['submit'])){
                        $search = $_POST['search'];
                        $query = "select * from posts,users where users.user_id = posts.post_author and post_tags like '%$search%' and post_status='published'";//to find related tags not exact match
                        $search_query=mysqli_query($conn,$query);
                        if(!$search_query){
                            //error in db
                            die("Query failed: ".mysqli_error($conn));
                        }
                        //if me return aya then no else, else ke bahar jo hoga vahi execute hoga like else
                        $count = mysqli_num_rows($search_query);
                        if($count == 0)
                            echo "<h4>NO RESULTS FOUND</h4>";
                        else{
                            //if some results is found
                            while($row=mysqli_fetch_assoc($search_query)){
                                $post_id=$row['post_id'];
                                $post_title = $row['post_title'];
                                $post_author = $row['post_author'];
                                $post_date = $row['post_date'];
                                $post_image = $row['post_image'];
                                $post_content = substr($row['post_content'],0,200)."<b>...</b>";
                ?>
                
                <!-- START OF BLOG POST -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id;?>"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_author; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date;?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="<?php echo $post_title; ?>">
                <hr>
                <p><?php echo $post_content; ?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>
                <?php
                        }//end of while

                    }//end of else
                }//end of isset
                ?>
            
            </div><!--END OF BLOG POST-->
            

            <!-- Blog Sidebar Widgets Column -->
            <?php
                include_once("includes/sidebar.php");
            ?>

        </div>
       
        <!-- /.row -->

        <hr>

        <!-- Footer -->
       <?php include_once("includes/footer.php"); ?>
        <!--FOOTER ENDS -->

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
