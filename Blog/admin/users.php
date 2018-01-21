<!--ADMIN-->
<!DOCTYPE html>
<?php
ob_start();//adding the multiple entries while refreshing
?>
<html lang="en">
<?php
    $page="users";
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
                    <!--VIEW ALL POSTS SECTION-->
                        <?php 
                            $source="";
                            //this is for conditional routing
                            if(isset($_GET['source'])){
                                $source=$_GET['source'];
                            }
                            switch($source){
                                case 'add_user':
                                    include_once('includes/users/addUser.php');
                                    break;
                                case 'edit_user':
                                    include_once('includes/users/editUser.php');
                                    break;
                                case 'view_online_users':
                                    include_once('includes/users/viewOnlineUsers.php');
                                    break;
                                default:
                                    include_once('includes/users/viewAllUsers.php');
                                    break;
                            }
                        ?>
                    <!--END VIEW ALL POSTS SECTION-->
                    </div>
                    
                </div>
                <!-- /.rowr -->

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
