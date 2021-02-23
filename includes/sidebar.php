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


            <h4>Blog Restaurants</h4>
            <div class="row">
                <div class="col-lg-12">
                    <ul class="list-unstyled">

                        <?php 
                            $select_restaurants_sidebar = selectQuery('restaurants');
                            
                            while($row = mysqli_fetch_assoc($select_restaurants_sidebar)) {
                                $restaurant_title = escape($row['restaurant_title']);
                                $restaurant_id = escape($row['restaurant_id']);
            
                                echo "<li> <a href='restaurant.php?restaurant={$restaurant_id}'>{$restaurant_title}</a></li>";
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