<!-- Database Connection -->
<!-- Header -->
<?php include "includes/header.php"; ?>
<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="post-content col-md-8">

            <?php 

                if(isset($_GET['p_id'])) {
                    $selected_post_id = escape($_GET['p_id']);
                    $selected_post_author = escape($_GET['author']);
                    $stripslash_author = stripslashes($selected_post_author);
                }

                echo "<h2 class='text-muted'>All Posts by {$stripslash_author}</h2>";

                $result = selectStatusQuery('posts', 'post_author', $selected_post_author);

                while($row = mysqli_fetch_assoc($result)) {
                    $post_title = stripslashes(escape($row['post_title']));
                    $post_author = stripslashes(escape($row['post_author']));
                    $post_date = date_create($row['post_date']);
                    $post_date = date_format($post_date, 'jS M Y');
                    $post_image = escape($row['post_image']);
                    $post_content = stripslashes(escape($row['post_content']));
            ?>

            <!-- First Blog Post -->
            <h2>
                <a href="post.php?p_id=<?php echo $selected_post_id ?>"><?php echo $post_title ?></a>
            </h2>
            <p><span class="glyphicon glyphicon-time"></span> Published <?php echo $post_date ?></p>
            <hr>
            <img class="img-responsive" src="img/<?php echo imagePlaceholder($post_image); ?>" alt="">
            <hr>
            <p><?php echo $post_content ?></p>

            <hr>

            <?php 
                }
            ?>

            <!-- Comments -->

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