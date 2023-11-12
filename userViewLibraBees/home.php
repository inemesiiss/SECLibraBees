<?php
require_once '../config/ddbconnect.php';
require_once '../config/dbconnect.php';
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
date_default_timezone_set('Asia/Manila');
    $currDate = new DateTime();
// change password code below
$yr_lvl=$_SESSION['user']['yr_lvl'];
$std_id=$_SESSION['user']['std_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>SECLibraBees</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <!-- swiper css link  -->
   <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="icon" type="image/x-icon" href="LB.ico">
</head>
<body style="background-color: #FCD116;" >
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<!-- header section starts  -->

<section class="header">
   

<a href="login.php" class="logo" style="text-decoration: none;"><img src="images/LB.png" alt="" style="  height: 3rem; margin-left: 1.5rem;"> LibraBees</a>
<div class="box">
   <?php
   $selAvatar ="SELECT stud_avatar FROM users where stud_number ='$std_id'";
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

<!-- home section starts  -->

<section class="home">

   <div class="swiper home-slider">

      <div class="swiper-wrapper">
         

         <div class="swiper-slide slide" style="background:url(images/home-slide-1.jpg) no-repeat">
            <div class="content">
            <img src="images/seclogo.png" width="210" height="200">
               <h3 style="color: #00BFFF;">Welcome to Southeastern College Virtual Library</h3>
               <a href="libraryMain.php" class="btn">Browse</a>
            </div>
         </div>

         <div class="swiper-slide slide" style="background:url(images/home-slide-2.jpg) no-repeat">
            <div class="content">
               <span></span>
               <h3 style="color: #00BFFF;">SERVICE EXCELLENCE CHARACTER</h3>
               <a href="libraryMain.php" class="btn">Browse</a>
            </div>
         </div>

         <div class="swiper-slide slide" style="background:url(images/home-slide-3.jpg) no-repeat">
            <div class="content">
               <span></span>
               <h3 style="color: #00BFFF;">STRONG in MIND, BODY and SPIRIT</h3>
               <a href="libraryMain.php" class="btn">Browse</a>
            </div>
         </div>
         
      </div>

      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>

   </div>

</section>

<!-- home section ends -->

<!-- services section starts  -->

<section class="services">

   <h1 class="heading-title">shortcuts </h1>

   <div class="box-container">

      <div class="box">
         <img id="Myimg" src="images/icon-1.png">
         <h3>my account</h3>
      </div>
      <div class="box">
         <img id="myChatBoxImg" src="images/icon-3.png" alt="">
         <span class="badge bg-danger rounded-pill float-end" id="chatNum">12</span>
         <h3>let's chat</h3>
      </div>

      <div class="box">
         <img id="myRRImg" src="images/icon-4.png" alt="">
         <span class="badge bg-danger rounded-pill float-end" id="revNum"></span>
         <h3>Rate Books</h3>
      </div>

     <!-- <div class="box">
         <img id="myNotifImg" src="images/icon-5.png" alt="">
         <span class="badge bg-danger rounded-pill float-end" id="notifNum">12</span>
         <h3>Notification</h3>
      </div>-->

     <!-- <div class="box">
         <img src="images/icon-6.png" alt="">
         <h3>Community</h3>
      </div>-->

      <div class="box">
         <img id="myReportBugImg"src="images/icon-2.png" alt="">
         <h3>report a Error</h3>
      </div>
   </div>

</section>

<!-- services section ends -->



<!-- .My Rate and Review Modal -->
<!-- My Rate and Review Modal -->
<div class="modal fade" id="myRRModalBox">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-warning text-black">
        <h2 class="modal-title">Rate and Reviews</h2>
        
        <button type="button" class="close" style="font-size: 3rem; background-color: transparent;"data-bs-dismiss="modal">&times;</button> 
      </div>
      <div class="modal-body" style="text-align: center; align-items: center;">
      <?php
         ///// getting the announcerment
               require './config/dbconnect.php';
               
               $sqlgetRate = "SELECT * FROM barrow_book WHERE barrow_id NOT IN (SELECT brrow_id FROM review WHERE brrow_id IS NOT NULL) AND book_status =3 AND stud_number='$std_id' ORDER BY barrow_id DESC";
                  $result=$conns-> query($sqlgetRate);

               if ((!empty($result) && $result->num_rows > 0)){
                  while ($row=$result-> fetch_assoc()) {
                     
            ?>
            
            <div class="book-container"style="">
            <div class="book-details" >
               <div class="book-text" style="width: 250px;">
                  <p style="font-size: 1.5rem;"><?=$row["book_title"]?></p>
                  <p>By <?=$row["book_author"]?></p>

            <section class="form rate">
            <form>
            <input type="button" class="myRateBtn bee-theme" value="Rate">
               <div class="rateContainer">
                  <div class="rate-ErrBtn"></div>
                  <div class="form-group">
                  <select style="color: #FCD116; font-size: 2.2rem; background-color: transparent;" value="1" class="form-control" name="ratingNumber_<?=$row["book_id"]?>">
                     <option style="color: #FCD116; font-size: 2.2rem; vertical-align: middle;" value="1">&#9733;</option>
                     <option style="color: #FCD116; font-size: 2.2rem; vertical-align: middle;" value="2">&#9733;&#9733;</option>
                     <option style="color: #FCD116; font-size: 2.2rem; vertical-align: middle;" value="3">&#9733;&#9733;&#9733;</option>
                     <option style="color: #FCD116; font-size: 2.2rem; vertical-align: middle;" value="4">&#9733;&#9733;&#9733;&#9733;</option>
                     <option style="color: #FCD116; font-size: 2.2rem; vertical-align: middle;" value="5">&#9733;&#9733;&#9733;&#9733;&#9733;</option>
                  </select>
                  </div>
                  <div class="form-group">
                     <label for="anonymous-checkbox"> anonymous:</label>
                     <input type="checkbox" id="anonymous-checkbox" name="anonymous_<?=$row["book_id"]?>" value="true">
                  </div>
                  <div class="form-group">
                     <input type="number" name="ratebook_id_<?=$row["book_id"]?>" value="<?=$row["book_id"]?>" hidden>
                     <input type="number" name="barrow_id_<?=$row["book_id"]?>" value="<?=$row["barrow_id"]?>" hidden>
                     <textarea class="form-control" name="comments_<?=$row["book_id"]?>" placeholder="Review comments" style="text-transform: none;" required autocapitalize="off"></textarea>

                  </div>
                  <br>
                  <div class="buttonRate">
                     <input type="submit" value="Submit" class="btnMyBook" style="font-size: 1rem;">
                  </div>
               </div>
            </form>
            
         </section>
               </div>
               <img src="../adminView/<?=$row["book_image"]?>" alt="Book Image" class="book-image">
            </div>
            </div>
            
               <?php
                     }
               }
               else{
                  echo"<div style='text-align: center;'>
                 No Book Returned Found! 
                  </div>";
               }

               ?>
      </div>
      
    </div>
  </div>
</div>

<!-- .My Report Bug Modal -->
<div class="modal fade" id="myReportBugModalBox">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
         <h2 class="modal-title">Report Error</h2>   
         <button type="button" class="close" style="font-size: 3rem; background-color: #FCD116;"data-bs-dismiss="modal">&times;</button>                                          
			</div> 
			<div class="modal-body" id="modal-body">
               <section class="form reportErr">
                  <form action="#" enctype='multipart/form-data'>
                  <div class="reportBug-Error" id="reportBug-Error"></div>
                        <div class="flex">
                           <div class="myInputBox">
                           <span>Title:</span>
                              <input type="text"  class="form-control" name="titleRB" id="titleRB"required></input>
                           </div>
                           <hr />
                           <div class="myInputBox">
                           <span> Description of Error:</span>
                              <textarea  name="descRB" id="descRB" class="form-control" required></textarea>
                           </div>
                           <hr />
                           <div class="myInputBox">
                           <label>Picture of the Error:</label>
                              <input type="file"  class="form-control" name="imgBug" id="imgBug" >
                           </div>
                        </div>
                         <br>
                        <div class = "field button" style="text-align:center;">
                        <input type="submit" value="Submit" class="btnMyBook"> 
                        </div>
                     </form>
                  </div>
               </section>
			</div>  
		</div>                                                                       
	</div>                                      
</div>
<!-- Modal -->
<div class="modal fade" id="myChatBoxModal" role="dialog">
<div class="modal-dialog">
      <!-- Modal ChatBox-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Librarian</h4>
          <button type="button" class="close" style="font-size: 3rem; background-color: #FCD116;"data-bs-dismiss="modal">&times;</button> 
         </div>
         <div class="chat-body" style="height:300px; overflow-y: scroll; overflow-x: hidden; background: white; display: flex; flex-direction: column-reverse;">
         </div>
         <div>
         <form action="#" class="typing-area" autocomplete="off">
         <input type="text" name="adminChat_id"  value="admin" hidden>
         <input type="text" name="studChat_id"  value="<?php echo $std_id;?>" hidden>
         <input type="text" name="message" class="input-field" placeholder="Type message here..." style="text-transform: none;">
          <button class="buttonMsgsend"><i style="font-size: 2.5rem; back-ground: transparent;" class="fab fa-telegram-plane"></i></button>
         </form>
         </div>
        </div>
        </div>
    </div>
  </div>
  </div>
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
<!-- .My Account Modal -->
<div class="modal fade" id="Mymodal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
         <h2 class="modal-title">
                	My Account
                </h2>   
				<button type="button" class="close" style="font-size: 3rem; background-color: #FCD116;"data-bs-dismiss="modal">&times;</button> 
				                                                          
			</div> 
         <div>
         
         </div>
			<div class="modal-body" id="modal-body">
         <?php
               $selAvatar ="SELECT * FROM users where stud_number ='$std_id'";
               $result = mysqli_query($conns, $selAvatar);

            if ($result) {
            $row = mysqli_fetch_assoc($result);
            $stud_avatar = $row['stud_avatar'];
            $yrlvl = $row['stud_yrlvl'];
            $course = $row['stud_course'];
            $grd_lvl = $row['stud_gradelvl'];
            $contact_num = $row['stud_contact_no'];
            }
            
               ?>
               <section class="form myAccount">
                  <form action="#" enctype='multipart/form-data'>
                  <div style="display: flex; padding: 40px;">
                     <div style="width: 50%;">
                        <h2><?php echo $_SESSION['user']['fullname']; ?></h2>
                        <p style="margin-bottom: 10px;">Student Number: <?php echo $_SESSION['user']['std_id']; ?></p>
                        <p style="margin-bottom: 10px;">Email: <?php echo $_SESSION['user']['email']; ?></p>
                        <div style="display: flex; margin-bottom: 10px;">
                           <span style="margin-right: 10px;">Phone Number:</span>
                           <input type="number" name="stud_cnum" id="stud_cnum" value="<?php echo $contact_num; ?>" style="width: 100px;">
                        </div>
                        <div style="display: flex; margin-bottom: 10px;">
                           <span style="margin-right: 10px;">Year Level:</span>
                           <select name="yr_lvl" id="yr_lvl" style="width: 120px;">
                           <option value="<?php echo $yrlvl; ?>"><?php echo $yrlvl; ?></option>
                           <option value="Elementary">Elementary</option>
                           <option value="High-School">High-School</option>
                           <option value="Senior High">Senior High</option>
                           <option value="College">College</option>
                           </select>
                        </div>
                        <div style="display: flex; margin-bottom: 10px;">
                           <span style="margin-right: 10px;"> Grade Level:</span>
                           <select name="grdlvl" id="grdlvl" style="width: 120px;">
                           <option value="<?php echo $grd_lvl; ?>"><?php echo $grd_lvl; ?></option>
                           </select>
                        </div>
                        <div style="display: flex;">
                           <span style="margin-right: 10px;" id="cs">Course:</span>
                           <select name="course" id="course" style="width: 120px;">
                           <option value="<?php echo $course; ?>"><?php echo $course; ?></option>
                           </select>
                        </div>
                     </div>
                     <div style="position: relative;">
                        <div style="border: 5px solid #FDD835; border-radius: 50%; width: 150px; height: 150px; display: flex; align-items: center; justify-content: center;">
                           <img src="userpic/<?php echo ($stud_avatar != null) ? $stud_avatar : 'images/student1.png'; ?>" alt="Profile Picture" style="border-radius: 50%; width: 140px; height: 140px;">
                        </div>
                        <input type="file" class="form-control" name="stud_avatar" id="stud_avatar" style="width: 150px;">
                        <div class="form myAccountBtn" style="text-align: center; font-size: 1rem;">
                           <br>
                           <input type="submit" value="Submit" class="btnMyBook">
                        </div>
                     </div>
                  </div>
               </form>
               </section>
               
               <input class="myButton bee-theme" type="button" value="Change Email Address"></input>
               <div class="container">
               <form action="#" class="formUpdtEmail">
               <div class="Uptemail-Error" id="updtEmailErrTxt"></div>
               <div class="Uptemail-Msg"></div>
                        <div class="flex">
                        <br>
                           <div class="myInputBox">
                           <span>Enter New Email:</span>
                              <input type="text"  name="newEmail" id="newEmail">
                           </div>
                           <div class="form updatevcode">
                           <br>
                           <input type="submit" value="Send Code" class="btnMyBook">
                           </div>
                           <br>
                           <div class="myInputBox">
                           <span>Verfication Code:</span>
                              <input type="text"  name="vcode">
                           </div>
                           <br>
                        </div>
                        <div class="form updatemail">
                           <input type="submit" value="Update" class="btnMyBook">
                           </div>
                           <br>
                     </form>
               </div>
               <!-- .change password -->
               <input class="myButton1 bee-theme" type="button" value="Change Password"></input>
               <div class="container">
               <section class="form changepass">
                  <form action="#">
                   <div class="changePass-Error"></div>
                        <div class="flex">
                           <div class="myInputBox">
                           <span>Old Password:</span>
                              <input type="password"  name="oldpassword"  id="oldpassword"required>
                           </div>
                           <hr />
                           <div class="myInputBox">
                           <span>New Password:</span>
                              <input type="password"  name="npassword" id="npassword" required>
                           </div>
                           <hr />
                           <div class="myInputBox">
                           <label>Confirm Password:</label>
                              <input type="password"  name="cpassword"  id="cpassword" required>
                           </div>
                           </div>
                           <div id="message">
                           <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                           <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                           <p id="number" class="invalid">A <b>number</b></p>
                           <p id="match" class="invalid">Des not match <b></b></p>
                           <p id="length" class="invalid">Minimum <b>8 characters</b></p>
                           </div>
                           <br>
                        <div class = "field button">
                        <input type="submit" value="Confirm" class="btnMyBook"> 
                        </div>
                     </form>
                  </div>
               </section>
			   </div>  
		</div>                                                                       
	</div>                                      
</div>
<script>
   ///script function for change password and update email
var myInput = document.getElementById("npassword");
var myInput2 = document.getElementById("adcpass");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");


// When the user clicks on the password field, show the message box

myInput.onfocus = function() {
  document.getElementById("message").style.display = "block";
}

// When the user clicks outside of the password field, hide the message box
myInput.onblur = function() {
  document.getElementById("message").style.display = "none";
}

// When the user starts to type something inside the password field
myInput.onkeyup = function() {
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
}

  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }

  // Validate length
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}
</script>





