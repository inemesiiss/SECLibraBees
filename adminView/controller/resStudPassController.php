<?php
    include_once "../config/dbconnect.php";
    include_once "../config/dbconnect.php";
    include_once '../phpmailer/vendor/autoload.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $random_string = substr(str_shuffle($characters), 0, 8);
    $stud_number=$_POST['record'];
    $hashed_password = password_hash($random_string, PASSWORD_DEFAULT);
    $query="UPDATE users SET stud_password = '$hashed_password' WHERE stud_number ='$stud_number'";
    $data=mysqli_query($conns,$query);


    if($data){
        $selUser = "SELECT * FROM users WHERE stud_number = '$stud_number'";
        $result = $conns->query($selUser);
        
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $stud_number=$row["stud_number"];
            $stud_email=$row["stud_email"];
            $full_name=$row["stud_first_name"]." ".$row["stud_last_name"];   
        }

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
        $mail->addAddress($stud_email, $userFullname );

        //Set email format to HTML
        $mail->isHTML(true);

       
       $mail->Subject = 'Reset Password Successful';
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
      <p>Dear Mr/Ms. <b>' . $full_name. '</b>,</p>
      <p>Please be informed that your password has been successfully reset. Here is your temporary password: <b style="font-size: 30px; background-color: #F5A623; padding: 5px 10px; border-radius: 5px;">' . $random_string . '</b></p>
      <p>Please enter this password and change your password right away once you logged in.</p>
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
    else{
        echo"Not able to delete";
    }
    
?>