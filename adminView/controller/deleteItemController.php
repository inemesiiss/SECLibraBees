<?php

    include_once "../config/dbconnect.php";
    
    $p_id = $_POST['record'];
    
    // Check if book is currently borrowed
    $query = "SELECT book_id FROM barrow_book WHERE book_id = '$p_id'";
    $result = mysqli_query($conns, $query);
    
    // Check if category exists in barrow book table
    if (mysqli_num_rows($result) > 0 ) {
        echo '<script>alert("Book Currently On Barrow Table!");</script>';
    } else {
        // Delete the book from the database
        $query = "DELETE FROM books where book_id='$p_id'";
        $data = mysqli_query($conns, $query);

        if ($data) {
           
        } else {
            echo "Not able to delete";
        }
    }
    
?>