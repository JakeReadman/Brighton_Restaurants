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

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">


                            <h3><i class="fa fa-user fa-4x"></i></h3>
                            <h2 class="text-center">Register</h2>
                            <div class="panel-body">
                                <form role="form" action="registration.php" method="post" id="login-form"
                                    autocomplete="off">
                                    <h6 class="text-center bg-danger"><?php echo $failed_message ?></h6>
                                    <h6 class="text-center bg-success"><?php echo $success_message ?></h6>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-user color-blue"></i>
                                            </span>
                                            <label for="username" class="sr-only">username</label>
                                            <input type="text" name="username" id="username" class="form-control"
                                                placeholder="Enter Username">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-envelope color-blue"></i>
                                            </span>
                                            <label for="email" class="sr-only">Email</label>
                                            <input type="email" name="email" id="email" class="form-control"
                                                placeholder="somebody@example.com">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-lock color-blue"></i>
                                            </span>
                                            <label for="password" class="sr-only">Password</label>
                                            <input type="password" name="password" id="key" class="form-control"
                                                placeholder="Password">
                                        </div>
                                    </div>

                                    <input type="submit" name="submit" class="btn btn-1 btn-lg btn-block"
                                        value="Register">
                                </form>

                            </div><!-- Body-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->