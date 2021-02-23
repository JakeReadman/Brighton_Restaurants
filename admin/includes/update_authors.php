<form action="" method="POST">
    <div class="form-group">
        <label for="author-name">Update Author</label>

        <?php 

            if(isset($_GET['edit'])) {
                $author_id = escape($_GET['edit']);
                $select_author_id = selectStatusQuery('authors', 'author_id', $author_id);

                while($row = mysqli_fetch_assoc($select_author_id)) {
                    $author_id = escape($row['author_id']);
                    $author_name = escape($row['author_name']);
                                        
            ?>

        <input value="<?php if(isset($author_name)){ echo $author_name; } ?>" class="form-control" type="text"
            name="author_name">

        <?php }
                }
            ?>
        <?php 

            // Update query
            if(isset($_POST['update_author'])) {
                $update_author_name = escape($_POST['author_name']);
                $query = "UPDATE authors SET author_name = '{$update_author_name}' WHERE author_id = '{$author_id}'";
                $update_query = mysqli_query($connection, $query);
                    if(!$update_query){
                        die("query failed" . mysqli_error($connection));
                        redirect("authors.php");
                    } else {
                        redirect("authors.php");
                    }
            }

        ?>


    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_author" value="Update Author">
    </div>
</form>