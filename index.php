<!-- Header -->
<?php include "includes/header.php"; ?>
<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Restaurant Entries Column -->
        <div class="col-md-8">

            <!-- Logic for limiting posts per page -->
            <?php
            
                $per_page = 5;
                if(isset($_GET['page'])) {
                    
                    $page = escape($_GET['page']);
                } else {
                    $page = '';
                }

                if($page == "" || $page == 1) {
                    $page_1 = 0;
                } else {
                    $page_1 = ($page * $per_page) - $per_page;
                }

                $find_count_query = selectStatusQuery('posts', 'post_status', 'published');
                $count = mysqli_num_rows($find_count_query);

                $count = ceil($count / $per_page);

                $query = "SELECT * FROM posts WHERE post_status = 'published' LIMIT $page_1, $per_page";
                $result = mysqli_query($connection, $query);

                

                if(mysqli_num_rows($result) < 1) {
                    echo "<h1 class='page-header'>No Posts to Display</h1>";
                } else {
                    echo "<h1 class='page-header'>Brighton Restaurant Reviews</h1>";
                }
                
                while($row = mysqli_fetch_assoc($result)) {
                    $post_id = escape($row['post_id']);
                    $post_title = stripslashes(escape($row['post_title']));
                    $post_author = stripslashes(escape($row['post_author']));
                    $post_date = date_create($row['post_date']);
                    $post_date = date_format($post_date, 'jS M Y');
                    $post_image = escape($row['post_image']);
                    $post_content = stripslashes(substr($row['post_content'], 0, 500));
                    $post_status = escape($row['post_status']);
                    
                    if($post_status == 'published') {
                     
                    
            ?>

            <!-- All Restaurant Posts Loop -->
            <h2>
                <a href="post.php?p_id=<?php echo $post_id ?>"><?php echo $post_title ?></a>
            </h2>
            <p class="lead">
                <a href="author_posts.php?author=<?php echo $post_author ?>&p_id=<?php echo $post_id ?>">-
                    <?php echo $post_author ?></a>
            </p>
            <p class="publish-date"><span class="glyphicon glyphicon-time"></span> Published <?php echo $post_date ?>
            </p>
            <hr>
            <img class="img-responsive" src="img/<?php echo imagePlaceholder($post_image); ?>" alt="">
            <hr>
            <p><?php echo $post_content ?></p>
            <a class="btn btn-2" href="post.php?p_id=<?php echo $post_id ?>">Read More <span
                    class="glyphicon glyphicon-chevron-right"></span></a>

            <hr>

            <?php 
                 } }
            ?>


        </div>

        <!-- Restaurant Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"; ?>

        <hr>

        <!-- Pagination -->
        <ul class="pager">
            <?php 
        
        for($i = 1; $i <= $count; $i++) {
                if($i == $page) {
                    echo "<li><a class='active-link page-num' href='index.php?page={$i}'>{$i}</a></li>";
                } else {
                    echo "<li><a class='page-num' href='index.php?page={$i}'>{$i}</a></li>";
                }
            }
            
        ?>

        </ul>

        <?php include "includes/footer.php"; ?>