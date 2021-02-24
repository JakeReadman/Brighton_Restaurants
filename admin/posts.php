<?php include "includes/admin_header.php"; ?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_navigation.php"  ?>

    <div id="page-wrapper">

        <div class="container-fluid">
            <?php
                if(!isset($_GET['source'])) {
                    $message = 'All Posts';
                } else if($_GET['source'] == 'add_post') {
                    $message = 'Add Post';
                } else if($_GET['source'] == 'edit_post') {
                    $message = 'Edit Post';
                } else {
                    $message = '';
                }
            ?>
            <!-- Page Heading -->
            <div class="row">
                <h1 class="page-header">
                    <?php echo $message ?>
                </h1>

                <?php 
                    if(isset($_GET['source'])) {
                        $source = escape($_GET['source']);
                    } else {
                        $source = '';
                    }

                    switch($source) {
                        case 'add_post';
                        include "includes/add_post.php";
                        break;

                        case 'edit_post';
                        include "includes/edit_post.php";
                        break;

                        default:
                        include "includes/view_all_posts.php";
                        break;
                    }

                
                ?>




            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php"; ?>