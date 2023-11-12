<?php
    include_once "../config/dbconnect.php";
    
    
       
        $booksubject = $_POST['booksubject'];

        $query = "SELECT * FROM subject WHERE subject_name = '$booksubject'";
        $result = mysqli_query($conns, $query);
       if (mysqli_num_rows($result) > 0) {
        echo 'Book Subject already exist!';
        } else {
       
         $insert = mysqli_query($conns,"INSERT INTO subject
         (subject_name)   VALUES ('$booksubject')");
 
            if(!$insert)
            {
               echo 'error adding subject!';
            }else
            {
               echo 'success';
            }
     
    }
    
   
?>