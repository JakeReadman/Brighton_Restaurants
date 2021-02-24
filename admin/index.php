<?php include "includes/admin_header.php"; ?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_navigation.php"  ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Admin Dashboard
                        <small>
                            Logged in as <?php echo $_SESSION['username'] ?>
                        </small>
                    </h1>
                </div>
            </div>

            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file-text fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">

                                    <?php 
                                        $active_post_count = numRowStatusQuery('posts', 'post_status', 'published');
                                        echo "<div class='huge'>{$active_post_count}</div>";
                                    ?>

                                    <div>Posts</div>
                                </div>
                            </div>
                        </div>
                        <a href="posts.php">
                            <div class="panel-footer">
                                <span class="pull-left">See More</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">

                                    <?php            
                                        $approved_comment_count = numRowStatusQuery('comments', 'comment_post_status', 'approved');
                                        echo "<div class='huge'>{$approved_comment_count}</div>";
                                    ?>

                                    <div>Comments</div>
                                </div>
                            </div>
                        </div>
                        <a href="comments.php">
                            <div class="panel-footer">
                                <span class="pull-left">See More</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">

                                    <?php 
                                        $admin_count = numRowStatusQuery('users', 'user_role', 'admin');
                                        echo "<div class='huge'>{$admin_count}</div>";
                                    ?>

                                    <div> Users</div>
                                </div>
                            </div>
                        </div>
                        <a href="users.php">
                            <div class="panel-footer">
                                <span class="pull-left">See More</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-list fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php                                     
                                        $restaurant_count = numRowQuery('restaurants');
                                        echo "<div class='huge'>{$restaurant_count}</div>";                                    
                                    ?>
                                    <div>Restaurants</div>
                                </div>
                            </div>
                        </div>
                        <a href="restaurants.php">
                            <div class="panel-footer">
                                <span class="pull-left">See More</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- /.row -->
            <?php                
                $draft_post_count = numRowStatusQuery('posts', 'post_status', 'draft');
                $rejected_comment_count = numRowStatusQuery('comments', 'comment_post_status', 'rejected');
                $pending_comment_count = numRowStatusQuery('comments', 'comment_post_status', 'pending');
                $user_subscriber_count = numRowStatusQuery('users', 'user_role', 'subscriber');
            ?>

            <div class="row">

                <script type="text/javascript">
                google.charts.load('current', {
                    'packages': ['bar']
                });
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ['Data', 'Count'],

                        <?php                         
                            $element_text = ['Active Posts', 'Draft Posts', 'Approved Comments', 'Rejected', 'Pending Comments', 'Admins', 'Subscribers', 'Restaurants'];
                            $element_count = [$active_post_count, $draft_post_count, $approved_comment_count, $rejected_comment_count, $pending_comment_count, $admin_count, $user_subscriber_count, $restaurant_count];

                            for($i = 0; $i < count($element_count); $i++) {
                                echo "['{$element_text[$i]}'" . " ," . "{$element_count[$i]}],";
                            }
                        
                        ?>

                    ]);

                    var options = {
                        chart: {
                            title: '',
                            subtitle: '',
                        }
                    };

                    var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
                    chart.draw(data, google.charts.Bar.convertOptions(options));
                }
                </script>

                <div id="columnchart_material" style="width: 'auto'; height: 60vh;"></div>

            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php"; ?>