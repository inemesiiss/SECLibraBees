


<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('location:login.php');
    
 }else{

    include_once "../config/dbconnect.php";
    
    
        $student_id = $_POST['studChat_id'];
        $admin_id= $_POST['adminChat_id'];
        $message = mysqli_real_escape_string($conns, $_POST['message']);
        
        
        
        if(!empty($message)){
         $insert = mysqli_query($conns,"INSERT INTO chat
         (chat_msg,chat_receiver,chat_sender) VALUES ('$message','$admin_id','$student_id')") OR die();
 
        
            
        } 
    }
?>