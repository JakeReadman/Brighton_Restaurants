<?php include "db.php"; ?>
<?php include "../admin/includes/functions.php" ?>
<?php session_start(); ?>

<?php 

if(isset($_POST['login'])) {
    $username = escape($_POST['username']);
    $password = escape($_POST['password']);

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $select_user_query = selectStatusQuery('users', 'username', $username);

    while($row = mysqli_fetch_array($select_user_query)) {
        $db_user_id = escape($row['user_id']);
        $db_username = escape($row['username']);
        $db_user_firstname = escape($row['user_firstname']);
        $db_user_lastname = escape($row['user_lastname']);
        $db_user_role = escape($row['user_role']);
        $db_user_password = escape($row['user_password']);
    }

    // $password = crypt($password, $db_user_password);


    if(password_verify($password, $db_user_password)) {
        $_SESSION['username'] = $db_username;
        $_SESSION['user_firstname'] = $db_user_firstname;
        $_SESSION['user_lastname'] = $db_user_lastname;
        $_SESSION['user_role'] = $db_user_role;

        header("Location: ../index.php");
        
    } else {
        header("Location: ../index.php");
    }

}

?>