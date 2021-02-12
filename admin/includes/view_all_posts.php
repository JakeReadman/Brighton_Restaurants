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
                    $query = "SELECT * FROM posts WHERE post_id = {$checkBox_post_id}";
                    $select_post_query = mysqli_query($connection, $query);
                
                    while($row = mysqli_fetch_assoc($select_post_query)) {
                        $post_title = escape($row['post_title']);
                        $post_category_id = escape($row['post_category_id']);
                        $post_date = escape($row['post_date']);
                        $post_author = escape($row['post_author']);
                        $post_user = escape($row['post_user']);
                        $post_status = escape($row['post_status']);
                        $post_image = escape($row['post_image']);
                        $post_tags = escape($row['post_tags']);
                        $post_content = escape($row['post_content']);

                    }

                    $new_query = "INSERT INTO posts(post_category_id, post_title, post_author, post_user post_date, post_image, post_content, post_tags, post_status) VALUES({$post_category_id},'{$post_title}','{$post_author}','{$post_user}', now(),'{$post_image}','{$post_content}','{$post_tags}', '{$post_status}') "; 

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
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
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
                $post_user = escape($row['post_user']);
                $post_title = escape($row['post_title']);
                $post_category_id = escape($row['post_category_id']);
                $post_status = escape($row['post_status']);
                $post_image = escape($row['post_image']);
                $post_tags = escape($row['post_tags']);
                $post_views = escape($row['post_views']);
                $post_date = escape($row['post_date']);

                echo "<tr>";
                echo "<td><input type='checkbox' class='checkBoxes' name='checkBoxArray[]' value='$post_id'></td>";
                echo "<td>{$post_id}</td>";

                if(!empty($post_author)) {
                    echo "<td>{$post_author}</td>";
                } elseif(!empty($post_user)) {
                    echo "<td>{$post_user}</td>";
                }

                echo "<td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>";

                $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id}";
                $select_categories_id = mysqli_query($connection, $query);

                while($row = mysqli_fetch_assoc($select_categories_id)) {
                    $cat_id = escape($row['cat_id']);
                    $cat_title = escape($row['cat_title']);
                    
                    echo "<td>{$cat_title}</td>";
                }


                echo "<td>{$post_status}</td>";
                echo "<td><img width='100px' class='img-responsive' src='../img/{$post_image}' alt='Post Image'</td>";
                echo "<td>{$post_tags}</td>";

                $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                $send_comment_query = mysqli_query($connection, $query);

                $row = mysqli_fetch_array($send_comment_query);

                $post_comment_count = mysqli_num_rows($send_comment_query);

                echo "<td><a href='post_comments.php?id=$post_id'>{$post_comment_count}</a></td>";
                echo "<td>{$post_views}</td>";
                echo "<td>{$post_date}</td>";
                echo "<td><a class='btn btn-warning' href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
                echo "<td><a rel='$post_id' class='delete-link btn btn-danger' href='javascript:void(0)'>Delete</a></td>";
                // echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete?');\" class='btn btn-danger' href='posts.php?delete={$post_id}'>Delete</a></td>";
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
        header("location:posts.php");
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