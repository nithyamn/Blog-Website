<div class="col-xs-6">
<!--TO fetch category title according to the edit get request-->
    <?php
        editCategory();
        $edit_cat_title=fetchCategoryForEdit(); ?>    
    <?php
    //for hide and show of edit div
        if(isset($edit_cat_title)){
    ?>
    <h3>Edit Category</h3>
    <form action="" method="POST">
       <div class="form-group">
          <small><?php $error; ?></small>
           <label for="edit_cat_title">Category title</label>
            <input id="edit_cat_title" class="form-control" type="text" name="edit_cat_title" value=<?php echo $edit_cat_title; ?>>
        </div>
        <div class="form-group">
            <input class="btn btn-primary" type="submit" name="edit_submit" value="Edit Categories">
        </div>
    </form>
    <?php } ?>
</div>
                    