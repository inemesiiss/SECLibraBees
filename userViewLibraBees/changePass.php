

<?php
require_once '../config/ddbconnect.php';
session_start();
$std_pass=$_SESSION['user']['std_pass'];
$std_id=$_SESSION['user']['std_id'];

    
    date_default_timezone_set('Asia/Manila');
    $currDate = new DateTime();
    $currDate = $currDate->format('Y-m-d H:i:s');
    $std_newpassword=$_POST['npassword'];
    $std_confirmpassword=$_POST['cpassword'];
    $stdOld_password=$_POST['oldpassword'];
    $hashed_password = password_hash($std_confirmpassword, PASSWORD_DEFAULT);


   if(password_verify($std_newpassword,$_SESSION['user']['std_pass'])) {
    echo "You cannot user your old password!";
   }
  elseif (strlen($std_newpassword)< 8) {
    echo "Must be at least 8 characters";
   }
   elseif (!password_verify($stdOld_password,$_SESSION['user']['std_pass'])) {
    echo "Old password does not match!";
   }
   elseif ($std_newpassword != $std_confirmpassword) {
    echo "New password does not Match!";

   }elseif(!empty($std_newpassword) AND !empty($std_confirmpassword) AND !empty($stdOld_password)) {
    if (password_verify($stdOld_password,$_SESSION['user']['std_pass']) AND $std_newpassword == $std_confirmpassword AND strlen($std_newpassword)>8) {
      $updateQry = "UPDATE users SET stud_password=:stud_password WHERE stud_number = :stud_number Limit 1";
      $insert_stmt = $conn->prepare($updateQry);
      $pdoExe = $insert_stmt->execute(array(':stud_number' => $std_id,':stud_password' => $hashed_password));
      
      if ($pdoExe) {
        echo "success";
      } else {
        echo "Error updating password. Please try again.";
      }
    }

   }
   
   

?>




