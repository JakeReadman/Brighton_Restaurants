<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

<?php
    
    if(isset($_POST['submit'])) {
        $to = "jakereadman@gmail.com";
        $subject = escape($_POST['subject']);
        $message = wordwrap(escape($_POST['body']), 70);
        $header = "From: " . escape($_POST['email']);

        if(!empty($subject) && !empty($message) && !empty($header)) {
            mail($to, $subject, $message, $header);
            $success_message = "Successfully Sent";
            $failed_message = "";
        } else {
            $success_message = "";
            $failed_message = "All fields must be completed";
        }
    } else {
        $success_message = "";
        $failed_message = "";
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
                        <h1>Contact</h1>
                        <form role="form" action="" method="post" id="contact-form" autocomplete="off">
                            <h6 class="text-center bg-danger"><?php echo $failed_message ?></h6>
                            <h6 class="text-center bg-success"><?php echo $success_message ?></h6>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="Enter Email Address">
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">Subject</label>
                                <input type="text" name="subject" id="subject" class="form-control"
                                    placeholder="Enter Subject">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="body" id="body" rows="10"></textarea>
                            </div>

                            <input type="submit" name="submit" class="btn btn-logout btn-lg btn-block" value="Submit">
                        </form>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>



    <?php include "includes/footer.php";?>