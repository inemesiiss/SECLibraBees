<?php

    include_once "../config/dbconnect.php";
    
    $id=$_POST['record'];
    $query="DELETE FROM admin_Lib where admin_id='$id'";

    $data=mysqli_query($conns,$query);

    if($data){
        echo"Admin Deleted";
    }
    else{
        echo"Not able to delete";
    }
    
?>