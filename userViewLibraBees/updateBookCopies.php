<?php
session_start();
$bookCopies = $_POST['bookCopies'];
$_SESSION['user']['book_copies'] = $bookCopies; // update the session variable
// you can also update the variable in the database if needed

// send a response if needed
echo "Book copies updated to $bookCopies";
?>