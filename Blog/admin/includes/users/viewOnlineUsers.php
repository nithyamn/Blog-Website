<div class="col-xs-12">
    <table class="table table-bordered table-hover">
       <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Name</th>
            <th>Role</th>
           <th>Time</th>
           <th>Session</th>
        </tr>
       
        <tbody>
        <?php
            $time_out=time()-60;
            $query="select * from users,users_online where users.user_id=users_online.user_id and time > $time_out";
            $online_users=mysqli_query($conn,$query);
            while($row=mysqli_fetch_assoc($online_users)){
                $user_id=$row['user_id'];
                $username=$row['username'];
                $name=$row['user_firstname']." ".$row['user_lastname'];
                $role=$row['user_role'];
                $time=date("d-m-Y h:i:sa",$row['time']);
                $session=$row['session'];
                echo "<td>$user_id</td>";
                echo "<td>$username</td>";
                echo "<td>$name</td>";
                echo "<td>$role</td>";
                echo "<td>$time</td>";
                echo "<td>$session</td>";
                echo "</tr>";
            }
        ?>    
        </tbody>
    </table>
    
</div>