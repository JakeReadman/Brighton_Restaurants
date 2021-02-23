<?php 

function imagePlaceholder($image = '') {

    if(!$image) {
        return '/img/Brighton Pier.JPG';
    }  else {
        return $image;  
    } 
}

function escape($string) {
    global $connection;
    return mysqli_real_escape_string($connection, $string);
}

function onlineUsers() {

    if(isset($_GET['onlineusers'])) {

        global $connection;

        if(!$connection) {
            
            session_start();

            include "../../includes/db.php";
            
            $session = session_id();
            $time = time();
            $timeout = $time - 05;
    
            $query = "SELECT * FROM online_users WHERE online_users_session = '$session'";
            $send_query = mysqli_query($connection, $query);
            $count = mysqli_num_rows($send_query);
    
            if($count === NULL || $count === 0 || $count === false) {
                mysqli_query($connection, "INSERT INTO online_users(online_users_session, online_users_time) VALUES('$session', '$time')");
            } else {
                mysqli_query($connection, "UPDATE online_users SET online_users_time = '$time' WHERE online_users_session = '$session'");
            }
            
            $query2 = "SELECT * FROM online_users WHERE online_users_time > '$timeout'";
            $online_users_query =  mysqli_query($connection, $query2);
            echo $user_count = mysqli_num_rows($online_users_query);

        }        

    } // get request for onlineusers
}

// onlineUsers();

//Insert Categories Query
function insertCategories() {

    global $connection;

    if(isset($_POST['submit'])) {
        $cat_title = escape($_POST['cat_title']);

        if($cat_title == "" || empty($cat_title)) {
            echo "This field should not be empty";
        } else {
            $query = "INSERT INTO categories(cat_title) VALUE('{$cat_title}')";
            $create_category_query = mysqli_query($connection, $query);

            if(!$create_category_query) {
                die('QUERY FAILED' . mysqli_error($connection));
            }
        }
    }   
}

//Find All Categories Query
function findAllCategories() {

    global $connection;
    $query = "SELECT * FROM categories";
    $select_categories = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($select_categories)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];

        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a class='btn btn-danger' href='categories.php?delete={$cat_id}'>Delete</a></td>";
        echo "<td><a class='btn btn-warning' href='categories.php?edit={$cat_id}'>Edit</a></td>";
        echo "<tr>";
    }
}

function deleteCategory() {
    global $connection;

    if(isset($_GET['delete'])) {
        $get_cat_id = escape($_GET['delete']);
        $query = "DELETE FROM categories WHERE cat_id = {$get_cat_id}";
        $delete_query = mysqli_query($connection, $query);
        header("location: categories.php");
    }
}

//Insert Authors Query
function insertAuthors() {

    global $connection;

    if(isset($_POST['submit'])) {
        $author_name = escape($_POST['author_name']);

        if($author_name == "" || empty($author_name)) {
            echo "This field should not be empty";
        } else {
            $query = "INSERT INTO authors(author_name) VALUE('{$author_name}')";
            $create_author_query = mysqli_query($connection, $query);

            if(!$create_author_query) {
                die('QUERY FAILED' . mysqli_error($connection));
            }
        }
    }   
}

//Find All Authors Query
function findAllAuthors() {

    global $connection;
    $select_authors = selectQuery('authors');

    while($row = mysqli_fetch_assoc($select_authors)) {
        $author_id = $row['author_id'];
        $author_name = $row['author_name'];

        echo "<tr>";
        echo "<td>{$author_id}</td>";
        echo "<td>{$author_name}</td>";
        echo "<td><a class='btn btn-danger' href='authors.php?delete={$author_id}'>Delete</a></td>";
        echo "<td><a class='btn btn-warning' href='authors.php?edit={$author_id}'>Edit</a></td>";
        echo "<tr>";
    }
}

function deleteAuthor() {
    global $connection;

    if(isset($_GET['delete'])) {
        $get_author_id = escape($_GET['delete']);
        $query = "DELETE FROM authors WHERE author_id = {$get_author_id}";
        $delete_query = mysqli_query($connection, $query);
        header("location: authors.php");
    }
}

