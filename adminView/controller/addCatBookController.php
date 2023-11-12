<?php
    include_once "../config/dbconnect.php";
    
    
        // Execute SELECT query

       
        $bookcategory = $_POST['bookcategory'];
        $query = "SELECT * FROM bookcategory WHERE bookcategory_name = '$bookcategory'";
        $result = mysqli_query($conns, $query);

// Check if category exists in book table
            if (mysqli_num_rows($result) > 0) {
                echo 'Category already exist!';
            } else {
                $insert = mysqli_query($conns,"INSERT INTO bookcategory
         (bookcategory_name)   VALUES ('$bookcategory')");
 
            if(!$insert)
            {
                echo 'error adding category!';
            }else
            {
                echo 'success';
            }

            }
            
     
    
        
?>