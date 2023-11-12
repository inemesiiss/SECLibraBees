<?php
date_default_timezone_set('Asia/Manila');
$std_number="5158696";

    include_once "../config/dbconnect.php";
    
    
        $student_id=$_POST['studChat_id'];
        $admin_id=$_POST['adminChat_id'];
        $output="";
        $sql= "SELECT * FROM chat WHERE chat_sender = '$std_number' OR chat_receiver = '$std_number' ORDER BY chat_id";
        $result=$conns-> query($sql);
        if ($result-> num_rows > 0){
          $timestamp = strtotime($row['chat_time']);
                  if ($timestamp !== false) {
                      $timenow = date('h:i A', $timestamp);
                      $datenow = date('M j', $timestamp);
                  } else {
                      echo "Invalid timestamp value: " . $row['chat_time'];
                      // Handle the error as needed
                  }
            while ($row=$result-> fetch_assoc()) {
                if($row['chat_sender'] == "admin"){
                $output= "<div class='outgoing' style=' text-align:right; margin-left: 10px;'><p style='background-color:lightblue; word-wrap: break-word; word-break: break-all; display:inline-block; padding:8px 16px; border-radius: 18px 18px 0 18px;'>".$row['chat_msg']."</p>
                
                        <p class='small me-3 mb-3 rounded-3 text-muted'>".$timenow." | ".$datenow."</p></div>";
                }
                else
                {
                    $output =  "<div style=' text-align:left; margin-left: 10px; margin-right: 40px;'>
                    <img src='images/icon-1.png'
                    alt='images/icon-1.png' style='width: 45px; height: 100%;'>
                    <div>
                      <p style='background-color:yellow; word-wrap: break-word; word-break: break-all; display:inline-block; padding:8px 16px; border-radius: 0 18px 18px 18px;'>".$row['chat_msg']."</p>
                      <p class='small me-3 mb-3 rounded-3 text-muted'>".$timenow." | ".$datenow."</p>
                    </div>
                    
                  </div>";
                }
                echo $output;
            }
            
            
        }
        
        

       
        
            
      
    
    
 
    
?>
