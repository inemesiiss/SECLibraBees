

<?php
require_once '../config/ddbconnect.php';
require_once '../config/dbconnect.php';
session_start();

$std_id=$_SESSION['user']['std_id'];
$yr_lvl=$_SESSION['user']['yr_lvl'];
    
   if(isset($_POST['data'])){
    $sqlgetRate = "SELECT * FROM barrow_book WHERE barrow_id NOT IN (SELECT brrow_id FROM review WHERE brrow_id IS NOT NULL) AND book_status =3 AND stud_number='$std_id' ORDER BY barrow_id DESC";
    $Notifget=$conns->query($sqlgetRate);
    if($Notifget->num_rows>0){
      echo"$Notifget->num_rows";

    }else{
      echo 0;
    }
   }
?>

