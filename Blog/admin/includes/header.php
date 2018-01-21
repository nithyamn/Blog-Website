<?php
    include("../includes/db.php");
    session_start();
    include_once("functions.php");
    checkUserSession();
?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Bootstrap Admin Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!--Froala editor for text area of add posts-->
    <link href="js/plugins/froala/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css">
    <link href="js/plugins/froala/css/froala_style.min.css" rel="stylesheet" type="text/css">
    <!--Bootstrap validtor-->
    <link href="css/bootstrapValidator.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
        <?php
        $username = checkUser();
        $user_role = $_SESSION['user_role'];
        $user_id = $_SESSION['user_id'];
//        echo $page;
        if($page == "dashboard"){    
            if($user_role == 'admin'){
                $post_query = "select * from posts";
                $active_post_query = "select * from posts where post_status='published'";
                $pending_posts_query = "select * from posts where post_status='draft'";
                
                $approved_comment_query = "select * from comments where comment_status='approved'";

                $unapproved_comment_query = "select * from comments where comment_status='unapproved'";    
            }else{

                $post_query = "select * from posts where post_author = '$user_id'";
                $active_post_query = "select * from posts where post_status='published' and post_author='$user_id'";
                $pending_posts_query = "select * from posts where post_status='draft' and post_author='$user_id'";
                
                $approved_comment_query = "select * from comments where comment_post_id in (select post_id from posts where post_author = '$user_id') and comment_status='approved'";

                $unapproved_comment_query = "select * from comments where comment_post_id in (select post_id from posts where post_author = '$user_id') and comment_status='unapproved'";
            }
            #$active_post_query = "select * from posts where post_status='published'";
            $active_post_query_resultset = mysqli_query($conn,$active_post_query);
            $active_post = mysqli_num_rows($active_post_query_resultset);
            
            #$pending_posts_query = "select * from posts where post_status='draft'";
            $pending_post_query_resultset = mysqli_query($conn,$pending_posts_query);
            $pending_posts = mysqli_num_rows($pending_post_query_resultset);
            
            $categories_query = "select * from categories";
            
            $users_query = "select * from users";

            $post_count_query = mysqli_query($conn,$post_query);
            $post_count = mysqli_num_rows($post_count_query);

            $approved_comment_result = mysqli_query($conn,$approved_comment_query);
            $approved_comment_count = mysqli_num_rows($approved_comment_result);

            $unapproved_comment_result = mysqli_query($conn,$unapproved_comment_query);
            $unapproved_comment_count = mysqli_num_rows($unapproved_comment_result);

            $categories_query_result = mysqli_query($conn,$categories_query);
            $category_count = mysqli_num_rows($categories_query_result);
            
            $users_query_resultset = mysqli_query($conn,$users_query);
            $users_count = mysqli_num_rows($users_query_resultset);
            
            #grouping posts by category
            $post_category_query = "select count(*) as count_cat ,cat_title from posts,categories where posts.post_category_id=categories.cat_id and posts.post_status='published' group by categories.cat_id";
            $count_post_cat_resultselt = mysqli_query($conn,$post_category_query);
            
    ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
    <!-- START OF COLUMN CHART-->
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Count'],
        <?php
            $element_text=['active posts','pending posts','categories','users','comments','pending comments'];
            $element_count=[$active_post,$pending_posts,$category_count,$users_count,$approved_comment_count,$unapproved_comment_count];
            
            for($i=0 ; $i<6 ; $i++){
                echo "['$element_text[$i]',$element_count[$i]],";
            }
        ?>]);

        var options = {
          chart: {
            title: '',
            subtitle: '',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
    <!-- END OF COLUMN CHART-->
      
<!--     START OF PIE CHART  -->
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Category', 'No. Of Posts'],
        <?php
            while($row = mysqli_fetch_assoc($count_post_cat_resultselt)){
                $cat_title = $row['cat_title'];
                $count_posts = $row['count_cat'];
                
                echo "['$cat_title',$count_posts], ";
            }
        
        ?>]);

        var options = {
          title: 'My Daily Activities',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>
    <!-- START OF PIE CHART-->  
    <?php
        }else if($page=="posts"){
    ?>
    <script src="js/jquery.js"></script>
    <script src="js/plugins/froala/js/froala_editor.pkgd.min.js"></script>
    <script>
        $(function(){
            $('textarea').froalaEditor()
        });
    </script>
    <?php }//else if closed ?>
</head>