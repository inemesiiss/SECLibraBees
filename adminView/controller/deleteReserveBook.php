<?php

include_once "../config/dbconnect.php";

$r_id = $_POST['record'];


    // Delete the reserve data from the database
    $query = "DELETE FROM reserve_book WHERE reserve_id='$r_id'";
    $data = mysqli_query($conns, $query);

    if ($data) {
        echo "reserve deleted";
        
    } else {
        echo "Not able to delete";
    }


?>
