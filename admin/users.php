<?php include "includes/admin_header.php"; ?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_navigation.php"  ?>

    <div id="page-wrapper">

        <div class="container-fluid">
            <?php
                if(!isset($_GET['source'])) {
                    $message = 'All Users';
                } else if($_GET['source'] == 'add_user') {
                    $message = 'Add User';
                } else if($_GET['source'] == 'edit_user') {
                    $message = 'Edit User';
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
                        case 'add_user';
                        include "includes/add_user.php";
                        break;

                        case 'edit_user';
                        include "includes/edit_user.php";
                        break;

                        default:
                        include "includes/view_all_users.php";
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