<?php
include_once "../config/dbconnect.php";

   if(isset($_POST['data'])){
    $selectNotifNum="SELECT * FROM chat WHERE chat_receiver ='admin' AND chat_status = 0";
    $Notifget=$conns->query($selectNotifNum);
    if($Notifget->num_rows>0){
      echo"$Notifget->num_rows";

    }else{
      echo 0;
    }
  }
?>
