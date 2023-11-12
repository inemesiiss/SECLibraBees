

<?php
require_once '../config/ddbconnect.php';
require_once '../config/dbconnect.php';
session_start();

$std_id=$_SESSION['user']['std_id'];
$yr_lvl=$_SESSION['user']['yr_lvl'];
    
   if(isset($_POST['data'])){
    $selectNotifNum="SELECT *
    FROM notifications
    WHERE (send_to = 'All' AND CURDATE() BETWEEN notif_time AND notif_end)
       OR (send_to = '$yr_lvl' AND CURDATE() BETWEEN notif_time AND notif_end) OR (send_to='$std_id' AND notif_sta_usrvw='unseen')";
    $Notifget=$conns->query($selectNotifNum);
    if($Notifget->num_rows>0){
      echo"$Notifget->num_rows";

    }else{
      echo 0;
    }
   }
   if(isset($_POST['update'])){
    $updateNotifNum="UPDATE notifications SET notif_sta_usrvw='seen' WHERE send_to='$std_id' AND notif_sta_usrvw='unseen'";
    $conns->query($updateNotifNum);
   }

  


?>

