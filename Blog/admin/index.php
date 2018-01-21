<!--ADMIN-->
<!DOCTYPE html>
<html lang="en">
<?php
    $page="dashboard";
    include_once('includes/header.php');
    include_once('functions.php');
    
    $time_out=time()-60;
    $session=session_id();
    $query="select * from users_online where time > '$time_out' and session='$session'";
    $check_active_session=mysqli_query($conn,$query);
    if(mysqli_num_rows($check_active_session)==0){
        mysqli_query($conn,"delete from users_online where session='$session'");
        include_once("logout.php");
        die("<p style='color:white'>Successfully logged out!</p>");
    }
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
                    <!--yaha breadcrums tha!-->
                    </div>
                </div>
                <!-- /.row -->
                <?php include_once('includes/dashboard.php');?>
            </div>
            <!-- /.container-fluid -->
    
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    
    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <script src="js/scripts.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
