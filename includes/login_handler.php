<?php ob_start(); ?>
<?php session_start(); ?>
<?php  include "db.php"; ?>
<?php  include "../admin/includes/functions.php"; ?>


<?php 

if(isset($_POST['login'])) {
    loginUser($_POST['username'], $_POST['password'], '../index.php');
}

redirect('../index.php')

?>