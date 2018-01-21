<div class="col-xs-12">
    <table class="table table-bordered table-hover">
       <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Role</th>
            <th>Image</th>
            <th>Make Admin</th>
           <th>Make Subscriber</th>
           <th>Edit</th>
           <th>Delete</th>
        </tr>
       
        <tbody>
        <?php
            $query="select * from users";
            $select_all_users_query=mysqli_query($conn,$query);
            while($row=mysqli_fetch_assoc($select_all_users_query)){
                $user_id = $row['user_id'];
                $username = $row['username'];
                $user_firstname = $row['user_firstname'];
                $user_lastname = $row['user_lastname'];
                $user_email = $row['user_email'];
                $user_role = $row['user_role'];
                $user_image = $row['user_image'];
                echo "<tr>";
                echo "<td>$user_id</td>";
                echo "<td>$username</td>";
                echo "<td>$user_firstname</td>";
                echo "<td>$user_lastname</td>";
                echo "<td>$user_email</td>";
                echo "<td>$user_role</td>";
                echo "<td><img src='images/users/$user_image' alt='$username' height='100px' width='100px' class='img-rounded'></td>";
                
                echo "<td><a class='btn btn-success' href='users.php?make_admin=$user_id'><span class='fa fa-user'></span></a></td>";
                echo "<td><a class='btn btn-warning' href='users.php?make_subscriber=$user_id'><span class='fa fa-users'></span></a></td>";
                 echo "<td><a class='btn btn-primary' href='users.php?source=edit_user&edit_id=$user_id'><span class='fa fa-pencil'></span></a></td>";
                echo "<td><a class='btn btn-danger' href='users.php?delete=$user_id'><span class='fa fa-trash'></span></a></td>";
                echo "</tr>";
            }
        ?>    
        </tbody>
    </table>
    
    <?php
        if(isset($_GET['make_admin'])){
            $make_admin_id=$_GET['make_admin'];
            $query="update users set user_role='admin' where user_id=$make_admin_id";
            $make_admin_query=mysqli_query($conn,$query);
            confirmQuery($make_admin_query);
            header("Location: users.php");
        }
        
        if(isset($_GET['make_subscriber'])){
            $make_subscriber_id=$_GET['make_subscriber'];
            $query="update users set user_role='subscriber' where user_id=$make_subscriber_id";
            $make_subscriber_query=mysqli_query($conn,$query);
            confirmQuery($make_subscriber_query);
            header("Location: users.php");
        }
    
        if(isset($_GET['delete'])){
            $delete_user_id=$_GET['delete'];
            $query="delete from users where user_id=($delete_user_id)";
            $delete_query=mysqli_query($conn,$query);
            confirmQuery($delete_query);
            header("Location: users.php");
        }
    ?>
    
</div>