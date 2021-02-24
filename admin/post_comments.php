<?php include "includes/admin_header.php"; ?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_navigation.php"  ?>

    <div id="page-wrapper">

        <?php 
            $selected_post_id = escape($_GET['id']);       
            $select_comments = selectStatusQuery('comments', 'comment_post_id', $selected_post_id);
            $select_post_id_query = selectStatusQuery('posts', 'post_id', $selected_post_id);
            while($row = mysqli_fetch_assoc($select_post_id_query)) {
                $post_id = escape($row['post_id']);
                $post_title = escape($row['post_title']);
            }
        ?>

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        All Comments for <a href='../post.php?p_id=<?php echo $post_id ?>'><?php echo $post_title ?></a>
                    </h1>
                </div>
            </div>

            <table class="table table-bordered tabe-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Author</th>
                        <th>Comment</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>In Response To</th>
                        <th>Date</th>
                        <th>Approve</th>
                        <th>Reject</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    
                        while($row = mysqli_fetch_assoc($select_comments)) {
                            $comment_id = escape($row['comment_id']);
                            $comment_post_id = escape($row['comment_post_id']);
                            $comment_author = escape($row['comment_post_author']);
                            $comment_content = escape($row['comment_post_content']);
                            $comment_email = escape($row['comment_post_email']);
                            $comment_status = escape($row['comment_post_status']);
                            $comment_date = escape($row['comment_post_date']);
                            

                            echo "<tr>";
                            echo "<td>{$comment_id}</td>";
                            echo "<td>{$comment_author}</td>";
                            echo "<td>{$comment_content}</td>";
                            echo "<td>{$comment_email}</td>";
                            echo "<td>{$comment_status}</td>";
                            echo "<td><a href='../post.php?p_id=$post_id'>{$post_title}</a></td>";
                            echo "<td>{$comment_date}</td>";
                            echo "<td><a class='btn btn-success' href='post_comments.php?approve=$comment_id&id=$selected_post_id'>Approve</a></td>";
                            echo "<td><a class='btn btn-danger' href='post_comments.php?reject=$comment_id&id=$selected_post_id'>Reject</a></td>";
                            echo "<td><a class='btn btn-danger' href='post_comments.php?delete=$comment_id&id=$selected_post_id'>Delete</a></td>";
                            echo "</tr>";
                    
                        }
                        
                    ?>

                </tbody>
            </table>

            <?php
            
                if(isset($_GET['approve'])) {
                    $approve_comment_id = escape($_GET['approve']);

                    $query = "UPDATE comments SET comment_post_status = 'approved' WHERE comment_id = $approve_comment_id";

                    $approve_comment_query = mysqli_query($connection, $query);

                    redirect("post_comments.php?id=$selected_post_id");
                }

                if(isset($_GET['reject'])) {
                    $reject_comment_id = escape($_GET['reject']);

                    $query = "UPDATE comments SET comment_post_status = 'rejected' WHERE comment_id = $reject_comment_id";

                    $reject_comment_query = mysqli_query($connection, $query);

                    redirect("post_comments.php?id=$selected_post_id");
                }

                if(isset($_GET['delete'])) {
                    $delete_comment_id = escape($_GET['delete']);

                    $query = "DELETE FROM comments WHERE comment_id = $delete_comment_id";

                    $delete_comment_query = mysqli_query($connection, $query);

                    redirect("post_comments.php?id=$selected_post_id");
                }

            ?>
        </div>

    </div>

    <?php include "includes/admin_footer.php"; ?>