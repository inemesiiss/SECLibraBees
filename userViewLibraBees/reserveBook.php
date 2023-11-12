<?php

require './config/ddbconnect.php';
require "../config/dbconnect.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/vendor/autoload.php';


session_start();
if (!isset($_SESSION['user'])) {
   header('location:login.php');
}
$student_Number=$_SESSION['user']['std_id'];

if ($result=mysqli_query($conns,$sql))
  {
  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($result);
  printf("Result set has %d rows.\n",$rowcount);
  // Free result set
  mysqli_free_result($result);
  }
// setting the time zone before the email
date_default_timezone_set('Asia/Manila');
$currDate = new DateTime();
      $currDate = $currDate->format('Y-m-d H:i:s');
      $barrowStatus = 1;
      $e_add=$_SESSION['user']['email'];

if (isset($_POST['Reserve'])       ) {
   echo "<pre>";
   print_r($_POST);
   echo "</pre>";
   
   $bookid = $_POST['book_id'];
   $studnum = $_SESSION['user']['std_id'];
   $stud_Fullname = $_SESSION['user']['fullname'];
   $book_title = $_POST['book_title'];
   $book_auth = $_POST['book_auth'];
   $book_img = $_POST['book_img'];
   $book_dcb = $_POST['dcb'];
   $pickupdate = $currDate;
   $bookstat = $barrowStatus ;
   $book_copyUpdt = $_POST['book_Cop_Update'];
   
   $insert = mysqli_query($conns,"INSERT INTO reserve_book
   (stud_number,book_id) VALUES ('$studnum','$bookid')");
$fullname=$_SESSION['user']['fullname'];


        
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
             $mail->addAddress($e_add, $fullname);
 
             //Set email format to HTML
             $mail->isHTML(true);
 
             $mail->Subject = 'Reservation Successful';
             $mail->Body    = '<p>Hi Mr/Ms. $fullname please be informed that we will email your right away if the book is available</p>';
 
             $mail->send();
             $notif_title="Reservation Successful";
             $notif_msg="You have reserve the book titled $book_title, please be informed that we will email your right away if the book is available.";
             
             
             
             $insertNotif = mysqli_query($conns,"INSERT INTO notifications 
             (notif_title,notif_msg,send_to,notif_time) VALUES ('$notif_title','$notif_msg','$studnum','$currDate')");
          
          
          
          


   if(!$insert AND !$updatebook_copy )
   {
       echo mysqli_error($conns);
       
   }
   else
   {
       echo "Records added successfully.";
       header("Location:mybook.php");
   }

}
?>