
<div class="col-xs-12">
    <table class="table table-bordered table-hover">
        <tr>
            <th>ID</th>
            <th>Category Title</th>
            <th></th>
            <th></th>
            
        </tr>
        <tbody>
        <?php
            $query="select * from categories";
            $select_all_categories_query=mysqli_query($conn,$query);
            while($row=mysqli_fetch_assoc($select_all_categories_query)){
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];
                //we passed id for delete from data-target of modal
                echo "<tr>";
                echo "<td>$cat_id</td>";
                echo "<td>$cat_title</td>";
                echo "<td><a class='btn btn-danger' data-toggle='modal' data-target='#$cat_id'><span class='fa fa-trash'></span></a></td>";
                echo "<td><a class='btn btn-primary' href='categories.php?edit=$cat_id'><span class='fa fa-pencil'></span></a></td>";
                echo "</tr>"; 
                //Modal
                echo "<div class='modal fade' id='$cat_id' role='dialog'>";
                echo "<div class='modal-dialog modal-sm'>";
                echo "<div class='modal-content'>";
                echo "<div class='modal-header'>";
                echo "<button type='button' class='close' data-dismiss='modal'>&times;</button>";
                echo "<h4 class='modal-body'>Are you sure you want to delete $cat_title?</h4>";
                echo "</div>";
                echo "<div class='modal-footer'>";
                echo "<a type='button' class='pull-left btn btn-warning' href='categories.php?delete=$cat_id'>Yes</a>";
                echo "<button type='button' class='btn btn-success' data-dismiss='modal'>No</button>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                //End of Modal
            }

            if(isset($_GET['delete'])){
                $delete_id=$_GET['delete'];
                $query="delete from categories where cat_id='$delete_id'";
                $delete_query=mysqli_query($conn,$query);
                header("Location: categories.php");
            }
        ?>
        </tbody>
    </table>
</div>