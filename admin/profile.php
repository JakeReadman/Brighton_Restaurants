<?php include "includes/admin_header.php"; ?>

<?php 

    if(isset($_SESSION['username'])) {
        $username = escape($_SESSION['username']);

        $select_user_profile_query = selectStatusQuery('users', 'username', $username);

        while($row = mysqli_fetch_array($select_user_profile_query)) {
            $user_id = escape($row['user_id']);
            $username = escape($row['username']);
            $user_password = escape($row['user_password']);
            $user_firstname = escape($row['user_firstname']);
            $user_lastname = escape($row['user_lastname']);
            $user_email = escape($row['user_email']);
            $user_role = escape($row['user_role']);
        }
    }

?>

<?php 

    if(isset($_POST['profile'])) {
        $user_firstname = escape($_POST['user_firstname']);
        $user_lastname = escape($_POST['user_lastname']);
        $username = escape($_POST['username']);
        $user_email = escape($_POST['user_email']);
        $user_password = escape($_POST['user_password']);

        // $user_image = escape($_FILES['image']['name']);
        // $user_image_temp = escape($_FILES['image']['tmp_name']);


        // move_uploaded_file($user_image_temp, "../img/$user_image");
        
        $query = "UPDATE users SET user_firstname = '{$user_firstname}', user_lastname = '{$user_lastname}', user_role = '{$user_role}', user_email = '{$user_email}', username = '{$username}', user_password = '{$user_password}' WHERE username = '{$username}'"; 
             
        $user_query = mysqli_query($connection, $query);  
            
        confirmQuery($user_query);


    //   echo "<p class='bg-success'>User Updated. <a href='users.php'>Edit More Users?</a></p>";
    }


?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_navigation.php"  ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <h1 class="page-header">
                    Edit Profile
                </h1>

                <form action="" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="firstname">First Name</label>
                        <input type="text" class="form-control" name="user_firstname"
                            value="<?php echo $user_firstname ?>">
                    </div>

                    <div class="form-group">
                        <label for="lastname">Last Name</label>
                        <input type="text" class="form-control" name="user_lastname"
                            value="<?php echo $user_lastname ?>">
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" value="<?php echo $username ?>">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control" type="email" name="user_email" value="<?php echo $user_email ?>" />

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
                        <input class="btn btn-primary" type="submit" name="profile" value="Update Profile">
                    </div>

                </form>

            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php"; ?>