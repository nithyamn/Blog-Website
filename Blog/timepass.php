<!--Cookies-->
<?php
    setcookie("slstuds","nithya",time()+(86400*30),"/");//86300 means 1 day '/' incdiacteds it can be used in whole application
?>

<html>
    <head>
        
    </head>
    <body>
      <?php
        if(isset($_COOKIE['slstuds'])){
            echo "Cookie found and has value ".$_COOKIE['slstuds'];
        }
        else{
            echo "Not found";
        }
        ?>
       <?php
//        echo "<input style='display:none' type='text' name='name'>";
//                if(isset($_POST['submit'])){
//                    echo "<input style='display:block' type='text' name='name'>";
//                }
//                if(isset($_POST['click'])){
//                    echo "<input style='display:none' type='text' name='name'>";
//                }
            ?>
        
        <div name="check">
           
            <form method="post">
                <input type="submit" name="submit">
                <button name="click">Click</button>
            </form>
            
        </div>
    </body>
</html>
<!--Webcraller: to match content from any other site-->

