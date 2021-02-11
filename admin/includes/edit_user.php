<?php

    if(isset($_GET['edit_user'])) {
        $edit_user_id = escape($_GET['edit_user']);

        $query = "SELECT * FROM users WHERE user_id = $edit_user_id";
        $edit_user_query = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($edit_user_query)) {

            $edit_user_firstname = escape($row['user_firstname']);
            $edit_user_lastname = escape($row['user_lastname']);
            $edit_user_role = escape($row['user_role']);
            $edit_username = escape($row['username']);
            $edit_user_email = escape($row['user_email']);
            $edit_user_password = escape($row['user_password']);
            
        }
    

        if(isset($_POST['update_user'])) { 
            $user_firstname = escape($_POST['user_firstname']);
            $user_lastname = escape($_POST['user_lastname']);
            $user_role = escape($_POST['user_role']);
            $username = escape($_POST['username']);
            $user_email = escape($_POST['user_email']);
            $user_password = escape($_POST['user_password']);

            // $user_image = escape($_FILES['image']['name']);
            // $user_image_temp = escape($_FILES['image']['tmp_name']);
            // move_uploaded_file($user_image_temp, "../img/$user_image");

            if(!empty($user_password)) { 

                $password_query = "SELECT user_password FROM users WHERE user_id =  $edit_user_id";
                $get_user_query = mysqli_query($connection, $password_query);
                confirmQuery($get_user_query);
        
                $row = mysqli_fetch_array($get_user_query);
        
                $db_user_password = escape($row['user_password']);
        
                if($db_user_password != $user_password) {

                    $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
                }
            
                $query = "UPDATE users SET user_firstname = '{$user_firstname}', user_lastname = '{$user_lastname}', user_role = '{$user_role}', user_email = '{$user_email}', username = '{$username}', user_password = '{$hashed_password}' WHERE user_id = {$edit_user_id}"; 
                    
                $update_user_query = mysqli_query($connection, $query);  
                
                confirmQuery($update_user_query);

                echo "<p class='bg-success'>User Updated. <a href='users.php'>View All Users</a></p>";
            }// if password empty check end

        } // Post reques to update user end
    
    } else {  // If the user id is not present in the URL we redirect to the home page

        header("Location: index.php");
  
    }

?>


<form action="" method="post" enctype="multipart/form-data">

    <?php

    ?>

    <div class="form-group">
        <label for="firstname">First Name</label>
        <input type="text" class="form-control" name="user_firstname" value="<?php echo $edit_user_firstname ?>">
    </div>

    <div class="form-group">
        <label for="lastname">Last Name</label>
        <input type="text" class="form-control" name="user_lastname" value="<?php echo $edit_user_lastname ?>">
    </div>


    <div class="form-group">
        <label for="role">Role</label>
        <select class="form-control" name="user_role">
            <option value="<?php echo $edit_user_role ?>"><?php echo ucfirst($edit_user_role) ?></option>

            <?php 
        
                if($edit_user_role == 'admin') {
                    echo "<option value='subscriber'>Subscriber</option>";
                } else {
                    echo "<option value='admin'>Admin</option>";
                }    
        
            ?>


        </select>

    </div>


    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username" value="<?php echo $edit_username ?>">
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input class="form-control" type="email" name="user_email" value="<?php echo $edit_user_email ?>" />

    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input class="form-control" type="password" name="user_password" autocomplete="off" />

    </div>

    <!-- <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image">
    </div> -->


    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_user" value="Update User">
    </div>

</form>