function confirmQuery($result) {
    global $connection;

    if(!$result) {
        die("Query Failed" . mysqli_error($connection));
    }
}

function approveComment() {
    global $connection;
    
    if(isset($_GET['approve'])) {
        $approve_comment_id = escape($_GET['approve']);

        $query = "UPDATE comments SET comment_post_status = 'approved' WHERE comment_id = $approve_comment_id";

        $approve_comment_query = mysqli_query($connection, $query);

        header("Location: comments.php");
    }
}

function rejectComment() {
    global $connection;
    
    if(isset($_GET['reject'])) {
        $reject_comment_id = escape($_GET['reject']);

        $query = "UPDATE comments SET comment_post_status = 'rejected' WHERE comment_id = $reject_comment_id";

        $reject_comment_query = mysqli_query($connection, $query);

        header("Location: comments.php");
    }
}

function deleteComment() {
    global $connection;
    
    if(isset($_GET['delete'])) {
        $delete_comment_id = escape($_GET['delete']);

        $query = "DELETE FROM comments WHERE comment_id = $delete_comment_id";

        $delete_comment_query = mysqli_query($connection, $query);

        header("Location: comments.php");
    }
}

function selectQuery($table) {
    global $connection;
    $query = "SELECT * FROM $table";
    $select_query = mysqli_query($connection, $query);
    confirmQuery($select_query);
    return $select_query;
}

function selectStatusQuery($table, $column, $status) {
    global $connection;
    $query = "SELECT * FROM $table WHERE $column = '$status'";
    $select_query = mysqli_query($connection, $query);
    confirmQuery($select_query);
    return $select_query;
}

function numRowQuery($table) {
    global $connection;
    $select_query = selectQuery($table);
    $result = mysqli_num_rows($select_query);
    confirmQuery($result);
    return $result;
}

function numRowStatusQuery($table, $column, $status) {
    global $connection;
    $query = "SELECT * FROM $table WHERE $column = '$status'";
    $result = mysqli_query($connection, $query);
    return mysqli_num_rows($result);
}

function usernameExists($username) {
    global $connection;
    $numRows = numRowStatusQuery('users', 'username', $username);
    return $numRows > 0;
}

function emailExists($user_email) {
    global $connection;
    $numRows = numRowStatusQuery('users', 'user_email', $user_email);
    return $numRows > 0;
}

function redirect($location) {
    header("Location: $location");
    exit;
}

function loginUser($username, $password, $location) {

    global $connection;

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
   
        if(password_verify($password, $db_user_password)) {
            $_SESSION['username'] = $db_username;
            $_SESSION['user_firstname'] = $db_user_firstname;
            $_SESSION['user_lastname'] = $db_user_lastname;
            $_SESSION['user_role'] = $db_user_role;
    
            redirect($location);
            
        } else {
            return false;
        }
    }
}

function isMethod($method=null) {
    return $_SERVER['REQUEST_METHOD'] == strtoupper($method);
}

function isLoggedIn() {
    return isset($_SESSION['user_role']);
}

function isAdmin() {
    return isLoggedIn() && $_SESSION['user_role'] == 'admin';
}

function loggedInUserId() {
    if(isLoggedIn()) {
        $result = selectStatusQuery('users', 'username', $_SESSION['username']);
        $user = mysqli_fetch_array($result);
        return mysqli_num_rows($result) >= 1 ? $user['user_id'] : false;
    }
}

function userLikedPost($post_id = '') {
    global $connection;
    $user_id = loggedInUserId();
    $query = "SELECT * FROM likes WHERE user_id = {$user_id} AND post_id = {$post_id}";
    $result = mysqli_query($connection, $query);
    return mysqli_num_rows($result) >= 1 ? true : false;
}

function checkLoggedInAndRedirect($location=null) {
    if(isLoggedIn()) {
        redirect($location);
    }
}

?>