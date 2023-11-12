<?php
session_start();
include '../config/dbconnect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
include_once '../phpmailer/vendor/autoload.php';



date_default_timezone_set('Asia/Manila');
echo "<span style='color:red;font-weight:bold;'>Date: </span>". date('F j, Y g:i:a  ');
$sendEmail_To_Notif_Qry = "SELECT * FROM barrow_book WHERE book_status = 1 AND pickup_dt <= DATE_SUB(CURRENT_TIMESTAMP(),INTERVAL 12 HOUR)";
   $result=$conns-> query($sendEmail_To_Notif_Qry);

   if ($result-> num_rows > 0){
      while ($row=$result-> fetch_assoc()) {

//user email address
        $e_add = $row["email_barrower"];
       $book_title= $row["book_title"];
       $userName= $row["stud_barr_name"];
       $imgBook = $row['book_image'];
       
       try {
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
             $mail->addAddress($e_add, $userName);
 
             //Set email format to HTML
             $mail->isHTML(true);
 
             $mail->Subject = 'Book Pickup Reminder';
              $mail->Body = '
              <html>
              <head>
              <style>
              /* Bee theme styles */
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
              <td align="left" style="padding: 20px 0 30px 0;"
                                            class="text-color font-size">
              <p>Hi Mr/Ms. <b>' . $userName . '</b>,</p>
              <p>This email is to inform you that your book pick up request for the book titled: <b>' . $book_title . '</b> will be cancelled in the next few hours. Please pick up book within 24 hours, the library is open from 8AM to 5pm Mondat to Friday, if you have any concerns kindly reach us.</p>
              <div class="center"><img src="'.$imgBook.'" alt="' . $book_title . '" width="300" height="400"></div>
              <p>Thank you for your understanding.</p>
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
            } catch (phpmailerException $e) {
                echo $e->errorMessage(); //Pretty error messages from PHPMailer
              } catch (Exception $e) {
                echo $e->getMessage(); 
              }
  ?>

        
            
         echo"";
      
  <?php
       
         
      }
  }


   ?>


