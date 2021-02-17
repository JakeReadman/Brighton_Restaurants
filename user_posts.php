<!-- Database Connection -->
<?php include "includes/db.php"; ?>
<!-- Header -->
<?php include "includes/header.php"; ?>
<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <?php 

                if(isset($_GET['p_id'])) {
                    $selected_post_id = escape($_GET['p_id']);
                    $selected_post_user = escape($_GET['user']);
                }

                echo "<h2 class='text-muted'>All Posts by {$selected_post_user}</h2>";

                $result = selectStatusQuery('posts', 'post_user', $selected_post_user);

                while($row = mysqli_fetch_assoc($result)) {
                    $post_title = escape($row['post_title']);
                    $post_user = escape($row['post_user']);
                    $post_date = escape($row['post_date']);
                    $post_image = escape($row['post_image']);
                    $post_content = escape($row['post_content']);
            ?>

            <!-- First Blog Post -->
            <h2>
                <a href="post.php?p_id=<?php echo $selected_post_id ?>"><?php echo $post_title ?></a>
            </h2>
            <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
            <hr>
            <img class="img-responsive" src="img/<?php echo $post_image; ?>" alt="">
            <hr>
            <p><?php echo $post_content ?></p>

            <hr>

            <?php 
                }
            ?>

            <!-- Blog Comments -->

            <?php 
            
                if(isset($_POST['create_comment'])) {
                    $selected_comment_id = escape($_GET['p_id']);
                    $comment_author = escape($_POST['comment_author']);
                    $comment_email = escape($_POST['comment_email']);
                    $comment_content = escape($_POST['comment_content']);

                    if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {

                        $query = "INSERT INTO comments (comment_post_id, comment_post_author, comment_post_email, comment_post_content, comment_post_status, comment_post_date)";
                        $query .= "VALUES ($selected_comment_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'Pending', now())";

                        $create_comment_query = mysqli_query($connection, $query);

                        if(!$create_comment_query) {
                            die('QUERY FAILED' . mysqli_error($connection));
                        }

                        $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE post_id = {$selected_comment_id}";
                        $update_comment_count = mysqli_query($connection, $query);
                    } else {
                        echo "<script>alert('Fields Cannot Be Empty')</script>";
                    }
                }
            
            ?>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"; ?>
        <!-- /.row -->

        <hr>

        <?php include "includes/footer.php"; ?>