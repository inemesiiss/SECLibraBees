<?php
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
include '../config/dbconnect.php';
/// action if the user tries cancel the barrow request in myBooks pages
if(isset($_POST['Cancel'])){
   $bookid = $_POST['myBookID'];


$delquery="DELETE FROM barrow_book WHERE book_id='$bookid' AND stud_number= '$student_Number' AND book_status =1";

$data=mysqli_query($conns,$delquery);
/// Update the book copies to +1 since the if the cook has been cancleed

$updatebook_copy = mysqli_query($conns,"UPDATE books SET book_copies=book_copies+1 where book_id='$bookid'");

if($data AND $updatebook_copy){
   header('location:mybook.php');
}
else{
   header('location:mybook.php');
    
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>SEC LibraBees</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <!-- swiper css link  -->
   <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="icon" type="image/x-icon" href="LB.ico">
   <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
</head>
<body style="background-color: #FCD116;">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

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










<div class="heading" style="background:url(images/header-bg-3.png) no-repeat">
   <h1></h1>
</div>

<!-- booking section starts  -->

<section class="mybook">

   <h1 class="heading-title">MY books</h1>

   <div class="box-container">
   <?php
   require './config/dbconnect.php';
   $std_barrower_num=$_SESSION['user']['std_id'];
   $sql = "SELECT * FROM barrow_book WHERE stud_number ='$std_barrower_num' AND book_status <=2";
      $result=$conns-> query($sql);

      if ($result-> num_rows > 0){
         while ($row=$result-> fetch_assoc()) {
            
     ?>
    <form method="POST" class="box" action="">
               <div class="image">
               <img src='../adminView<?=$row["book_image"]?>'>
               </div>
               <div class="content">
            <h3><?=$row["book_title"]?></h3>
            <p><?=$row["pickup_dt"]?></p>
            <input type="text" name = "myBookID" value="<?=$row['book_id']?>"hidden>
            <?php
            if($row["book_status"] == 1){
            echo"<p>FOR PICK-UP</p>";
            echo "<input type='submit' value='Cancel' class='btn' name='Cancel' >";
            }
            elseif($row["book_status"] == 2){
               echo"<p>ON-BORROW</p>" ;
            }
            ?>
            
            
            
             
            </div>
             
            </form>
         
     <?php
            
            
         }
      }else{
         echo "<div class='noBookMsg' style='display: flex;
         justify-content: center;
         align-items: center;
         font-size: 2rem; '>
         
            🐝📚🐝
         Currently no book!
            🐝📚🐝
         </div>";
   }


      ?>

   </div>



   <h1 class="heading-title">Reserve books</h1>

   <div class="box-container">
   <?php
   require './config/dbconnect.php';
   $std_barrower_num=$_SESSION['user']['std_id'];
   $sql = "SELECT *
   FROM reserve_book
   JOIN books ON reserve_book.book_id = books.book_id
   WHERE reserve_book.stud_number = '$std_barrower_num'";
      $result=$conns-> query($sql);

      if ($result-> num_rows > 0){
         while ($row=$result-> fetch_assoc()) {
            
     ?>
    <form method="POST" class="box" action="">
               <div class="image">
               <img src='../adminView<?=$row["book_image"]?>'>
               </div>
               <div class="content">
            <h3><?=$row["book_title"]?></h3>
            <p>On Reserve</p>
            <input type="text" name = "myBookID" value="<?=$row['reserve_id']?>"hidden>
            <input type='submit' value='Cancel' class='btn' name='Cancel' >
            </div>
             
            </form>
         
     <?php
            
            
         }
      }else{
         echo "<div class='noBookMsg' style='display: flex;
         justify-content: center;
         align-items: center;
         font-size: 2rem; '>
         
            🐝📚🐝
         Currently no reserve book!
            🐝📚🐝
         </div>";
   }


      ?>

   </div>



   

</section>

<!-- booking section ends -->
















<!-- swiper js link  -->
<script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js" ></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>