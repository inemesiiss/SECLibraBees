<?php
   include_once "../config/dbconnect.php";

  
       $catname = $_POST['c_name'];
   
       
        $query = "SELECT * FROM category WHERE category_name = '$catname'";
        $result = mysqli_query($conns, $query);
       if (mysqli_num_rows($result) > 0) {
        echo 'Section already exist!';
        } else {
            $insert = mysqli_query($conns,"INSERT INTO category
        (category_name) 
        VALUES ('$catname')");
   
        if(!$insert)
        {
            echo 'error adding section!';
        }else
        {
            echo 'success';
        }
    } 
    
    
 
?>