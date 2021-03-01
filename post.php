<!-- Database Connection -->
<?php include "includes/db.php"; ?>
<!-- Header -->
<?php include "includes/header.php"; ?>
<!-- Navigation -->
<?php include "includes/navigation.php"; ?>
<?php 

    //Post Likes Logic

    if(isset($_POST['liked'])) {
        $post_id = $_POST['postId'];
        $user_id = $_POST['userId'];

        //Fetch selected post

        $post_result = selectStatusQuery('posts', 'post_id', $post_id);
        $post = mysqli_fetch_array($post_result);
        $post_likes = $post['post_likes'];

        //Update post likes

        $update_likes_query = "UPDATE posts SET post_likes = $post_likes+1 WHERE post_id = $post_id";
        mysqli_query($connection, $update_likes_query);
        
        //Create likes in likes table

        $query = "INSERT INTO likes(user_id, post_id) VALUES($user_id, $post_id)";
        mysqli_query($connection, $query);
        exit();
    }

    //Post Unlike Logic
    if(isset($_POST['unliked'])) {
        $post_id = $_POST['postId'];
        $user_id = $_POST['userId'];

        //Fetch selected post

        $post_result = selectStatusQuery('posts', 'post_id', $post_id);
        $post = mysqli_fetch_array($post_result);
        $post_likes = $post['post_likes'];

        //Update post likes

        $update_likes_query = "UPDATE posts SET post_likes = $post_likes-1 WHERE post_id = $post_id";
        mysqli_query($connection, $update_likes_query);
        
        //Delete likes in likes table

        $delete_query = "DELETE FROM likes WHERE post_id = $post_id AND user_id = $user_id";
        mysqli_query($connection, $delete_query);
        exit();
    }

?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Restaurant Posts -->
        <div class="col-md-8">

            <?php 
            
                $published_message = '';
                if(isset($_GET['p_id'])) {
                    $selected_post_id = escape($_GET['p_id']);

                    //Update post views count
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

                    while($row = mysqli_fetch_assoc($result)) {
                        $post_title = escape($row['post_title']);
                        $post_title = stripslashes($post_title);
                        $post_restaurant_id = escape($row['post_restaurant_id']);
                        $post_author = stripslashes(escape($row['post_author']));
                        $post_date = date_create($row['post_date']);
                        $post_date = date_format($post_date, 'jS M Y');
                        $post_image = escape($row['post_image']);
                        $post_content = stripslashes(escape($row['post_content']));
                        $post_likes = escape($row['post_likes']);
                        $post_status = escape($row['post_status']);

                        if($post_status != 'published') {
                            $published_message = 'Draft';
                        }
            ?>

            <!-- Restaurant Post -->
            <h1 class="page-header">
                <?php echo $post_title ?>
                <small><?php echo $published_message ?></small>
            </h1>
            <p class="lead">
                <a href="author_posts.php?author=<?php echo $post_author ?>&p_id=<?php echo $selected_post_id ?>">-
                    <?php echo $post_author ?></a>
            </p>
            <p class="publish-date"><span class="glyphicon glyphicon-time"></span> Published <?php echo $post_date ?>
            </p>
            <hr>
            <img class="img-responsive" src="img/<?php echo imagePlaceholder($post_image); ?>" alt="">
            <hr>
            <p><?php echo $post_content ?></p>
            <?php 
                $select_restaurant = selectStatusQuery('restaurants', 'restaurant_id', $post_restaurant_id); 
                $row = mysqli_fetch_assoc($select_restaurant);
                $restaurant_title = escape($row['restaurant_title']);
                echo "<p><a href='restaurant.php?restaurant=$post_restaurant_id'>See all reviews on $restaurant_title</a></p>";
            ?>

            <hr>
            <?php if(isLoggedin()): ?>
            <div class="row like-section">
                <p class="pull-right m-r-15"><a
                        class="<?php echo userLikedPost($selected_post_id) ? 'unlike' : 'like' ?>" href=""><span
                            class="m-r-5 <?php echo userLikedPost($selected_post_id) ? 'glyphicon glyphicon-thumbs-down' : 'glyphicon glyphicon-thumbs-up' ?>"></span><?php echo userLikedPost($selected_post_id) ? 'Unlike' : 'Like' ?>
                    </a></p>
            </div>
            <?php else: ?>
            <div class="row like-section-message">
                <p class="pull-right m-r-15">You need to <a href="login.php">login</a> or <a
                        href="registration.php">register</a>
                    to like</p>
            </div>
            <?php endif; ?>
            <div class="row like-section">
                <p class="pull-right m-r-15">Likes: <?php echo $post_likes ?></p>
            </div>
            <div class="clearfix"></div>

            <?php 
                }          
            ?>

            <!-- Comments -->

            <?php 

                if(isLoggedIn()) {
                    $user = selectStatusQuery('users', 'username', $_SESSION['username']);
                    while($row = mysqli_fetch_assoc($user)) {
                        $comment_author = escape($row['username']);
                        $comment_email = escape($row['user_email']);
                    }
                            
                    if(isset($_POST['create_comment'])) {
                        $selected_comment_id = escape($_GET['p_id']);
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
                        <label for="comment">Your Comment</label>
                        <textarea class="form-control" name="comment_content" id="body" rows="3"></textarea>
                    </div>
                    <button id="add-post-btn" type="submit" name="create_comment" class="btn btn-1">Submit</button>
                </form>
            </div>


            <?php } else { ?>
            <div class="well">
                <h4>You must be <a href="login.php">Logged In</a> to leave a comment</h4>
            </div>
            <?php } ?>

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

        <script>
        $(document).ready(function() {
            let postId = <?php echo $selected_post_id ?>;
            let userId = <?php echo loggedInUserId(); ?>;

            //Like post functionality
            $('.like').click(function() {
                $.ajax({
                    url: "post.php?p_id=<?php echo $selected_post_id; ?>",
                    type: "post",
                    data: {
                        'liked': 1,
                        'postId': postId,
                        'userId': userId,
                    }
                })
            });

            //unline post
            $('.unlike').click(function() {
                $.ajax({
                    url: "post.php?p_id=<?php echo $selected_post_id; ?>",
                    type: "post",
                    data: {
                        'unliked': 1,
                        'postId': postId,
                        'userId': userId,
                    }
                })
            });
        });
        </script>