<!--personalize style for specfic buttons-->
<style>
   .book-container {
  display: flex;
  align-items: center;
  width: 100%;
}

.book-details {
  display: flex;
  align-items: center;
}

.book-text {
  margin-right: 20px;
}

.book-image {
  width: 40%;
  height: 200px;
  align-items: center;
  text-align: center;
}


.badge.bg-danger {
  font-size: 1.5em;
  display: none;
} 
/* Review Modal Styles */
.modal-header {
  background-color: #FCD116;
  color: #000000;
}

.modal-body {
  background-color: #F5DEB3;
  color: #000000;
}

.modal-footer {
  background-color: #000000;
}

.modal-footer button {
  background-color: #FCD116;
  color: #000000;
  border: none;
}

.modal-title {
  color: #000000;
}

.form-group label {
  color: #000000;
}

.form-control {
  background-color: #ffffff;
  border-color: #000000;
  color: #000000;
}

.btnMyBook {
  background-color: #FCD116;
  color: #000000;
  border: none;
  padding: 10px 20px;
  font-size: 15px;
  font-weight: bold;
}

.btnMyBook:hover {
  background-color: #000000;
  color: #FCD116;
}
.modal-content {
  background-color: #F5DEB3; /* light brown color */
}

.container {
    display:none;
    
    text-align: center;
    border:var(--border);
}
.notifcontainer {
    display:none;
    
    text-align: left;
    
    
}
.rateContainer {
    display:none;
    
    text-align: center;
    
    
}

