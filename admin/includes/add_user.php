<?php

    if(isset($_POST['create_user'])) { 
        $user_firstname = escape($_POST['user_firstname']);
        $user_lastname = escape($_POST['user_lastname']);
        $user_role = escape($_POST['user_role']);
        $username = escape($_POST['username']);
        $user_email = escape($_POST['user_email']);
        $user_password = escape($_POST['user_password']);

        // $user_image = escape($_FILES['image']['name']);
        // $user_image_temp = escape($_FILES['image']['tmp_name']);
        // move_uploaded_file($user_image_temp, "../img/$user_image");

        $password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
    
        $query = "INSERT INTO users(user_firstname, user_lastname, user_role, user_email, username, user_password) VALUES('{$user_firstname}', '{$user_lastname}','{$user_role}', '{$user_email}','{$username}', '{$password}')"; 
            
        $create_user_query = mysqli_query($connection, $query);  
        
        confirmQuery($create_user_query);

        $user_id = mysqli_insert_id($connection);

        echo "<p class='bg-success'>User Created. <a href='users.php'>View Users</a></p>";

    }

?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="firstname">First Name</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>

    <div class="form-group">
        <label for="lastname">Last Name</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>

    <div class="form-group">
        <label for="user_role">Role</label>
        <select class="form-control" name="user_role" id="user_role">
            <option value="subscriber">Select Option</option>
            <option value="admin">Admin</option>
            <option value="subscriber">Subscriber</option>
        </select>

    </div>

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username">
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input class="form-control" type="email" name="user_email" />

    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input class="form-control" type="password" name="user_password" />

    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_user" value="Create User">
    </div>

</form>