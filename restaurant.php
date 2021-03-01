<!-- Database Connection -->
<?php include "includes/db.php"; ?>
<!-- Header -->
<?php include "includes/header.php"; ?>
<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Restaurant Entries Column -->
        <div class="col-md-8">

            <?php 

                if(isset($_GET['restaurant'])) {
                    $post_restaurant_id = escape($_GET['restaurant']);
                        
                    $query = "SELECT * FROM posts WHERE post_restaurant_id = {$post_restaurant_id} AND post_status = 'published'";
                    $result = mysqli_query($connection, $query);
                    $restaurant_result = selectStatusQuery('restaurants', 'restaurant_id', $post_restaurant_id);
                    $restaurant_row = mysqli_fetch_array($restaurant_result);
                    $restaurant_title = escape($restaurant_row['restaurant_title']);

                    

                    if(mysqli_num_rows($result) < 1) {
                        echo "<h1 class='page-header'>No Posts for {$restaurant_title}</h1>";
                    } else {
                        echo "<h1 class='page-header'>All Reviews on {$restaurant_title}</h1>";
                    }
                    
                    while($row = mysqli_fetch_assoc($result)) {
                        $post_id = escape($row['post_id']);
                        $post_title = stripslashes(escape($row['post_title']));
                        $post_author = stripslashes(escape($row['post_author']));
                        $post_date = date_create($row['post_date']);
                        $post_date = date_format($post_date, 'jS M Y');
                        $post_image = escape($row['post_image']);
                        $post_content = stripslashes(substr($row['post_content'], 0, 100));
                            ?>


            <!-- First Restaurant Post -->
            <h2>
                <a href="post.php?p_id=<?php echo $post_id ?>"><?php echo $post_title ?></a>
            </h2>
            <p class="lead">
                by <a
                    href="author_posts.php?author=<?php echo $post_author ?>&p_id=<?php echo $post_id ?>"><?php echo $post_author ?></a>
            </p>
            <p><span class="glyphicon glyphicon-time"></span> Published <?php echo $post_date ?></p>
            <hr>
            <img class="img-responsive" src="img/<?php echo $post_image; ?>" alt="">
            <hr>
            <p><?php echo $post_content ?></p>
            <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id ?>">Read More <span
                    class="glyphicon glyphicon-chevron-right"></span></a>

            <hr>

            <?php 
                    }
                }
            ?>


        </div>

        <!-- Restaurant Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"; ?>
        <!-- /.row -->

        <hr>

        <?php include "includes/footer.php"; ?>