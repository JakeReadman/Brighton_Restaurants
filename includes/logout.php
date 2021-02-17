<?php session_start(); ?>
<?php include "../admin/includes/functions.php" ?>

<?php 

    $_SESSION['username'] = null;
    $_SESSION['user_firstname'] = null;
    $_SESSION['user_lastname'] = null;
    $_SESSION['user_role'] = null;

    if(!isset($_SESSION['user_role'])) {
        redirect("../index.php");
    }

?>