<?php
  include_once "../config/dbconnect.php";
  $borrow_id = $_POST['borrow_id'];
  $new_value = $_POST['updated_value'];

  $sql="UPDATE barrow_book SET dt_overdue = '$new_value' WHERE barrow_id = $borrow_id";
 
  if ($conns->query($sql) === TRUE) {
    // if the query was successful, redirect back to the main page
    echo"success";
   
  } else {
    echo "Error updating record: " . $conns->error;
  }
?>
