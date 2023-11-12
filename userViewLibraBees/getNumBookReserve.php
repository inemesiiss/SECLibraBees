

<?php
require_once '../config/ddbconnect.php';
require_once '../config/dbconnect.php';
session_start();

$std_id=$_SESSION['user']['std_id'];
$bookid=$_SESSION['user']['book_id'];

    
   if(isset($_POST['data'])){
      $selectReserveItems = "SELECT * FROM reserve_book WHERE stud_number = $std_id";
      $Notifget=$conns->query($selectReserveItems);
      if($Notifget->num_rows>0){
        echo"$Notifget->num_rows";
  
      }else{
        echo 0;
      }
   }

      
      ?>

      
