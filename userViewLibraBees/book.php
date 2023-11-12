<?php
require './config/ddbconnect.php';
require "../config/dbconnect.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/vendor/autoload.php';
session_start();
if (isset($_SESSION['user'])) {
   if ($_SESSION['user']['verify_status'] == null) {
     header("Location: verifyemail.php");
     exit();
   } else {
     // this code will be executed when the user is verified
     
   }
 } else {
   // user is not logged in, redirect to login page
   header("Location: login.php");
   exit();
 }
$student_Number=$_SESSION['user']['std_id'];
$yr_lvl=$_SESSION['user']['yr_lvl'];
// getting the bookid posses by the users
$myBooksID=array();
$sqlBook_Id_Mybook="SELECT book_id FROM barrow_book WHERE stud_number = '$student_Number' AND book_status <= 2";
$statement = $conn->query($sqlBook_Id_Mybook);
$book_id_mybook = $statement->fetchAll(PDO::FETCH_ASSOC);
// display
foreach ($book_id_mybook as $book_id_mybooks) {
   $myBooksID[]=$book_id_mybooks['book_id'];
    
}
// getting the number of books possesed by the user
      $sql="SELECT * FROM barrow_book WHERE stud_number = '$student_Number' AND book_status <= 2";

if ($result=mysqli_query($conns,$sql))
  {
  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($result);
  //printf("Result set has %d rows.\n",$rowcount);
  // Free result set
  mysqli_free_result($result);
  }
// setting the time zone before the email
date_default_timezone_set('Asia/Manila');
$currDate = new DateTime();
      $currDate = $currDate->format('Y-m-d H:i:s');
      $barrowStatus = 1;
      $e_add=$_SESSION['user']['email'];
      

require './config/dbconnect.php';

