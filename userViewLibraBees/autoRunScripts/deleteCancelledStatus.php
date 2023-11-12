<?php
session_start();
include '../config/dbconnect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
include_once '../phpmailer/vendor/autoload.php';

date_default_timezone_set('Asia/Manila');
echo "<span style='color:red;font-weight:bold;'>Date: </span>". date('F j, Y g:i:a  ');

$delBarrowBook24hours = "SELECT * FROM barrow_book WHERE book_status = 1 AND pickup_dt <= DATE_SUB(CURRENT_TIMESTAMP(),INTERVAL 1 DAY)";
   $result=$conns-> query($delBarrowBook24hours);

   if ($result-> num_rows > 0){
      while ($row=$result-> fetch_assoc()) {

//user email address
        $e_add = $row["email_barrower"];
       $book_title= $row["book_title"];
       $userName= $row["stud_barr_name"];
       $bookid= $row["book_id"];
       
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
             $mail->addAddress($e_add, $book_title);
 
             //Set email format to HTML
             $mail->isHTML(true);   
 
             $mail->Subject = 'Book Cancellation Notice';
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
              <h1 class="text-color" style="font-size: 36px; font-weight: bold;">SecLibraBees</h1>
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
              <p>Hi Mr/Ms. <b>' . $userName . '</b>,</p>
              <p>We regret to inform you that your book pick up request for the book titled: <b>' . $book_title . '</b> has been cancelled due to 24 Hours Cancellation Timer. Please contact the library if you have any concerns.</p>
              <div class="center"><img src="../adminView' . $row['book_image'] . '" alt="' . $book_title . '" width="300" height="400"></div>
              <p>Thank you for your understanding.</p>
              <br>
              <p>Best regards,</p>
              <p>The SecLibraBees Team</p>
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
              <p class="text-color" style="margin: 0; padding: 10px; font-size: 12px;">This email was sent by SecLibraBees Library System.</p>
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
            
            ///DELETE REQUEST IF MORE THAN 24hours in FOR PICK UP STATUS
              $delquery="DELETE FROM barrow_book WHERE pickup_dt <= DATE_SUB(CURRENT_TIMESTAMP(),INTERVAL 1 DAY) AND book_status <=1";

              $data=mysqli_query($conns,$delquery);
              /// Update the book copies to +1 since the if the cook has been cancleed

              $updatebook_copy = mysqli_query($conns,"UPDATE books SET book_copies=book_copies+1 where book_id='$bookid '");

              if($data AND $updatebook_copy){
                  echo"Cancelled Books Deleted";
              }
              else{
                  echo"Not able to delete";
              }
            } catch (phpmailerException $e) {
              echo $e->errorMessage(); //Pretty error messages from PHPMailer
            } catch (Exception $e) {
              echo $e->getMessage(); 
            }

  ?>

        
            
         
      
  <?php
         
         
      }
  }


   ?>


