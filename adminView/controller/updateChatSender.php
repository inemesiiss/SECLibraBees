<?php
session_start();
    $admin_id=$_SESSION['user']['ad_email'];
    include_once "../config/dbconnect.php";
    $chatid=$_POST['chatid'];
    // update current chat mesg from another user who was click
    $updateItem = mysqli_query($conns,"UPDATE admin_Lib SET 
        admin_currChat='$chatid' WHERE admin_user='$admin_id'");
    $_SESSION['user']['curr_chat'] =$_POST['chatid'];
    // will update the unseen chat msg
    $updateNotifNum="UPDATE chat SET chat_status=1 WHERE chat_sender='$chatid' AND chat_status=0";
    $conns->query($updateNotifNum);


    if($updateItem)
    {
        echo "true";
    }
     else
    {
         echo mysqli_error($conns);
    }
?>