.container::before {
    content:''

}
.chat-body .typing-area{
   padding: 18px 30px;
   display: flex;
}
.typing-area input{
   height: 45px;
   width: calc(100% - 58px);
   font-size:17px;
   border: 1px solid #ccc;
   padding: 0 13px;
   border-radius:5px 0 0 5px;
   outline: none;

}
.typing-area button{
   width: 50px;
   border: none;
   outline: none;
   border-radius:5px 0 0 5px;
   cursor: pointer;
   background: #ffc105;

}
#message {
  display:none;
  background: #ffc105;
  color: #000;
  position: relative;
  padding: 2px;
  margin-top: 10px;
}

#message p {
  padding: 10px 20px;
  font-size: 10px;
}

/* Add a green text color and a checkmark when the requirements are right */
.valid {
  color: green;
}

.valid:before {
  position: relative;
  left: -35px;
  content: "\2713";
}

/* Add a red text color and an "x" icon when the requirements are wrong */
.invalid {
  color: red;
}

.invalid:before {
  position: relative;
  left: -35px;
  content: "❌"
}

.reportBug-Error {
  padding: 20px;
  background-color: #f44336; /* Red */
  color: white;
  margin-bottom: 15px;
  display: none;
}

.changePass-Error {
  padding: 20px;
  background-color: #f44336; /* Red */
  color: white;
  margin-bottom: 15px;
  display: none;
}
.Uptemail-Msg{
   font-size:17px;
  padding: 10px;
  background-color: green; /* green */
  color: white;
  margin-bottom: 15px;
  display: none;
}
.Uptemail-Error{
   font-size:17px;
  padding: 10px;
  background-color: #f44336; /* green */
  
  color: white;
  margin-bottom: 15px;
  display: none;

}
  @media (max-width: 768px) {
  .modal-body {
    display: flex;
   
  }
  .form-group {
    margin-bottom: 15px;
  }
  .form-group:last-child {
    margin-bottom: 0;
  }
  .field.button {
    display: flex;
    justify-content: center;
  }
  .btnMyBook {
    width: 100%;
  }

}



