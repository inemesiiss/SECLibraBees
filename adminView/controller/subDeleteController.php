<?php

    include_once "../config/dbconnect.php";
    
    $s_id=$_POST['record'];
    $query="DELETE FROM subject where subject_id='$s_id'";

    $data=mysqli_query($conns,$query);

    if($data){
        echo"Subject Deleted";
    }
    else{
        echo"Not able to delete";
    }
    
?>