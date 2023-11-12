

<?php
require_once '../config/ddbconnect.php';
require_once '../config/dbconnect.php';
session_start();

$std_id=$_SESSION['user']['std_id'];
$yr_lvl=$_SESSION['user']['yr_lvl'];
    
   if(isset($_POST['data'])){
    $updateChatNotifNum="SELECT * FROM chat  WHERE chat_receiver='$std_id' AND chat_status=0";
    $Notifget=$conns->query($updateChatNotifNum);
    if($Notifget->num_rows>0){
      echo"$Notifget->num_rows";

    }else{
      echo 0;
    }
   }
   if(isset($_POST['update'])){
    $updateChatNotif="UPDATE chat SET chat_status=1 WHERE chat_receiver='$std_id' AND chat_status=0";
    $conns->query($updateChatNotif);
   }

  


?>

