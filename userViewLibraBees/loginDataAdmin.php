<?php
require_once './config/ddbconnect.php';
session_start();

if (isset($_REQUEST['login_btn'])) {
   $adminEmail = filter_var($_REQUEST['ad_email'], FILTER_SANITIZE_STRING);
   $adpassw = $_REQUEST['ad_password'];

   if (!empty($adminEmail) && !empty($adpassw)) {
      $select_stmt = $conn->prepare("SELECT * FROM admin_Lib WHERE admin_user = :admin_user LIMIT 1");
      $select_stmt->execute([':admin_user' => $adminEmail]);
      $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

      if ($select_stmt->rowCount() > 0 && password_verify($adpassw, $row['admin_password'])) {
        
         $_SESSION['user']['ad_email'] = $row['admin_user'];
         $_SESSION['user']['fname'] = $row['admin_fname'];
         $_SESSION['user']['surname'] = $row['admin_sname'];
         $_SESSION['user']['pos'] = $row['admin_pos'];
         $_SESSION['user']['currChat'] = $row['admin_currChat'];
         $_SESSION['user']['bookaccess'] = $row['isBookAccess'];
         $_SESSION['user']['studaccess'] = $row['isStudentAccess'];
         $_SESSION['user']['chataccess'] = $row['isChatAccess'];
         $_SESSION['user']['notifaccess'] = $row['isNotifAccess'];
         $_SESSION['user']['revaccess'] = $row['isReviewsCommsAccess'];
         $_SESSION['user']['isAdmin'] = $row['isMainAdmin'];
         $_SESSION['user']['ademail_verified_at'] = $row['ademail_verified_at'];
         $_SESSION['user']['ad_pass'] = $row['admin_password'];
         $_SESSION['user']['currentChat']="";
         header('Location: https://localhost/thesis/adminView/index.php');

         exit;
      } else {
            $error_message = "Invalid email or password!";
            $error_message_encoded = urlencode($error_message);
            header("Location: loginasadmin.php?error=$error_message_encoded");
      }
   } else {
            $error_message = "Fields are required!";
            $error_message_encoded = urlencode($error_message);
            header("Location: loginasadmin.php?error=$error_message_encoded");
   }
} else {
            $error_message = "Fields are required!";
            $error_message_encoded = urlencode($error_message);
            header("Location: loginasadmin.php?error=$error_message_encoded");
}