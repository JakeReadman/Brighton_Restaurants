<?php

    if(isset($_POST['create_post'])) {
        $author_query = selectStatusQuery('authors', 'author_id', escape($_POST['author_id']));
        $row = mysqli_fetch_array($author_query);
        
        $post_author = escape($row['author_name']);
        $post_title = stripslashes(escape($_POST['title']));
        $post_restaurant_id = escape($_POST['post_restaurant']);
        $post_status = escape($_POST['post_status']);
        $post_image = $_FILES['image']['name'];
        $post_image_temp = $_FILES['image']['tmp_name'];
        $post_category = escape($_POST['post_category']);
        $post_content = escape($_POST['post_content']);
        $post_date = escape($_POST['post_date']);

        move_uploaded_file($post_image_temp, "../img/$post_image");
        
        $query = "INSERT INTO posts(post_restaurant_id, post_title, post_author, post_date, post_image, post_content, post_category, post_status) VALUES({$post_restaurant_id},'{$post_title}','{$post_author}',now(),'{$post_image}','{$post_content}','{$post_category}', '{$post_status}') "; 
             
      $create_post_query = mysqli_query($connection, $query);  
          
      confirmQuery($create_post_query);

      $current_post_id = mysqli_insert_id($connection);


      echo "<p class='bg-success'>Post Created. <a href='../post.php?p_id={$current_post_id}'>View Post </a> or <a href='posts.php'>View Post Dashboard</a></p>";
    }

?>


<form action="" method="post" enctype="multipart/form-data">


    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title">
    </div>

    <div class="form-group">
        <label for="restaurant">Restaurant</label>
        <select class="form-control" name="post_restaurant" id="">
            <option value="">Select Restaurant</option>

            <?php 
        
            $select_restaurants = selectQuery('restaurants');
            
            while($row = mysqli_fetch_assoc($select_restaurants )) {
            $restaurant_id = escape($row['restaurant_id']);
            $restaurant_title = escape($row['restaurant_title']);
                    
                echo "<option value='$restaurant_id'>{$restaurant_title}</option>";
                   
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
                    
                    echo "<option value='{$author_id}'>{$author_name}</option>";
                    
                }
            
            ?>

        </select>
    </div>

    <div class="form-group">
        <label for="post_status">Post Status</label>
        <select class="form-control" name="post_status" id="">
            <option value="draft">Post Status</option>
            <option value="published">Published</option>
            <option value="draft">Draft</option>
        </select>
    </div>

    <div class="form-group">
        <label for="post_date">Date</label>
        <div class='input-group date'>
            <input type='date' class="form-control" name="post_date" />
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
    </div>


    <div class="form-group">
        <label for="post_image">Image</label>
        <input class="form-control" type="file" name="image">
    </div>

    <div class="form-group">
        <label for="post_category">Post Category</label>
        <input type="text" class="form-control" name="post_category">
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name="post_content" id="body">
         </textarea>
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
    </div>


</form>