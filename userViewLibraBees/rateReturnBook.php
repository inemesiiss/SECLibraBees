<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('location:login.php');
}


include_once "../config/dbconnect.php";

foreach ($_POST as $key => $value) {
  // check if the form element is a review data
  if (strpos($key, 'comments_') !== false && !empty($value)) {
    // extract the book ID from the form element name

    
    $book_id = str_replace('comments_', '', $key);
    // retrieve the other review data for this book
    $ratingNumber = $_POST['ratingNumber_'.$book_id];
    if($_POST['anonymous_'.$book_id] == true){
      $std_id="Anonymous";
    }else{
      $std_id=$_SESSION['user']['std_id'];
    }
    
    $comments = $value;
    $borrow_id = $_POST['barrow_id_'.$book_id];
    $reviewBookid = $_POST['ratebook_id_'.$book_id];
    // insert the review into the database
    $insert = mysqli_query($conns, "INSERT INTO review (stud_id, book_id, ratingNumber, comments, brrow_id) VALUES ('$std_id', '$book_id', '$ratingNumber', '$comments','$borrow_id')") OR die();
    if ($insert) {
      echo "success";
    } else {
      echo "something went wrong!";
    }
  }
}
?>