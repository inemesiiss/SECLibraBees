<?php

include_once "../config/dbconnect.php";
session_start();

$total = 0; // initialize total to zero

if(isset($_POST['data'])){
    $selBook="SELECT * FROM barrow_book WHERE book_status = 1";
    $pickNumGet=$conns->query($selBook);
    if($pickNumGet->num_rows>0){
        $total += $pickNumGet->num_rows; // add number of rows to total
    }

    $selReview="SELECT * FROM review WHERE status = 0";
    $reviewGet=$conns->query($selReview);
    if($reviewGet->num_rows>0){
        $total += $reviewGet->num_rows; // add number of rows to total
    }

    $selError="SELECT * FROM errQueries";
    $errGet=$conns->query($selError);
    if($errGet->num_rows>0){
        $total += $errGet->num_rows; // add number of rows to total
    }
}

echo $total;
?>