</style>
<!-- swiper js link  -->
<script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js" ></script>
<!-- custom js file link  -->
<script src="js/script.js"></script>
<script src="js/insertMsg.js"></script>
<script src="js/changepassword.js"></script>
<script src="js/updateEmail.js"></script>
<script src="js/reportError.js"></script>
<script src="js/rateReview.js"></script>
<script src="js/updateMyAccount.js"></script>
</body>

<script>
   ///images if click modal will show up
   $(document).ready(function(){
	$('#myReportBugImg').click(function(){
  		$('#myReportBugModalBox').modal('show')
	});
});


   $(document).ready(function(){
	$('#myRRImg').click(function(){
  		$('#myRRModalBox').modal('show')
	});
});


   $(document).ready(function(){
	$('#myChatBoxImg').click(function(){
  		$('#myChatBoxModal').modal('show')
	});
});

$(document).ready(function(){
	$('#Myimg').click(function(){
  		$('#Mymodal').modal('show')
	});
});

// expand collapse my account button
$('.myButton').click(function(){
    if ( this.value === 'Change Email Address ' ) {
        // if it's open close it
        open = false;
        this.value = 'Change Email Address';
        $(this).next("div.container").hide("slow");
    }
    else {
        // if it's close open it
        open = true;
        this.value = 'Change Email Address ';
        $(this).siblings("[value='Change Email Address ']").click();
        $(this).next("div.container").show("slow");
    }
});


