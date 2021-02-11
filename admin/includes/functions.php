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

?>