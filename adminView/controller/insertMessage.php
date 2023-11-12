


<?php

session_start();
    include_once "../config/dbconnect.php";
    $_SESSION['user']['curr_chat'];
    $selStudSender = "SELECT * FROM admin_Lib WHERE ";
    $student_id = $_SESSION['user']['curr_chat'];
    $admin_id= $_POST['adminChat_id'];
    $message = mysqli_real_escape_string($conns, $_POST['message']);


        
    if(!empty($message) OR !empty($student_id)) {
        $insert = mysqli_query($conns,"INSERT INTO chat (chat_msg,chat_receiver,chat_sender) VALUES ('$message','$student_id','$admin_id')") OR die(mysqli_error($conns));
        
        if ($insert) {
            echo "Message inserted successfully.";
        } else {
            echo "Error inserting message: " . mysqli_error($conns);
        }
    } 
    

?>