<?php 

    if(isset($_GET['p_id'])) {
        $p_id = escape($_GET['p_id']);
    }

    $select_posts_by_id = selectStatusQuery('posts', 'post_id', $p_id);

    while($row = mysqli_fetch_assoc($select_posts_by_id)) {
        $post_id = $row['post_id'];
        $post_author = $row['post_author'];
        $post_title = $row['post_title'];
        $post_restaurant_id = $row['post_restaurant_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_content = $row['post_content'];
        $post_category = $row['post_category'];
        $post_comment_count = $row['post_comment_count'];
        $post_date = $row['post_date'];
    }

    if(isset($_POST['update_post'])) {
        $author_query = selectStatusQuery('authors', 'author_id', escape($_POST['author_id']));
        $row = mysqli_fetch_array($author_query);
        
        $post_author = escape($row['author_name']);
        $post_title = escape($_POST['post_title']);
        $post_restaurant_id = escape($_POST['post_restaurant']);
        $post_status = escape($_POST['post_status']);
        $post_image = $_FILES['image']['name'];
        $post_image_temp = $_FILES['image']['tmp_name'];
        $post_content = escape($_POST['post_content']);
        $post_category = escape($_POST['post_category']);

        move_uploaded_file($post_image_temp, "../img/$post_image");

        if(empty($post_image)) {
            $select_image = selectStatusQuery('posts', 'post_id', $p_id);

            while($row = mysqli_fetch_array($select_image)) {
                $post_image = escape($row['post_image']);
            }
        }
        // $post_author = htmlspecialchars($post_author);

        $query = "UPDATE posts SET ";
        $query .="post_title  = '{$post_title}', ";
        $query .="post_restaurant_id = '{$post_restaurant_id}', ";
        $query .="post_date   =  now(), ";
        $query .="post_author = '{$post_author}', ";
        $query .="post_status = '{$post_status}', ";
        $query .="post_category   = '{$post_category}', ";
        $query .="post_content= '{$post_content}', ";
        $query .="post_image  = '{$post_image}' ";
        $query .= "WHERE post_id = {$p_id} ";

        $update_post = mysqli_query($connection, $query);

        confirmQuery($update_post);

        echo "<p class='bg-success'>Post Updated. <a href='../post.php?p_id=$p_id'>View Post </a>or <a href='posts.php'>Go To Posts Dashboard</a></p>";

    }

?>

<form action="" method="post" enctype="multipart/form-data">


    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" value="<?php echo $post_title ?>" class="form-control" name="post_title">
    </div>

    <div class="form-group">
        <label for="restaurant">Restaurant</label>
        <select class="form-control" value="<?php echo $post_restaurant_id ?>" name="post_restaurant"
            id="post_restaurant">

            <?php 

                $select_restaurants = selectQuery('restaurants');

                confirmQuery($select_restaurants);
 
                while($row = mysqli_fetch_assoc($select_restaurants)) {
                    $restaurant_id = escape($row['restaurant_id']);
                    $restaurant_title = escape($row['restaurant_title']);

                    if($restaurant_id == $post_restaurant_id) {
                        echo "<option selected value='{$restaurant_id}'>{$restaurant_title}</option>";

                    } else {
                        echo "<option value='{$restaurant_id}'>{$restaurant_title}</option>";
                    }
                }
            ?>

        </select>

    </div>

    <div class="form-group">
        <label for="authors">Author</label>
        <select class="form-control" name="author_id" id="">
            <?php 
        
                $select_authors = selectQuery('authors');
                
                while($row = mysqli_fetch_assoc($select_authors)) {
                    $author_id = escape($row['author_id']);
                    $author_name = stripslashes($row['author_name']);
                    
                    if($author_name == $post_author) {
                        echo "<option selected value='{$author_id}'>{$author_name}</option>";

                    } else {
                        echo "<option value='{$author_id}'>{$author_name}</option>";
                    }
                }
            
            ?>

        </select>
    </div>

    <div class="form-group">
        <label for="post_status">Status</label>
        <select class="form-control" name="post_status" id="post_status">
            <option value='<?php echo $post_status ?>'><?php echo ucfirst($post_status) ?></option>

            <?php 
            
                 if($post_status === 'published') {
                    echo "<option value='draft'>Draft</option>";
                 } else {
                     echo "<option value='published'>Publish</option>";
                 }
            
            ?>

        </select>
    </div>

    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image">
        <img class="form-control-static" src="../img/<?php echo $post_image ?>" alt="post image" width="100px">
    </div>

    <div class="form-group">
        <label for="post_category">Post Category</label>
        <input type="text" value="<?php echo $post_category ?>" class="form-control" name="post_category">
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name="post_content" id="body" cols="30" rows="10"><?php echo $post_content ?>
         </textarea>
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
    </div>

</form>