<?php
    include_once "../config/dbconnect.php";

    $pre_reg_number = $_POST['preRegNum'];
    $query = "SELECT * FROM users WHERE pre_reg_number = '$pre_reg_number'";
            $result = mysqli_query($conns, $query);
            if (mysqli_num_rows($result) > 0) {
                echo "Student Number already exist!";
            }else{
                $insert = mysqli_query($conns,"INSERT INTO users
         (pre_reg_number) VALUES ('$pre_reg_number')");
 
         if(!$insert)
         {
             echo mysqli_error($conns);
             
         }
         else
         {
            echo "success";
             
         }

                
            }  
         
        
    
        
?>