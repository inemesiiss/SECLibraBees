<?php

    include_once "../config/dbconnect.php";
    
    $bcid=$_POST['record'];
    $query="DELETE FROM bookcategory where bookcategory_id='$bcid'";

    $data=mysqli_query($conns,$query);

    if($data){
        echo"Category Deleted";
    }
    else{
        echo"Not able to delete";
    }
    
?>