$('.myButton1').click(function(){
    if ( this.value === 'Change Password ' ) {
        // if it's open close it
        open = false;
        this.value = 'Change Password';
        $(this).next("div.container").hide("slow");
    }
    else {
        // if it's close open it
        open = true;
        this.value = 'Change Password ';
        $(this).siblings("[value='Change Password ']").click();
        $(this).next("div.container").show("slow");
    }
});




// expand collapse my rate button
$('.myRateBtn').click(function(){
    if ( this.value === 'close' ) {
        // if it's open close it
        open = false;
        this.value = 'rate';
        $(this).next("div.rateContainer").hide("slow");
    }
    else {
        // if it's close open it
        open = true;
        this.value = 'close';
        $(this).siblings("[value='close']").click();
        $(this).next("div.rateContainer").show("slow");
    }
});



var yrlvlSel = document.getElementById("yr_lvl");
var courseSel = document.getElementById("course");
var courseSpan = document.getElementById("cs");
var gradlvl = document.getElementById("grdlvl");


yrlvlSel.addEventListener("change", function() {
   if (yrlvlSel.value === "College") {
      courseSel.innerHTML = '<option value="">Select Option</option><option value="BEED">BEED</option><option value="BSED">BSED</option><option value="BSBA-OA">BSBA-OA</option><option value="BSBA-OM">BSBA-OM</option><option value="BSCS">BSCS</option>';
      gradlvl.innerHTML = '<option value="">Select Option</option><option value="1st year">1st year</option><option value="2nd year">2nd year</option><option value="3rd year">3rd year</option><option value="4th year">4th year</option>';
      courseSel.disabled = false;
      $('#cs').text("College :");
      courseSel.required = true;
      gradlvl.selectedIndex = 0;
      courseSel.selectedIndex = 0;
   } else if (yrlvlSel.value === "Senior High") {
      courseSel.innerHTML = '<option value="">Select Option</option><option value="ABM">ABM</option><option value="HUMSS">HUMSS</option><option value="STEM">STEM</option>';
      $('#cs').text("STRAND :");
      courseSel.required = true;
      gradlvl.selectedIndex = 0;
      courseSel.selectedIndex = 0;
      gradlvl.innerHTML = '<option value="">Select Option</option><option value="Grade 11">Grade 11</option><option value="Grade 12">Grade 12</option>';
      courseSel.disabled = false;
   } else if (yrlvlSel.value === "High-School") {
      gradlvl.innerHTML = '<option value="">Select Option</option><option value="Grade 7">Grade 7</option><option value="Grade 8">Grade 8</option><option value="Grade 9">Grade 9</option><option value="Grade 10">Grade 10</option>';
      gradlvl.selectedIndex = 0;
      courseSel.selectedIndex = 0;
      courseSel.disabled = true;
   } else if (yrlvlSel.value === "Elementary") {
      gradlvl.innerHTML = '<option value="">Select Option</option><option value="Grade 1">Grade 1</option><option value="Grade 2">Grade 2</option><option value="Grade 3">Grade 3</option><option value="Grade 4">Grade 4</option><option value="Grade 5">Grade 5</option><option value="Grade 6">Grade 6</option>';
      gradlvl.selectedIndex = 0;
      courseSel.selectedIndex = 0;
      courseSel.disabled = true;
   } else {
      $('#cs').text("College :");
      courseSel.required = false;
      courseSel.disabled = true;
   }
});
</script>
</html>