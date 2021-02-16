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

                if(isset($_GET['category'])) {
                    $post_category_id = escape($_GET['category']);
                        
                    $query = "SELECT * FROM posts WHERE post_category_id = {$post_category_id} AND post_status = 'published'";
                    $result = mysqli_query($connection, $query);
                    $category_result = selectStatusQuery('categories', 'cat_id', $post_category_id);
                    $cat_row = mysqli_fetch_array($category_result);
                    $category_title = escape($cat_row['cat_title']);

                    

                    if(mysqli_num_rows($result) < 1) {
                        echo "<h1 class='page-header'>No Posts for {$category_title} Category</h1>";
                    } else {
                        echo "<h1 class='page-header'>Category: {$category_title}</h1>";
                    }
                    
                    while($row = mysqli_fetch_assoc($result)) {
                        $post_id = escape($row['post_id']);
                        $post_title = escape($row['post_title']);
                        $post_user = escape($row['post_user']);
                        $post_date = escape($row['post_date']);
                        $post_image = escape($row['post_image']);
                        $post_content = substr($row['post_content'], 0, 100);
                            ?>


            <!-- First Restaurant Post -->
            <h2>
                <a href="post.php?p_id=<?php echo $post_id ?>"><?php echo $post_title ?></a>
            </h2>
            <p class="lead">
                by <a href="index.php"><?php echo $post_user ?></a>
            </p>
            <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
            <hr>
            <img class="img-responsive" src="img/<?php echo $post_image; ?>" alt="">
            <hr>
            <p><?php echo $post_content ?></p>
            <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

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