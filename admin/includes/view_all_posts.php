<?php 

    include "delete_modal.php";

    if(isset($_POST['checkBoxArray'])) {
        foreach($_POST['checkBoxArray'] as $checkBox_post_id) {
            $bulk_options = escape($_POST['bulk_options']);
            switch($bulk_options) {
                case 'published':
                    $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$checkBox_post_id}";
                    $update_post_status = mysqli_query($connection, $query);
                    confirmQuery($update_post_status);
                    break;

                case 'draft':
                    $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$checkBox_post_id}";
                    $update_post_status = mysqli_query($connection, $query);
                    confirmQuery($update_post_status);
                    break;

                case 'delete':
                    $query = "DELETE FROM posts WHERE post_id = {$checkBox_post_id}";
                    $update_post_status = mysqli_query($connection, $query);
                    confirmQuery($update_post_status);
                    break;

                case 'clone':
                    $select_post_query = selectStatusQuery('posts', 'post_id', $checkBox_post_id);
                
                    while($row = mysqli_fetch_assoc($select_post_query)) {
                        $post_title = escape($row['post_title']);
                        $post_restaurant_id = escape($row['post_restaurant_id']);
                        $post_date = escape($row['post_date']);
                        $post_author = escape($row['post_author']);
                        $post_status = escape($row['post_status']);
                        $post_image = escape($row['post_image']);
                        $post_category = escape($row['post_category']);
                        $post_content = escape($row['post_content']);

                    }

                    $new_query = "INSERT INTO posts(post_restaurant_id, post_title, post_author, post_date, post_image, post_content, post_category, post_status) VALUES({$post_restaurant_id},'{$post_title}','{$post_author}', now(),'{$post_image}','{$post_content}','{$post_category}', '{$post_status}') "; 

                    $update_post_status = mysqli_query($connection, $new_query);
                    confirmQuery($update_post_status);
                    break;
            }
        }
    }

?>

<form action="" method="POST">

    <table class="table table-bordered table-hover">

        <div id="bulkOptionsContainer" class="col-xs-4 form-group">
            <select class="form-control" name="bulk_options" id="">
                <option value="">Select Options</option>
                <option value="published">Publish</option>
                <option value="draft">Draft</option>
                <option value="clone">Clone</option>
                <option value="delete">Delete</option>
            </select>

        </div>

        <div class="col-xs-4 form-group">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
        </div>

        <thead>
            <tr>
                <th><input type="checkbox" name="" id="selectAllBoxes"></th>
                <th>Id</th>
                <th>Author</th>
                <th>Title</th>
                <th>Restaurant</th>
                <th>Status</th>
                <th>Image</th>
                <th>Category</th>
                <th>Comments</th>
                <th>Views</th>
                <th>Date</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>

            <?php
                        
            $query = "SELECT * FROM posts ORDER BY post_id DESC";
            $select_posts = mysqli_query($connection, $query);
        
            while($row = mysqli_fetch_assoc($select_posts)) {
                $post_id = escape($row['post_id']);
                $post_author = stripslashes(escape($row['post_author']));
                $post_title = escape($row['post_title']);
                $post_restaurant_id = escape($row['post_restaurant_id']);
                $post_status = escape($row['post_status']);
                $post_image = escape($row['post_image']);
                $post_category = escape($row['post_category']);
                $post_views = escape($row['post_views']);
                $post_date = escape($row['post_date']);

                echo "<tr>";
                echo "<td><input type='checkbox' class='checkBoxes' name='checkBoxArray[]' value='$post_id'></td>";
                echo "<td>{$post_id}</td>";
                echo "<td>{$post_author}</td>";

                echo "<td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>";

                $select_restaurants_id = selectStatusQuery('restaurants', 'restaurant_id', $post_restaurant_id);

                while($row = mysqli_fetch_assoc($select_restaurants_id)) {
                    $restaurant_id = escape($row['restaurant_id']);
                    $restaurant_title = escape($row['restaurant_title']);
                    
                    echo "<td>{$restaurant_title}</td>";
                }


                echo "<td>{$post_status}</td>";
                echo "<td><img width='100px' class='img-responsive' src='../img/{$post_image}' alt='Post Image'</td>";
                echo "<td>{$post_category}</td>";

                $send_comment_query = selectStatusQuery('comments', 'comment_post_id', $post_id);

                $row = mysqli_fetch_array($send_comment_query);

                $post_comment_count = mysqli_num_rows($send_comment_query);

                echo "<td><a href='post_comments.php?id=$post_id'>{$post_comment_count}</a></td>";
                echo "<td>{$post_views}</td>";
                echo "<td>{$post_date}</td>";
                echo "<td><a class='btn btn-warning' href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
                echo "<td><a rel='$post_id' class='delete-link btn btn-danger' href='javascript:void(0)'>Delete</a></td>";
                echo "</tr>";
        
            }
            
        ?>

        </tbody>
    </table>
</form>

<?php 

    if(isset($_GET['delete'])) {
        $delete_post_id = escape($_GET['delete']);

        $query = "DELETE FROM posts WHERE post_id = $delete_post_id";

        $delete_query = mysqli_query($connection, $query);
        redirect("posts.php");
    }

?>

<script>
$(document).ready(function() {
    $(".delete-link").on('click', function() {
        let id = $(this).attr("rel");
        let delete_url = `posts.php?delete=${id}`;
        $(".modal-delete-link").attr("href", delete_url);
        $("#myModal").modal('show');
    })
});
</script>