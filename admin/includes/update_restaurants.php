<form action="" method="POST">
    <div class="form-group">
        <label for="restaurant_title">Update Restaurant</label>

        <?php 

            if(isset($_GET['edit'])) {
                $restaurant_id = escape($_GET['edit']);
                $select_restaurants_id = selectStatusQuery('restaurants', 'restaurant_id', $restaurant_id);

                while($row = mysqli_fetch_assoc($select_restaurants_id)) {
                    $restaurant_id = escape($row['restaurant_id']);
                    $restaurant_title = escape($row['restaurant_title']);
                                        
            ?>

        <input value="<?php if(isset($restaurant_title)){ echo $restaurant_title; } ?>" class="form-control" type="text"
            name="restaurant_title">

        <?php }
                }
            ?>
        <?php 

            // Update query
            if(isset($_POST['update_restaurant'])) {
                $update_restaurant_title = escape($_POST['restaurant_title']);
                $query = "UPDATE restaurants SET restaurant_title = '{$update_restaurant_title}' WHERE restaurant_id = '{$restaurant_id}'";
                $update_query = mysqli_query($connection, $query);
                    if(!$update_query){
                        die("query failed" . mysqli_error($connection));
                        redirect("restaurants.php");
                    } else {
                        redirect("restaurants.php");
                    }
            }

        ?>


    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_restaurant" value="Update Restaurant">
    </div>
</form>