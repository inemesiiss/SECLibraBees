<?php
session_start();

$admin_id=$_SESSION['user']['ad_email'];
    include_once "../config/dbconnect.php";
    $selChat = "SELECT * FROM admin_Lib WHERE admin_user = '$admin_id'";
     $result = mysqli_query($conns, $selChat);

     if ($result) {
        $row = mysqli_fetch_assoc($result);
      $currChat = $row['admin_currChat'];
        
        
      } else {
         
        echo "Error: " . mysqli_error($conns);
     }
    

    // Get the value sent through AJAX
    //if (isset($_SESSION['user']['current_stud_chat'])) {
      // Set the current student chat in the session
     
     
     // $std_number = $_SESSION['user']['current_stud_chat'];
    //} else {
      // Get the chat_sender value of the latest chat
      //$sel1stChat = "SELECT chat_sender FROM chat ORDER BY chat_time DESC LIMIT 1";
     // $result = mysqli_query($conns, $sel1stChat);
    
    //  if ($result) {
      //  $row = mysqli_fetch_assoc($result);
      //  $std_number = $row['chat_sender'];
        // Do something with $std_id
        
      //} else {
        // Handle query error
        //echo "Error: " . mysqli_error($conn);
     // }
    //}
    
    
        $student_id=$_POST['studChat_id'];
        $admin_id=$_POST['adminChat_id'];
        $output="";
        $sql= "SELECT * FROM chat WHERE chat_sender = '$currChat' OR chat_receiver = '$currChat' ORDER BY chat_id DESC";
        $result=$conns-> query($sql);
        if ($result-> num_rows > 0){
            while ($row=$result-> fetch_assoc()) {
              $timestamp = strtotime($row['chat_time']);
                  if ($timestamp !== false) {
                      $timenow = date('h:i A', $timestamp);
                      $datenow = date('M j', $timestamp);
                  } else {
                      echo "Invalid timestamp value: " . $row['chat_time'];
                      // Handle the error as needed
                  }
                if($row['chat_sender'] == "admin"){
                  $output= "<div class='outgoing' style=' text-align:right; margin-left: 10px;'><p style='background-color:lightblue; word-wrap: break-word; word-break: break-all; display:inline-block; padding:8px 16px; border-radius: 18px 18px 0 18px;'>".
                  $row['chat_msg']."</p>
                  
                          <p class='small me-3 mb-3 rounded-3 text-muted'>".$timenow." | ".$datenow."</p></div>";
                }
                else
                {
                  $output =  "<div style=' text-align:left; margin-left: 10px; margin-right: 40px;'>
                    
                  <div>
                    <p style='background-color:yellow; word-wrap: break-word; word-break: break-all; display:inline-block; padding:8px 16px; border-radius: 0 18px 18px 18px;'>".$row['chat_msg']."</p>
                    <p class='small me-3 mb-3 rounded-3 text-muted'>".$timenow." | ".$datenow."</p>
                  </div>
                  
                </div>";

                }
                echo $output;
                
            }
            
            
        }else{
          echo"No Chat Records";
        }
        
        

       
        
            
      
    
    
 
    
?>
