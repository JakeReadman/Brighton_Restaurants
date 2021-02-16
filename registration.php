<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

<?php 

    if(isset($_POST['submit'])) {
        $username = escape($_POST['username']);
        $email = escape($_POST['email']);
        $password = escape($_POST['password']);

        if(usernameExists($username)) {
            $failed_message = "Username Already Exists";
            $success_message = "";
        } else if(emailExists($email)) {
            $failed_message = "Email Already Exists";
            $success_message = "";
        } else {

            if(!empty($username) && !empty($email) && !empty($password)) {
                
                $username = mysqli_real_escape_string($connection, $username);
                $email = mysqli_real_escape_string($connection, $email);
                $password = mysqli_real_escape_string($connection, $password);
                
                $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
                
                $query = "INSERT INTO users (username, user_email, user_password, user_role) VALUES ('{$username}', '{$email}', '{$password}', 'subscriber')";
                $registration_user_query = mysqli_query($connection, $query);
                
                if(!$registration_user_query) {
                    die("QUERY FAILED" . mysqli_error($connection) . ' ' . mysqli_errno($connection));
                }
                
                $success_message = "Registration Successful";
                $failed_message = "";
                
            } else {
                $success_message = "";
                $failed_message = "All fields must be completed to register";
            }
        }
        } else {
            $failed_message = '';
            $success_message = '';
    }
        
?>


<!-- Navigation -->

<?php  include "includes/navigation.php"; ?>


<!-- Page Content -->
<div class="container">

    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1>Register</h1>
                        <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                            <h6 class="text-center bg-danger"><?php echo $failed_message ?></h6>
                            <h6 class="text-center bg-success"><?php echo $success_message ?></h6>
                            <div class="form-group">
                                <label for="username" class="sr-only">username</label>
                                <input type="text" name="username" id="username" class="form-control"
                                    placeholder="Enter Desired Username">
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="somebody@example.com">
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="password" id="key" class="form-control"
                                    placeholder="Password">
                            </div>

                            <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block"
                                value="Register">
                        </form>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>



    <?php include "includes/footer.php";?>