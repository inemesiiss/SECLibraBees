<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $timestamp = strtotime($row['chat_time']);
        if ($timestamp !== false) {
            $timenow = date('h:i A', $timestamp);
            $datenow = date('M j', $timestamp);
        } else {
            echo "Invalid timestamp value: " . $row['chat_time'];
            // Handle the error as needed
        }
        
        $studSenderID = $row['chat_sender'];
        
  //select the user avatar
  $selAvatar ="SELECT stud_avatar FROM users WHERE stud_number ='$studSenderID'";
  $resultAvatar = mysqli_query($conns, $selAvatar);
     if ($resultAvatar) {
     $rowAvatar = mysqli_fetch_assoc($resultAvatar);
     $stud_avatar = $rowAvatar['stud_avatar'];
     }
  echo '<ul class="list-unstyled mb-0">
<li class="p-2 border-bottom">
<a href="#" class="d-flex justify-content-between" onclick="storeCurrChatId(event, \'' . $row['chat_sender'] . '\')">

  <div class="d-flex flex-row">
    <div>
    <img src="../userViewLibraBees/userpic/'.$stud_avatar.'" alt="./assets/images/student1.png" class="d-flex align-self-center me-3" width="60"  height="60"style="border-radius: 50%;">
    <span class="badge bg-success badge-dot"></span>
</div>';
$selStudInfo = "SELECT * FROM users WHERE stud_number = '$studSenderID'";
$result2 = $conns->query($selStudInfo);

if ($result2->num_rows > 0) {
    while ($row1 = $result2->fetch_assoc()) {
        echo '<div class="pt-1">
            <p class="fw-bold mb-0">' . $row1['stud_first_name'] . ' ' . $row1['stud_last_name'] . '</p>
            <p class="small text-muted">' . $row['chat_msg'] . '</p>
        </div>
    </div>';
    $selStudUnseeChat = "SELECT * FROM chat WHERE chat_sender = '$studSenderID' AND chat_status = 0";
                    $result3 = $conns->query($selStudUnseeChat);
                    if ($result3->num_rows > 0) {
                        // Do something if there are rows returned
                        $rowCount = $result3->num_rows;
                        echo '<div class="pt-1">
                            <p class="small text-muted mb-1">' . $timenow . '</p>
                            <span class="badge bg-danger rounded-pill float-end" style="display: block; font-size: 0.8em;">' . $rowCount . '</span>
                        </div>';
                    }else{
                        $rowCount = $result3->num_rows;
                        echo '<div class="pt-1">
                            <p class="small text-muted mb-1">' . $timenow . '</p>
                            <span class="badge bg-danger rounded-pill float-end" >' . $rowCount . '</span>
                        </div>';

                    }

    }
}
echo '</a>
</li>
</ul>';
}
}

                  ?>