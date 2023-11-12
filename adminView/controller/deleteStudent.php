<?php

include_once "../config/dbconnect.php";

$std_id = $_POST['record'];
 // Check if book is currently borrowed
 $query = "SELECT stud_number FROM barrow_book WHERE stud_number = '$std_id'";
 $result = mysqli_query($conns, $query);
 
 // Check if category exists in barrow book table
 if (mysqli_num_rows($result) > 0 ) {
      echo "error";
 } else {
    // Delete the reserve data from the database
    $query = "DELETE FROM users WHERE stud_number='$std_id'";
    $data = mysqli_query($conns, $query);

    if ($data) {
        echo"success";
        
    } else {
        echo "Not able to delete";
    }
 }

?>