if (isset($_POST['Barrow'])       ) {
   
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
   $insert = mysqli_query($conns,"INSERT INTO barrow_book
   (stud_number,book_id,book_title,book_author,book_image,pickup_dt,book_status,email_barrower,days_can_barrowed,stud_barr_name) VALUES ('$studnum','$bookid',' $book_title','$book_auth','$book_img','$pickupdate','$bookstat','$e_add','$book_dcb','$stud_Fullname')");
   $fullname=$_SESSION['user']['fullname'];
   $updatebook_copy = mysqli_query($conns,"UPDATE books SET book_copies=$book_copyUpdt where book_id='$bookid'");
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
             $mail->Subject = 'Book Borrow Request Successful';
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
            <td align="left" style="padding: 20px 0 30px 0;" class="text-color font-size">
            <p>Hi <b>' . $fullname . '</b>,</p>
            <p>Your book borrow request for <b>' . $book_title . '</b> has been successful.</p>
            <p>You may now pick up the book from the library within 24 hours. Please be reminded to bring a valid ID when claiming the book.</p>
            <p>Thank you for using SECLibraBees Library System.</p>
            <br />
            <p>Best regards,</p>
            <p>The SEC Team</p>
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
            </body>
            </html>';
            $mail->send();
             $notif_title="Borrow Request Successful";
             $notif_msg="Kindly note that you have requested to borrow the book entitled $book_title. Please be advised that you are required to pick up the book at the library within the next 24 hours. Failure to do so will result in cancellation of your request.";
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

if (isset($_POST['Reserve'])       ) {
   
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
             $mail->Subject = 'Book Reservation Successful';
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
            <td align="left" style="padding: 20px 0 30px 0;" class="text-color font-size">
            <p>Hi <b>' . $fullname . '</b>,</p>
            <p>Your book reservation request for <b>' . $book_title . '</b> has been successful.</p>
            <p>Kindly anticipate and will email you right away once we have gained stock on this specific book.</p>
            <p>Thank you for using SECLibraBees Library System.</p>
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
            </body>
            </html>';
            $mail->send();
             $notif_title="Book Reservation Successful";
             $notif_msg="Kindly be informed that you have reserved the book titled [$book_title]. An email will be sent to you once the book becomes available. Thank you";
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


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>SECLibraBees</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <!-- swiper css link  -->
   <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   <!-- custom css file link  -->
   <link rel="icon" type="image/x-icon" href="LB.ico">
   <link rel="stylesheet" href="css/style.css">
</head>
<body style="background-color: #FCD116;">
   
<!-- header section starts  -->

<section class="header">
<a href="home.php" class="logo" style="text-decoration: none;"><img src="images/LB.png" alt="" style="  height: 3rem; margin-left: 1.5rem;"> LibraBees</a>
<div class="box">
   <?php
   $selAvatar ="SELECT stud_avatar FROM users where stud_number ='$student_Number'";
   $result = mysqli_query($conns, $selAvatar);
      if ($result) {
      $row = mysqli_fetch_assoc($result);
      $stud_avatar = $row['stud_avatar'];
      }
   ?>
         
         
         <h6></h6>
      </div>


   <nav class="navbar">
   <div class="box">
         <img style="height: 3rem;" id="myNotifImg" src="images/icon-5.png" alt="">
         <span class="badge bg-danger rounded-pill float-end" style="font-size:1rem;" id="notifNum"></span>
      </div>
   
      <a href="home.php">HOME</a>   
      <a href="mybook.php">MYBOOKS</a>
      <a href="libraryMain.php">LIBRARY</a>
      <a href="#" onclick="logout();" >
         <img src="userpic/<?php echo ($stud_avatar != null) ? $stud_avatar : 'images/student1.png'; ?>" alt="Profile Picture" style="border-radius: 50%;   margin-left: 1.5rem;" width="45" height="45">
         log out
      </a>
      
   </nav>
   

   <div id="menu-btn" class="fas fa-bars"></div>

</section>

<!-- header section ends -->

<div class="heading" style="background:url(images/header-bg-3.png) no-repeat">
   
</div>
<!-- booking section starts  -->
<section class="booking">
<h1 class="heading-title">Borrow your Books</h1>
<?php
try {
    include_once  './config/dbconnect.php';
   $book_IDS = $_GET['currBook_ID'];
   $_SESSION['user']['book_id'] =$_GET['currBook_ID'];
    $usr_std_num= $_SESSION['user']['std_id'];
    $qry=mysqli_query($conns, "SELECT * FROM books WHERE book_id='$book_IDS'");
    
    $numberOfRow=mysqli_num_rows($qry);
    if($numberOfRow>0){
       while($row1=mysqli_fetch_array($qry))
       {
?>
 <form method="post"  class="book-form" action= "">

<div class="flex">
<div class="box">
   <div class="image">
         <img height="400px" src='../adminView<?=$row1["book_image"]?>' >
         <input type="text" name="book_img" value="<?php echo $row1['book_image']?>" hidden>
      </div>
   </div>
   <div class="inputBox">
      <span>Book Description :</span>
      <p style="width: 90%; word-wrap: break-word; word-break: break-all;" ><?=$row1['book_desc']?></p>
   </div>
      <input type="text" name="book_id" value="<?php echo $row1['book_id']?>" hidden>
   <div class="inputBox">
      <span>Book Title :</span>
      <input readonly type="text"  name="book_title" value="<?=$row1['book_title']?>">
   </div>
   <div class="inputBox">
      <span>Book Author :</span>
      <input readonly type="text"  name="book_auth" value="<?=$row1['book_author']?>">
   </div>
   <div class="inputBox">
      <span>Year Publish :</span>
      <input readonly type="text"  value="<?=$row1['publication_date']?>"disabled>
   </div>
   <div class="inputBox">
      <span> Section >  Category >  Subject : </span>
      <input type="text"  id="book_sub" value="<?=$row1['category_id']?>  > <?=$row1['bookcategory_id']?> > <?=$row1['booksubject_id']?>"disabled>
   </div>
   <div class="inputBox">
      <span>Student Number :</span>
      <input type="text"  name="stud_number" value="<?php echo $usr_std_num?>"disabled>
   </div>
   <div class="inputBox">
      <span>Borrow Duration: (days)</span>
      <input readonly type="number"   name="dcb" value="<?=$row1['days_can_barrowed']?>">
   </div>
   <div class="inputBox">
      <span>Pick-up Time:</span>
      <input type="text"  name="pick_up_dt" value="Within 24 Hours" disabled>
   </div>
   <div class="inputBox">
   <span id="bookCopNum" ></span>
      <span>Book Status :</span>
      <?php
       //echo $bookCopiesLive;
      if($row1['book_copies'] > 0){
         echo "<input type='text'  name='bookstat' value='Available' disabled>";
      }
      else{
        echo "<input type='text'  name='bookstat' value='For Reserve' disabled>";
      }
      ?>
   </div>
   <div class="inputBox">
      <input readonly type="text"   name="book_Cop_Update" value="<?=$row1['book_copies'] -1?>" hidden>
   </div>
</div>
<?php


// condition for button if book copies is 0 and user have already 3 book in my book page
if($rowcount < 3 && !in_array($row1['book_id'],$myBooksID)){
   echo "<input type='submit' value='Borrow' class='btn' name='Barrow' id='barrowBtn'>";
   echo "<input type='submit' value='Reserve' class='btn' name='Reserve' id='reserveBtn'>";
}
elseif($rowcount>=3){
   echo "<input type='submit' value='Borrow' class='btn' name='Barrow' id='barrowBtn' disabled>";
   echo "<input type='submit' value='Reserve' class='btn' name='Reserve' id='reserveBtn' disabled>";
   echo "<p class='alert' style='color: red'>&#9888 Only 3 books can be barrow at the same time!</p>";
}

elseif(in_array($row1['book_id'],$myBooksID)){
   echo "<input type='submit' value='Borrow' class='btn' name='Barrow' id='barrowBtn'disabled>";
   echo "<input type='submit' value='Reserve' class='btn' name='Reserve' id='reserveBtn' disabled>";
   echo "<p class='alert' style='color: red'>&#9888 This book is already in your My book!</p>";
}
?>
<p class='alert' id="reserveAlertMsg" style='color: red' >&#9888 This book is currently for Reserve!</p>
<p class='alert' id="reserveLimitReach" style='color: red; ' >&#9888 You have reach the Maximum number of Reserve!</p>

</form>
<section class="reviews">
   <h1 class="heading-title"> Student reviews </h1>
   <?php
      $GetAllReview = $conn->prepare("SELECT * FROM `review` WHERE book_id = ? AND status = 1");
      $GetAllReview->execute([$book_IDS ]);
      if($GetAllReview->rowCount() > 0){
         while($fetch_post = $GetAllReview->fetch(PDO::FETCH_ASSOC)){
        $total_ratings = 0;
        $rating_1 = 0;
        $rating_2 = 0;
        $rating_3 = 0;
        $rating_4 = 0;
        $rating_5 = 0;
        $select_ratings = $conn->prepare("SELECT * FROM `review` WHERE book_id = ? AND status = 1");
        $select_ratings->execute([$fetch_post['book_id']]);
        $total_reivews = $select_ratings->rowCount();
        while($fetch_rating = $select_ratings->fetch(PDO::FETCH_ASSOC)){
            $total_ratings += $fetch_rating['ratingNumber'];
            if($fetch_rating['ratingNumber'] == 1){
               $rating_1 += $fetch_rating['ratingNumber'];
            }
            if($fetch_rating['ratingNumber'] == 2){
               $rating_2 += $fetch_rating['ratingNumber'];
            }
            if($fetch_rating['ratingNumber'] == 3){
               $rating_3 += $fetch_rating['ratingNumber'];
            }
            if($fetch_rating['ratingNumber'] == 4){
               $rating_4 += $fetch_rating['ratingNumber'];
            }
            if($fetch_rating['ratingNumber'] == 5){
               $rating_5 += $fetch_rating['ratingNumber'];
            }
            if($total_reivews != 0){
               $average = round($total_ratings / $total_reivews, 1);
           }else{
               $average = 0;
           }
        }
      }
   }else{
      $average = 0;
      $total_reivews ="No ";
   }
?>
   <div class="swiper reviews-slider">
   <div class="flex">
            <div class="swiper-slide slide">
               <h3><?= $average; ?><i class="fas fa-star"></i></h3>
               <p><?= $total_reivews; ?> reviews</p>
            </div>
         </div>
         <br></br>
         <?php
///// getting the announcerment
      require './config/dbconnect.php';
      $selectReviews = "SELECT r.*, u.stud_first_name, u.stud_last_name, u.stud_avatar 
      FROM review r 
      LEFT JOIN users u ON r.stud_id = u.stud_number 
      WHERE r.book_id = $book_IDS AND r.status = 1
      ORDER BY r.created ASC";
         $result=$conns-> query($selectReviews);
      if ($result-> num_rows > 0){
         while ($row=$result-> fetch_assoc()) {      
   ?>
<div class="swiper">
<div class="swiper-slide slide">
  <div class="rating-comments">
    <div class="stars">
      <?php
      $value = $row['ratingNumber'];
      for ($i = 1; $i <= 5; $i++) {
        if ($value >= $i) {
          echo '<i class="fas fa-star"></i>' . PHP_EOL;
        } else {
          echo '<i class="far fa-star"></i>' . PHP_EOL;
        }
      }
      ?>
    </div>
    <p><?=$row["comments"]?></p>
  </div>
  <div class="student-info">
    <img src="userpic/<?=$row["stud_avatar"]?>" alt="Anonymous" style="border-radius: 50%; height: 7rem;">
    
      <span style="color: #222;"><?=$row["stud_first_name"] . ' ' . $row["stud_last_name"]?></span>
      <span style="color: #222;">Student</span>
    </div>
  </div>
</div>

<?php
                     }
               }else{
                  echo "";
                  
                  
               }

               ?>
      </div>
   </div>
</section>
    <?php
    		}
    	}
   }
   catch(Exception $e) {
      echo 'Message: ' .$e->getMessage();
    }
    ?>
    <h1 class="heading-title">BORROW AND LEARN!</h1>

   </div>
</section>

<!-- booking section ends -->


<!-- .Notification Modal -->
<div class="modal fade" id="myNotifModal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
         <h1 class="modal-title">Notification</h1>   
         <button type="button" class="close" style="font-size: 3rem; background-color: #FCD116;"data-bs-dismiss="modal">&times;</button>                                                           
			</div> 
			<div class="modal-body" id="modal-body" style="height:500px; overflow-y: scroll;">
            <div>
            <h1> Announcement </h1>
         <?php
         // getting the announcement
               require './config/dbconnect.php';
               $sql = "SELECT *
               FROM notifications
               WHERE (send_to = 'All' AND CURDATE() BETWEEN notif_time AND notif_end)
                  OR (send_to = '$yr_lvl' AND CURDATE() BETWEEN notif_time AND notif_end)
               ORDER BY notif_time DESC";
                  $result=$conns-> query($sql);
               if ($result-> num_rows > 0){
                  while ($row=$result-> fetch_assoc()) {    
            ?>
            <div><h2 style="float:left;"><?=$row["notif_title"]?></div>
            <input class="myNotifButton bee-theme" type="button" value="Read"></input>
               <div class="notifcontainer" style='text-align:right;'>
               <div style="background-color: #fbee34; border: 2px solid #f6c90e; border-radius: 5px; padding: 10px; margin-bottom: 10px;">
                     <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                     <h6><?=$row["notif_time"]?></h6>
                     </div>
                     <div style="background-color:#fff; border-radius: 5px; padding: 10px;">
                     <h2 style="font-size: 14px; margin: 0; text-transform: none; text-align: justify;"><?=$row["notif_msg"]?>.</h2>
                     </div>
                     <div style="display: flex; justify-content: flex-end; margin-top: 5px;">
                     </div>
                     </div>
               </div>
               <hr />
               <?php
                     }
               }else{
                  echo"<div style='text-align: center;'>
                 Currently No Announcement. 
                  </div>";
               }
               ?>
               </div>
               <div>
               <h1>  Book Notification </h1>
         <?php
         // getting the notification based on student ID,year level and ALL filter
               require './config/dbconnect.php';
               $std_id=$_SESSION['user']['std_id'];
               $sqlBookNotif = "SELECT * FROM notifications WHERE send_to ='$std_id' ORDER BY publish_dt DESC";
                  $result=$conns-> query($sqlBookNotif);

               if ($result-> num_rows > 0){
                  while ($row=$result-> fetch_assoc()) {
            ?>
            <div><h2 style="float:left"><?=$row["notif_title"]?></h2></div>
            <input class="myNotifButton bee-theme" type="button" value="Read"></input>
            <div  class="notifcontainer" style='text-align:right;'>
                     <div style="background-color: #fbee34; border: 2px solid #f6c90e; border-radius: 5px; padding: 10px; margin-bottom: 10px;">
                     <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                     <h6><?=$row["notif_time"]?></h6>
                     </div>
                     <div style="background-color:#fff; border-radius: 5px; padding: 10px;">
                     <h2 style="font-size: 14px; margin: 0; text-transform: none; text-align: justify;"><?=$row["notif_msg"]?>.</h2>
                     </div>
                     <div style="display: flex; justify-content: flex-end; margin-top: 5px;">
                     </div>
                     </div>
               </div>
               <?php
                     }
                     
                     
               }else{
                  echo"<div style='text-align: center;'>
                 Currently No Book Notification. 
                  </div>";
               }

               ?>
               </div>
			</div>  
		</div>                                                                       
	</div>                                      
</div>








<!-- swiper js link  -->
<script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.6.0/jq-3.6.0/dt-1.13.1/datatables.min.js"></script>
    

</body>


</html>
<style>
#reserveBtn {
  background-color: #FCD116;
  color: #222;
}

</style>
<script type="text/javascript">
      ////gets the number of book copies live
   $(document).ready(function () {
      setInterval(function() {
         $.post("getBookCopies.php",{data:'get'},function (
            data) {
                  if (parseInt(data) <= 0) {
               $("#barrowBtn").hide();
               $("#reserveBtn").show();
            } else {
               $("#reserveBtn").hide();
               $("#barrowBtn").show();
            }
            });
      },500);
      
   });
      ////gets the number of reserve book if the book has a reservation it will disable the reserve button. 
      $(document).ready(function () {
      setInterval(function() {
         $.post("getNumOfReseve.php",{data:'get'},function (
            data) {
               
               console.log(data);
               if(data>0){
                  $("#reserveBtn").attr("disabled", "disabled");
                  $("#barrowBtn").attr("disabled", "disabled");
                  $("#reserveAlertMsg").show();
               }
               else{
                  
                  $("#reserveAlertMsg").hide();
               }
            });
      },1000);
      
   });

   ////gets the number of reserve book reserved oer student if the book has more than 3 will disable the  reserve button. 
   $(document).ready(function () {
      setInterval(function() {
         $.post("getNumBookReserve.php",{data:'get'},function (
            data) {
               console.log(data);
               if(data>=3){
                  $("#reserveBtn").attr("disabled", "disabled");
                  $("#reserveLimitReach").show();
               }
               else{
                  
                  $("#reserveLimitReach").hide();
               }
            });
      },1000);
      
   });


   
</script>
