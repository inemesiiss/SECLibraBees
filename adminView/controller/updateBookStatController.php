<?php 
session_start();
//if($_SESSION['user']['bookaccess'] == 0){
  //debug_backtrace() || die ("<h2>Access Denied!</h2> Please contact the admin librian"); 
//}
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    include_once '../phpmailer/vendor/autoload.php';

include_once "../config/dbconnect.php";
$borrowID = $_POST['borrow_id'];
$newStatus = $_POST['new_status'];

// Get the current book status and number of copies
$sql = "SELECT * FROM books WHERE book_id = (SELECT book_id FROM barrow_book WHERE barrow_id = $borrowID) LIMIT 1";
$result = $conns->query($sql);
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $currentStatus = $row["book_status"];
  $userName = $row["stud_first_name"]." ".$row["stud_last_name"];
  $book_id = $row["book_id"];
  $book_title = $row["book_title"];
  $book_image = $row["book_image"];
  
} else {
  // Error: couldn't find book
}

// Update the borrow status and timestamps
if ($newStatus == 2) {
  $sql = "UPDATE barrow_book SET barrow_dt = NOW(), book_status = $newStatus WHERE barrow_id = $borrowID AND book_status=1";
  $conns->query($sql);
} elseif ($newStatus == 3)  {
  $sql = "UPDATE barrow_book SET return_dt = NOW(), book_status = $newStatus WHERE barrow_id = $borrowID AND book_status=2";
  $conns->query($sql);
  // Add 1 copy to the book
 
  $sql2 = "UPDATE books SET book_copies = book_copies+1  WHERE book_id = (SELECT book_id FROM barrow_book WHERE barrow_id = $borrowID)";
  $conns->query($sql2);

  $sendRatingToUser = "SELECT * FROM users WHERE stud_number = (SELECT stud_number FROM barrow_book WHERE barrow_id = $borrowID) LIMIT 1";
  $result=$conns-> query($sendRatingToUser);

   if ($result-> num_rows > 0){
      while ($row1=$result-> fetch_assoc()) {
        
        $e_add = $row1['stud_email'];
        $stud_id = $row1['stud_id'];
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

          $mail->Subject = 'Book Rating and Reviews';
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
          <td align="left"
          style="padding: 20px 0 30px 0;"
          class="text-color font-size">
          <p>Hi Mr/Ms. <b>' . $userName . '</b>,</p>
          <p>We hope this message finds you well. We would like to take this opportunity to thank you for borrowing the book titled: <b>' . $book_title . '</b> from our library.</p>
          <p>We value your opinion and would greatly appreciate it if you could take a moment to rate the book using the link below:</p>
          <div class="center"><img src="'.$imgBook.'" alt="' . $book_title . '" width="300" height="400"></div>
          <div style="text-align: center; padding: 30px;">
          <p>Your feedback will help us improve our library services and ensure that we continue to provide you with quality reading materials.</p>
          <p>Thank you for your cooperation and we hope to hear from you soon.</p>
          <br />
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


        
      }
    }
  

}


?>