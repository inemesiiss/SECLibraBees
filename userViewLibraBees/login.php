<?php
require_once './config/ddbconnect.php';
session_start();
if (isset($_SESSION['user'])) {
   header('location: home.php');
   
}



date_default_timezone_set('Asia/Manila');



if (isset($_REQUEST['login_btn'])) {
    $std_usr_id= filter_var($_REQUEST['user_id'],FILTER_SANITIZE_STRING);
    $passw = strip_tags($_REQUEST['password']);

    
   
      try {
         $select_stmt = $conn->prepare("SELECT * FROM users WHERE stud_number = :stud_number LIMIT 1");
         $select_stmt->execute([':stud_number' => $std_usr_id]);
         $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
         if ($select_stmt->rowCount() > 0) {
            if (password_verify($passw, $row["stud_password"])) {
               $_SESSION['user']['std_id'] = $row["stud_number"];
               $_SESSION['user']['std_pass'] = $row["stud_password"];
               $_SESSION['user']['fullname'] = $row["stud_first_name"]." ".$row["stud_last_name"];
               $_SESSION['user']['email'] = $row["stud_email"];
               $_SESSION['user']['yr_lvl'] = $row["stud_yrlvl"];
               $_SESSION['user']['c_num'] = $row["stud_contact_no"];
               $_SESSION['user']['add'] = $row["stud_address"];
               $_SESSION['user']['verify_status'] = $row["email_verified_at"];
              
               header("location:home.php");
               
            } else {
               
               $error_message = "Invalid student number or password!";
               $error_message_encoded = urlencode($error_message);
               header("Location: login.php?error=$error_message_encoded");
               
            }
         } 
         else {
            $error_message = "Invalid student number or password!";
            $error_message_encoded = urlencode($error_message);
            header("Location: login.php?error=$error_message_encoded");
            
         }
         
         
      } catch (PDOException $e) {
         echo $e->getMessage();
      }
       
   }







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
   <link rel="icon" type="image/x-icon" href="LB.ico">
   <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
   
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
</script>
</head>
<body   style="background-color: #FCD116; height: 100%; overflow-y: hidden;">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>



   
<!-- header section starts  -->

<section class="header">
   <a href="login.php" class="logo" style="text-decoration: none;"><img src="images/LB.png" alt="" style="  height: 3rem; margin-left: 1.5rem;"> LibraBees</a>
   <nav class="navbar">
      <a href="login.php">log in</a>
      <a href="register.php">sign up</a>
      <a href="about.php">about us</a>
   </nav>
   <div id="menu-btn" class="fas fa-bars"></div>
</section>

<!-- header section ends -->



<!-- booking section starts  -->

<section class="login">
   <h1 class="heading-title">bee one of us!</h1>
   <center>
   <form action="" method="post" class="book-form">

      <div class="flex">
      <h2 >login</h2>
         <div class="inputBox">
         <?php
  // Check if an error message was passed in the URL
  if(isset($_GET['error'])){
      $error_message = $_GET['error'];
      echo "<div class='error-message' style='color: red;'>$error_message</div>";
  }
  if(isset($_GET['success'])){
   $error_message = $_GET['success'];
   echo "<div class='error-message' style='color: green;'>$error_message</div>";
}
  ?>
            <span>Student Number :</span>
            <input type="text" placeholder="Enter Student Number" name="user_id" required>
         </div>
         <div class="inputBox" style="align-text: left;">
         
         <span >Password :</span>
            <div style="position:relative;">
                <input type="password" placeholder="Enter Your Password" name="password" id="password" required>
                <a href="#" style="position:absolute; right:30px; top:10px; font-size: 1.5rem;" onclick="togglePassword()"><i class="fa-solid fa-eye-slash"></i></a>
            </div>
         </div>
         <p class="link"><br>
         <a href="#" id="forgot-password-link">Forgot your password?</a> Click here.
         </p>
      </div>
      <input type="submit" value="ENTER" class="btn" name="login_btn" >
   </form>
</center>
</section>
<!-- booking section ends -->

<div class="modal fade" id="resetPassModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
         <h2 class="modal-title">Reset Password Request</h2>   
         <button type="button" class="close" style="font-size: 3rem; background-color: #FCD116;"data-bs-dismiss="modal">&times;</button>                                          
			</div> 
			<div class="modal-body" id="modal-body">
               <section class="form reportErr">
                  <form action="#" enctype='multipart/form-data'>
                  <div class="reportBug-Error" id="reportBug-Error"></div>
                        <div class="flex">
                           <input type="text"  class="form-control" name="titleRB" id="titleRB"  value="Change Password" hidden></input>
                           <div class="myInputBox">
                           <span> Account Email:</span>
                              <input  name="user_email" id="user_email" class="form-control" required></input>
                           </div>
                           <div class="myInputBox">
                           <span> Student ID Number :</span>
                              <input  name="studnum" id="studnum" class="form-control" required></input>
                           </div>
                           <hr />
                           <div class="myInputBox">
                           <label>School ID Picture:</label>
                              <input type="file"  class="form-control" name="id_pic" id="id_pic" >
                           </div>
                        </div>
                         <br>
                        <div class = "field button" style="text-align:center;">
                        <input type="submit" value="Submit" class="btnMyBook"> 
                        </div>
                     </form>
                  
               </section>
               </div>
			</div>  
		</div>                                                                       
	</div> 
<!-- footer section starts  -->
<footer>
<section class="footer">

   <div class="box-container">
      <div class="box">
         <h3>quick links</h3>
         <a href="http://www.southeastern.com.ph/"> <i class="fas fa-angle-right"></i> School's Official Website</a>
         <a href="https://www.facebook.com/SoutheasternCollegeOfficial"> <i class="fab fa-facebook-f"></i> facebook </a>
         <a href="https://www.youtube.com/channel/UCl_P7QwAFWhmoL10fPjVFyA"> <i class="fab fa-youtube"></i> youtube </a>
         <a href="loginasadmin.php"> <i class="fa-solid fa-user"></i> SECLibraBees Admin </a>
      </div>

      <div class="box">
         <h3>contact info</h3>
         <a href="#" class="disabled"> <i class="fas fa-phone"></i> +8831-8484 </a>
         <a href="#" class="disabled"> <i class="fas fa-phone"></i> +8899-3877 </a>
         <a href="mailto:seclibrabees@gmail.com?subject=My%20subject&body=My%20message"> <i class="fas fa-envelope"></i> seclibrabees@gmail.com</a> 
      </div>
   </div>
</section>
</footer>
<script src="js/resetPassNotif.js"></script>
</body>
<style>
   a.disabled {
  pointer-events: none;
  cursor: default;
}
body, html {
}
.reportBug-Error {
  padding: 20px;
  background-color: #f44336; /* Red */
  color: white;
  margin-bottom: 15px;
  display: none;
}
</style>
<!-- swiper js link  -->
<script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js" ></script>
<!-- custom js file link  -->
<script src="https://kit.fontawesome.com/0bd5d623c3.js" crossorigin="anonymous"></script>
<script src="js/script.js"></script>
<script>
function togglePassword() {
    var password = document.getElementById("password");
    if (password.type === "password") {
        password.type = "text";
    } else {
        password.type = "password";
    }
}


$(document).ready(function() {
  // Get the forgot password link
  var forgotPasswordLink = $('#forgot-password-link');

  // When the link is clicked, show the modal
  forgotPasswordLink.click(function() {
      $('#resetPassModal').modal('show')
  });

  // When the user clicks anywhere outside of the modal, hide it
 
});
</script>

</html>