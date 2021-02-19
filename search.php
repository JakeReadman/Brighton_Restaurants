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

                if(isset($_POST['submit'])) {
                    $search = escape($_POST['search']);
                    $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%' OR post_title LIKE '%$search%' OR post_user LIKE '%$search%'";
                    $search_query = mysqli_query($connection, $query);

                    if(!$search_query) {
                        die("QUERY FAILED" . mysqli_error($connection));
                    }

                    $count = mysqli_num_rows($search_query);
                    
                    if($count == 0) {
                        echo "<h1>No posts to display</h1>";
                    } else {
        
                        while($row = mysqli_fetch_assoc($search_query)) {
                            $post_id = escape($row['post_id']);
                            $post_title = escape($row['post_title']);
                            $post_user = escape($row['post_user']);
                            $post_date = escape($row['post_date']);
                            $post_image = escape($row['post_image']);
                            $post_content = escape($row['post_content']);
                    ?>


            <!-- First Blog Post -->
            <h2>
                <a href="post.php?p_id=<?php echo $post_id ?>"><?php echo $post_title ?></a>
            </h2>
            <p class="lead">
                by <a
                    href="user_posts.php?user=<?php echo $post_user ?>&p_id=<?php echo $post_id ?>"><?php echo $post_user ?></a>
            </p>
            <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
            <hr>
            <img class="img-responsive" src="img/<?php echo imagePlaceholder($post_image); ?>" alt="">
            <hr>
            <p><?php echo $post_content ?></p>
            <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

            <hr>

            <?php 
                        }
                    }
                }
                    ?>



        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"; ?>
        <!-- /.row -->

        <hr>

        <?php include "includes/footer.php"; ?>