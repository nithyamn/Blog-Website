<!--ADMIN-->
<!DOCTYPE html>
<?php
ob_start();//adding the multiple entries while refreshing
?>
<html lang="en">
<?php
    $page="categories";
    include_once('includes/header.php');
    include_once('functions.php');
?>
<body>
  
    <div id="wrapper">

        <!--Navigation -->
        <?php
            include_once('includes/navigation.php');
        ?>
        <!--End of navigation-->

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to CPanel
                            <small><?php echo $username;?></small>
                        </h1>
                        <!--Add Category-->
                        <?php include_once('includes/category/addCategory.php'); ?>
                        <!--End of Add categories-->
                        
                        <!--Edit Category-->
                        <?php include_once('includes/category/editCategory.php'); ?>
                        <!--End of edit categories-->
                        
                        <!--Inserted categories-->
                        <!--This file also has delete ka code-->
                        <?php include_once('includes/category/viewCategories.php'); ?>
                    <!--yaha breadcrums tha!-->
                    </div>
                    
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
</body>

</html>
