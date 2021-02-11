<form action="" method="POST">
    <div class="form-group">
        <label for="cat-title">Update Category</label>

        <?php 

            if(isset($_GET['edit'])) {
                $cat_id = escape($_GET['edit']);
                $query = "SELECT * FROM categories WHERE cat_id = $cat_id";
                $select_categories_id = mysqli_query($connection, $query);

                while($row = mysqli_fetch_assoc($select_categories_id)) {
                    $cat_id = escape($row['cat_id']);
                    $cat_title = escape($row['cat_title']);
                

            
                    
            ?>
        <input value="<?php if(isset($cat_title)){ echo $cat_title; } ?>" class="form-control" type="text"
            name="cat_title">

        <?php }
                }
            ?>
        <?php 

            // Update query
            if(isset($_POST['update_category'])) {
                $update_cat_title = escape($_POST['cat_title']);
                $query = "UPDATE categories SET cat_title = '{$update_cat_title}' WHERE cat_id = '{$cat_id}'";
                $update_query = mysqli_query($connection, $query);
                    if(!$update_query){
                     die("query failed" . mysqli_error($connection));
                header("location: categories.php");
                    } else {
                        header("location: categories.php");
                    }
            }


                                ?>


    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_category" value="Update Category">
    </div>
</form>