<?php
session_start();
    include_once "../config/dbconnect.php";
    include_once '../phpmailer/vendor/autoload.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    $aduserid = $_POST['aduserid'];
    
       if($_POST['adpass'] == $_POST['adcpass']){
        
        if (filter_var($aduserid, FILTER_VALIDATE_EMAIL)) {
            $query = "SELECT * FROM admin_Lib WHERE admin_user = '$aduserid'";
            $result = mysqli_query($conns, $query);
            if (mysqli_num_rows($result) > 0) {
                echo"Email already exist!";   
            }else{
                

       
        $adpos = $_POST['adpos'];
        $adfname= $_POST['adfname'];
        $adsname = $_POST['adsname'];
        $aduserid = $_POST['aduserid'];
        $adpass = $_POST['adpass'];
        $bookMngt= $_POST['bookManagementAccess'];
        $studMngt= $_POST['studManagementAccess'];
        $chatMngt= $_POST['chatManagementAccess'];
        $notifMngt= $_POST['notifManagementAccess'];
        $revComMngt= $_POST['revCommssMngtAccess'];
        $userFullname = $adfname." ".$adsname;
        $newVerification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
        $hashed_password = password_hash($adpass, PASSWORD_DEFAULT);
         $insert = mysqli_query($conns,"INSERT INTO admin_Lib
         (admin_pos,admin_fname,admin_sname,admin_user,admin_password,isBookAccess,isStudentAccess,isChatAccess,isNotifAccess,isReviewsCommsAccess,adverification_code) VALUES ('$adpos','$adfname','$adsname','$aduserid','$hashed_password',$bookMngt,$studMngt,$chatMngt,$notifMngt,$revComMngt,$newVerification_code )");

          


 
         if(!$insert)
         {
             echo mysqli_error($conns);
         }
         else
         {
            echo "success";  
            // send email t0 the user containing verfication code
          $mail = new PHPMailer(true);

          //Enable verbose debug output
          $mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;

          //Send using SMTP
          $mail->isSMTP();

          //Set the SMTP server to send through
          $mail->Host = 'smtp.gmail.com';

          //Enable SMTP authentication
          $mail->SMTPAuth = true;

          //SMTP username
          $mail->Username = 'seclibrabees@gmail.com';

          //SMTP password
          $mail->Password = 'nynjfgxjlnscaont';

          //Enable TLS encryption;
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

          //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
          $mail->Port = 587;

          //Recipients
          $mail->setFrom('seclibrabees@gmail.com', 'seclibrabees.com');

          //Add a recipient
          $mail->addAddress($aduserid, $userFullname );

          //Set email format to HTML
          $mail->isHTML(true);

         
         $mail->Subject = 'Admin Account Verification';
         $mail->Body = '
         <html>
        <head>
        <style>

        /* Bee theme styles */
        body {
        background-color: #BDBDBD;
        }
        .bg-color {
        background-color: #F5A623;
        }
        .text-color {
        color: #000000;
        }
        .font-size {
        font-size: 18px;
        }
        </style>
        </head>
        <body>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
        <td align="center" valign="top">
        <table width="600" border="0" cellspacing="0" cellpadding="0">
        <tr>
        <td class="bg-color" height="100" align="center" valign="middle">
        <h1 class="text-color" style="font-size: 36px; font-weight: bold;">SECLibraBees</h1>
        </td>
        </tr>
        <tr>
        <td align="center" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
        <td align="center" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
        <td align="left"
                                    style="padding: 20px 0 30px 0;"
                                    class="text-color font-size">
        <p>Dear Mr/Ms. <b>' . $userFullname. '</b>,</p>
        <p>Your verification code for verifying of your admin account is: <b style="font-size: 30px; background-color: #F5A623; padding: 5px 10px; border-radius: 5px;">' . $newVerification_code . '</b></p>
        <p>Please enter this code in the verification page along with your new password in verification page after logging in.</p>
        <p>Thank you for using SecLibraBees!</p>
        <br>
        <p>Best regards,</p>
        <p>The SECLibraBees Team</p>
        </td>
        </tr>
        </table>
        </td>
        </tr>
        <tr>
        <td align="center" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
        <td align="center" valign="top" class="bg-color" height="50" style="border-radius: 0px 0px 10px 10px;">
        <p class="text-color" style="margin: 0; padding: 10px; font-size: 12px;">This email was sent by SECLibraBees Library System.</p>
        </td>
        </tr>
        </table>
        </td>
        </tr>
        </table>
        </td>
        </tr>
        </table>
        </td>
        </tr>
        </table>
        </body>
        </html>';
          $mail->send();
         }
        
        }
     
    }else{
        echo"Email is not Valid";
    }
   
}else{
    echo"Admin password does not Match!";
}
?>