<?php

include_once "../config/dbconnect.php";

$b_id = $_POST['record'];

// Check if book is currently borrowed
$query1 = "SELECT * FROM barrow_book WHERE barrow_id = '$b_id' AND book_status = 3";
$result = mysqli_query($conns, $query1);

// Check if category exists in barrow book table
if (mysqli_num_rows($result) > 0 ) {
    echo '<script>alert("Book Already Returned");</script>';
} else {
    $sql2 = "UPDATE books SET book_copies = book_copies+1  WHERE book_id = (SELECT book_id FROM barrow_book WHERE barrow_id = '$b_id')";
    $conns->query($sql2);
    // Book successfully deleted
    // Book successfully deleted
    // Delete the book from the database
    $query = "DELETE FROM barrow_book WHERE barrow_id='$b_id' AND book_status <=2";
    $data = mysqli_query($conns, $query);

    if ($data) {
       
        
    } else {
        echo "Not able to delete";
    }
}

?>
