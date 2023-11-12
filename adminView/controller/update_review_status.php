<?php 
session_start();
//if($_SESSION['user']['bookaccess'] == 0){
  //debug_backtrace() || die ("<h2>Access Denied!</h2> Please contact the admin librian"); 
//}

include_once "../config/dbconnect.php";
$rev_id = $_POST['review_id'];
$newStatus = $_POST['new_status'];



// Update the borrow status and timestamps
if ($newStatus == 1) {
  $sql = "UPDATE review SET status = $newStatus WHERE review_id = $rev_id AND status = 0";
  $conns->query($sql);
} else {
    $sql = "UPDATE review SET status = $newStatus WHERE review_id = $rev_id AND status = 1";
  $conns->query($sql);
  

  
    }
?>
    