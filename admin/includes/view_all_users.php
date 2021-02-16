<table class="table table-bordered tabe-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>

        <?php
                        
            $select_users = selectQuery('users');
        
            while($row = mysqli_fetch_assoc($select_users)) {
                $user_id = escape($row['user_id']);
                $username = escape($row['username']);
                $user_password = escape($row['user_password']);
                $user_firstname = escape($row['user_firstname']);
                $user_lastname = escape($row['user_lastname']);
                $user_email = escape($row['user_email']);
                $user_role = escape($row['user_role']);
                

                echo "<tr>";
                echo "<td>{$user_id}</td>";
                echo "<td>{$username}</td>";
                echo "<td>{$user_firstname}</td>";
                echo "<td>{$user_lastname}</td>";
                echo "<td>{$user_email}</td>";
                echo "<td>{$user_role}</td>";

                // $query = "SELECT * FROM comments WHERE cat_id = {$post_category_id}";
                // $select_categories_id = mysqli_query($connection, $query);

                // while($row = mysqli_fetch_assoc($select_categories_id)) {
                //     $cat_id = escape($row['cat_id']);
                //     $cat_title = escape($row['cat_title']);
                    
                //     echo "<td>{$cat_title}</td>";
                // }


                // $query = "SELECT * FROM posts WHERE post_id = $comment_post_id";
                // $select_post_id_query = mysqli_query($connection, $query);
                // while($row = mysqli_fetch_assoc($select_post_id_query)) {
                //     $post_id = escape($row['post_id']);
                //     $post_title = escape($row['post_title']);

                //     echo "<td><a href='../post.php?p_id=$post_id'>{$post_title}</a></td>";
                // }           

                echo "<td><a class='btn btn-success' href='users.php?make_admin={$user_id}'>Make Admin</a></td>";
                echo "<td><a class='btn btn-warning' href='users.php?make_subscriber={$user_id}'>Make Subscriber</a></td>";
                echo "<td><a class='btn btn-info' href='users.php?source=edit_user&edit_user={$user_id}'>Edit</a></td>";
                echo "<td><a class='btn btn-danger' href='users.php?delete={$user_id}'>Delete</a></td>";
                echo "</tr>";
        
            }
            
        ?>

    </tbody>
</table>

<?php 

    if(isset($_GET['make_admin'])) {
        $admin_user_id = escape($_GET['make_admin']);

        $query = "UPDATE users SET user_role = 'admin' WHERE user_id = $admin_user_id";

        $admin_user_query = mysqli_query($connection, $query);

        redirect("users.php");
    }

    if(isset($_GET['make_subscriber'])) {
        $subscriber_user_id = escape($_GET['make_subscriber']);

        $query = "UPDATE users SET user_role = 'subscriber' WHERE user_id = $subscriber_user_id";

        $subscriber_user_query = mysqli_query($connection, $query);

        redirect("users.php");
    }

    if(isset($_GET['edit'])) {
        $edit_user_id = escape($_GET['edit']);

        $query = "UPDATE users WHERE user_id = $edit_user_id";

        $edit_user_query = mysqli_query($connection, $query);
    }

    if(isset($_GET['delete'])) {
        if(isset($_SESSION['user_role'])) {
            if($_SESSION['user_role'] == 'admin') {
                $delete_user_id = mysqli_real_escape_string($connection, $_GET['delete']);
                $query = "DELETE FROM users WHERE user_id = $delete_user_id";     
                $delete_user_query = mysqli_query($connection, $query);    
                redirect("users.php");
            }

        }

    }

?>