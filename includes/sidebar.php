    <div class="col-md-4">

        <!-- Blog Search Well -->
        <div class="well">
            <h4>Blog Search</h4>
            <!-- Search Form -->
            <form action="search.php" method="post">
                <div class="input-group">
                    <input name="search" type="text" class="form-control">
                    <span class="input-group-btn">
                        <button name="submit" class="btn btn-default" type="submit">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                </div>
                <!-- /.input-group -->
            </form>
        </div>

        <!-- Login Form -->
        <div class="well">

            <?php if(isLoggedIn()): ?>

            <h4>Logged in as <?php echo $_SESSION['username'] ?></h4>
            <a href='includes/logout.php' name="logout" class="btn btn-warning">Log Out</a>
            <?php if($_SESSION['user_role'] == 'admin'): ?>
            <a href="admin" class="btn btn-success">Admin Page</a>
            <?php endif; ?>
            <?php else: ?>

            <h4>Login</h4>
            <!-- Search Form -->
            <form action="includes/login_handler.php" method="post">
                <div class="form-group">
                    <input name="username" placeholder="Enter Username" type="text" class="form-control">
                </div>
                <div class="input-group">
                    <input name="password" placeholder="Enter Password" type="password" class="form-control">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" name="login" type="submit">Submit</button>
                    </span>
                </div>
                <div class="form-group">
                    <a href="forgot_password.php?forgot=<?php ?>">Forgot Password?</a>
                </div>
                <!-- /.input-group -->
            </form>
            <?php endif; ?>
        </div>

        <!-- Blog Restaurants Well -->
        <div class="well">


            <h4>Categories</h4>
            <div class="row">
                <div class="col-lg-12">
                    <ul class="list-unstyled">

                        <?php
                            $query = "SELECT DISTINCT post_category FROM posts";
                            $select_categories_sidebar = mysqli_query($connection, $query);
                            
                            while($row = mysqli_fetch_assoc($select_categories_sidebar)) {
                                $category_title = escape($row['post_category']);
                
                                echo "<li> <a href='category.php?category=$category_title'>$category_title</a></li>";
                            }
                        ?>

                    </ul>
                </div>


            </div>
            <!-- /.row -->
        </div>

        <!-- Side Widget Well -->
        <?php include "includes/widget.php" ?>

    </div>

    </div>