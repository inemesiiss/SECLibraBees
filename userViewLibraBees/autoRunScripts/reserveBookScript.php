<?php

include '../config/dbconnect.php';
//import php mailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
include_once '../phpmailer/vendor/autoload.php';

date_default_timezone_set('Asia/Manila');//to set the timezone to manila
echo "<span style='color:red;font-weight:bold;'>Date: </span>" . date('F j, Y g:i:a  ');
$currDate = new DateTime();
$currDate = $currDate->format('Y-m-d H:i:s');// to get the current date
$barrowStatus = 1;// Set the book status to 1 = For pick up
$Reserveloop = "SELECT * FROM reserve_book"; // will set the loop of how many reserve books will process
$result=$conns-> query($Reserveloop);
   
      if ($result-> num_rows > 0){
         while ($row4=$result-> fetch_assoc()) {
//Select the Reserve books and all the books who are equals to book ID and then group them by book id
$selectBooksReserve = "SELECT reserve_book.*, books.*
FROM reserve_book
LEFT JOIN books ON reserve_book.book_id = books.book_id
WHERE reserve_book.book_id = books.book_id
GROUP BY books.book_id
ORDER BY reserve_book.reserve_time ASC";
// debugger
$result = $conns->query($selectBooksReserve);
if ($result) {
  echo "select done.<br>";
} else {
  echo "Error executing select statement: " . mysqli_error($conns) . "<br>";
}
if ($result) {
    while ($row = $result->fetch_assoc()) {
        if ($row["book_copies"] > 0) {
            $stud_id = $row["stud_number"];
            // get the book id of reserved book that has book copies of more than 0
            $bookid = $row["book_id"];
            $book_copyUpdt = $row["book_copies"];
            $selectBooksNStud = "SELECT b.*, s.*
                                 FROM books b
                                 LEFT JOIN users s ON s.stud_number = $stud_id 
                                 WHERE b.book_id=$bookid LIMIT 1";
            $result2 = $conns->query($selectBooksNStud);// select all the books information and users information that will equal reserve bookid and stud id
            if ($result2) {
              echo "Inner select statement executed successfully.<br>";
                while ($row2 = $result2->fetch_assoc()) {
                    $stud_num = $row2["stud_number"];
                    $book_title = $row2["book_title"];
                    $book_auth = $row2["book_author"];
                    $book_img = $row2["book_image"];
                    $book_dcb = $row2["days_can_barrowed"];
                    $stud_Fullname = $row2["stud_first_name"] . " " . $row2["stud_last_name"];
                    $e_add = $row2["stud_email"];
                    //insert all book thats that has copies into barrow book and set the status into for pick up
                    $insert = mysqli_query($conns, "INSERT INTO barrow_book
                                                    (stud_number, book_id, book_title, book_author, book_image, pickup_dt, book_status, email_barrower, days_can_barrowed, stud_barr_name) 
                                                    VALUES ('$stud_num', '$bookid', '$book_title', '$book_auth', '$book_img', '$currDate', '$barrowStatus', '$e_add', '$book_dcb', '$stud_Fullname')");
                                                    if ($insert) {
                                                      echo "Insert statement executed successfully.<br>";
                                                  } else {
                                                      echo "Error executing insert statement: " . mysqli_error($conns) . "<br>";
                                                  }
                    // will update the book copies into -1
                    $updatebook_copy = mysqli_query($conns, "UPDATE books SET book_copies = $book_copyUpdt - 1 WHERE book_id = '$bookid'");
                    if ($updatebook_copy) {
                      $deleteResRecord = mysqli_query($conns, "DELETE FROM reserve_book where book_id='$bookid'");

                      echo "Update statement executed successfully.<br>";
                  } else {
                      echo "Error executing update statement: " . mysqli_error($conns) . "<br>";
                  }
                    // will send email to the user that book reservatiion is successful and they need to get the book rught away
                    try {
                        $mail = new PHPMailer(true);

                        //Enable verbose debug output
                        $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;

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
             $mail->addAddress($e_add, $stud_Fullname);
 
             //Set email format to HTML
             $mail->isHTML(true);
 
             $mail->Subject = 'Reservation Book SuccessFul';
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
              <p>Hi Mr/Ms. <b>' . $stud_Fullname . '</b>,</p>
              <p>Thank you for making a reservation with us! We are happy to inform you that your Reservatioon Book Titled: <b>' . $book_title . '</b> is successful, and the book you requested has been added to your pick up list. Please note that you have 24 hours to pick up the book from our library. After 24 hours, the reservation will be canceled, and the book will be made available to other patrons. the library is open from 8AM to 5pm Monday to Friday, if you have any concerns kindly reach us.</p>
              <div class="center"><img src="'.$imgBook.'" alt="' . $book_title . '" width="300" height="400"></div>
              <p>Thank you for your understanding.</p>
               <br />
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
            } catch (phpmailerException $e) {
                echo $e->errorMessage(); //Pretty error messages from PHPMailer
              } catch (Exception $e) {
                echo $e->getMessage(); 
              }
            }
          }
        }
      }
    }
         }}
  ?>

        
            
         
      
 