<?php
    include_once "../config/dbconnect.php";
        $notif_title = mysqli_real_escape_string($conns, $_POST['notif_title']);
        $notif_content = mysqli_real_escape_string($conns, $_POST['notif_content']);
        $notif_schedule = $_POST['notif_Schedule'];
        $notif_endDate = $_POST['notif_end_date'];
        $notif_sendto = $_POST['notif_receiver'];
         $insert = mysqli_query($conns,"INSERT INTO notifications
         (notif_title,notif_msg,notif_time,send_to,notif_end) VALUES ('$notif_title','$notif_content','$notif_schedule','$notif_sendto','$notif_endDate')");
 
         if(!$insert)
         {
             echo mysqli_error($conns);
             
         }
         else
         {
            echo "success";
             
         }
     
    
        
?>