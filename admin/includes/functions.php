<?php 

function escape($string) {
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
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
        $cat_title = $_POST['cat_title'];

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
        $get_cat_id = $_GET['delete'];
        $query = "DELETE FROM categories WHERE cat_id = {$get_cat_id}";
        $delete_query = mysqli_query($connection, $query);
        header("location: categories.php");
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
    $query = "SELECT * FROM " . $table;
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


?>