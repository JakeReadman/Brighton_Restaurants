<?php include "includes/admin_header.php"; ?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_navigation.php"  ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Review Authors</h1>

                    <div class="col-xs-6">

                        <?php insertAuthors() ?>

                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="author_name">Add Author</label>
                                <input class="form-control" type="text" name="author_name">
                            </div>
                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" name="submit" value="Add Author">
                            </div>
                        </form>

                        <?php //Update and Include Query                     
                        if(isset($_GET['edit'])) {
                            $author_id = escape($_GET['edit']);

                            include "includes/update_authors.php"; 
                        }
                        ?>

                    </div>
                    <div class="col-xs-6">
                        <table class="table table-border table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Author Title</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    //Find All Authors Query
                                    findAllAuthors();
                                    deleteAuthor();                            
                                ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php"; ?>