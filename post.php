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

                    $view_query = "UPDATE posts SET post_views = post_views + 1 WHERE post_id = $selected_post_id";
                    $send_query = mysqli_query($connection, $view_query);

                    if(!$send_query) {
                        die("Query Failed" . mysqli_error($connection));
                    }

                    if(isAdmin()) {
                        $query = "SELECT * FROM posts WHERE post_id = {$selected_post_id}";
                    } else {
                        $query = "SELECT * FROM posts WHERE post_id = {$selected_post_id} AND post_status = 'published'";
                    }
                    $result = mysqli_query($connection, $query);

                    if(mysqli_num_rows($result) < 1) {
                        echo "<script>alert('Post Not Published')</script>";
                        redirect("index.php");
                    }


                    while($row = mysqli_fetch_assoc($result)) {
                        $post_title = escape($row['post_title']);
                        $post_user = escape($row['post_user']);
                        $post_date = escape($row['post_date']);
                        $post_image = escape($row['post_image']);
                        $post_content = escape($row['post_content']);
            ?>

            <h1 class="page-header">
                <?php echo $post_title ?>
            </h1>

            <!-- First Post -->
            <p class="lead">
                by <a
                    href="user_posts.php?user=<?php echo $post_user ?>&p_id=<?php echo $selected_post_id ?>"><?php echo $post_user ?></a>
            </p>
            <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
            <hr>
            <img class="img-responsive" src="img/<?php echo $post_image; ?>" alt="">
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

                       
                    } else {
                        echo "<script>alert('Fields Cannot Be Empty')</script>";
                    }
                }
            
            ?>

            <!-- Comments Form -->
            <div class="well">
                <h4>Leave a Comment:</h4>
                <form action="" method="post" role="form">
                    <div class="form-group">
                        <label for="Author">Author</label>
                        <input type="text" class="form-control" name="comment_author">
                    </div>
                    <div class="form-group">
                        <label for="Email">Email</label>
                        <input type="email" class="form-control" name="comment_email">
                    </div>
                    <div class="form-group">
                        <label for="comment">Your Comment</label>
                        <textarea class="form-control" name="comment_content" id="body" rows="3"></textarea>
                    </div>
                    <button id="add-post-btn" type="submit" name="create_comment"
                        class="btn btn-primary">Submit</button>
                </form>
            </div>

            <hr>

            <!-- Posted Comments -->

            <?php 
            
                $query = "SELECT * FROM comments WHERE comment_post_id = $selected_post_id AND comment_post_status = 'approved' ORDER BY comment_id DESC";
                $selected_comment_query = mysqli_query($connection, $query);

                if(!$selected_comment_query) {
                    die("QUERY FAILED" . mysqli_error($connection));
                }
                while($row = mysqli_fetch_array($selected_comment_query)) {
                    $comment_date = escape($row['comment_post_date']);
                    $comment_content = escape($row['comment_post_content']);
                    $comment_author = escape($row['comment_post_author']);
                
                
            ?>

            <!-- Comment -->
            <div class="media">
                <a class="pull-left" href="">
                    <img class="media-object" src="http://placehold.it/64x64" alt="">
                </a>
                <div class="media-body">
                    <h4 class="media-heading"><?php echo $comment_author ?>
                        <small><?php echo $comment_date ?></small>
                    </h4>
                    <?php echo $comment_content ?>
                </div>
            </div>

            <?php  
                }  
            } else {
                    redirect("index.php");
                }   
            ?>


        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"; ?>
        <!-- /.row -->

        <hr>

        <?php include "includes/footer.php"; ?>