<?php

    include_once "../config/dbconnect.php";

    $admin_id=$_POST['admin_id'];
    $pos= $_POST['pos'];
    $ad_fname= $_POST['ad_fname'];
    $ad_sur= $_POST['ad_sur'];
    $ad_usern= $_POST['ad_usern'];
    $ad_pass= $_POST['ad_pass'];
    $bookManagementAccess= $_POST['bookManagementAccess'];
    $studManagementAccess= $_POST['studManagementAccess'];
    $chatManagementAccess= $_POST['chatManagementAccess'];
    $notifManagementAccess= $_POST['notifManagementAccess'];
    $revCommssMngtAccess= $_POST['revCommssMngtAccess'];
    
    
    $updateItem = mysqli_query($conns,"UPDATE admin_Lib SET 
        admin_pos='$pos', 
        admin_fname='$ad_fname', 
        admin_sname='$ad_sur',
        admin_user='$ad_usern',
        admin_password='$ad_pass',
        isBookAccess=$bookManagementAccess,
        isStudentAccess=$studManagementAccess,
        isChatAccess=$chatManagementAccess,
        isNotifAccess=$notifManagementAccess,
        isReviewsCommsAccess=$revCommssMngtAccess
        WHERE admin_id=$admin_id");


    if($updateItem)
    {
        echo "success";
    }
     else
    {
         echo mysqli_error($conns);
    }
?>