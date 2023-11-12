<?php
require_once '../config/ddbconnect.php';
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/vendor/autoload.php';

if (isset($_SESSION['user'])) {
   header("location: home.php");
}

if (isset($_REQUEST['regis_btn'])) {

   


   $std_number = filter_var($_REQUEST['stud_number'],FILTER_SANITIZE_STRING);
   $password = strip_tags($_REQUEST['password']);
   $std_password = strip_tags($_REQUEST['c_password']);
   $fname = filter_var($_REQUEST['f_name'],FILTER_SANITIZE_STRING);
   $surname = filter_var($_REQUEST['sur_name'],FILTER_SANITIZE_STRING);
   $add = filter_var($_REQUEST['address'],FILTER_SANITIZE_STRING);
   $e_add = filter_var($_REQUEST['e_address'],FILTER_SANITIZE_EMAIL);
   $yrlvl = filter_var($_REQUEST['yr_lvl'],FILTER_SANITIZE_STRING);
   $grlvl = filter_var($_REQUEST['grdlvl'],FILTER_SANITIZE_STRING);
   $c_num =filter_var($_REQUEST['cont_num'],FILTER_SANITIZE_NUMBER_INT);
   $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);


   
   
   if (strlen($std_password)< 8) {
      $errMsg[1][] = 'Must be at least 8 characters';
   }
   if ($std_password !== $password) {
      $errMsg[8][]  = 'Password does not match!';
   }
   if (empty($fname)) {
      $errMsg[2][] = 'Firstname is Required';
   }
   if (empty($surname)) {
      $errMsg[3][] = 'Surname is Required';
   }
   if (empty($add)) {
      $errMsg[4][] = 'Address is Required';
   }
   if (!filter_var($e_add, FILTER_VALIDATE_EMAIL)) {
      $errMsg[5][] = 'Email address is not valid!';
   } else if (strtolower(substr($e_add, -4)) !== '.com') {
      $errMsg[5][] = 'Email address is not valid!';
   }
   if (empty($yrlvl)) {
      $errMsg[6][] = 'Year Level is Required';
   }
   if (strlen($c_num) != 11) {
      $errMsg[7][] = 'Contact Number is not Valid!';
   }
      try {
         $select_stmt = $conn->prepare("SELECT * FROM users WHERE stud_number = :stud_number OR pre_reg_number =:stud_number");
         $select_stmt->execute([':stud_number' => $std_number]);
         $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

         if (isset($row['stud_number']) == $std_number ) {
            $errMsg[0][] = 'Student number is already exist, please choose another or login instead';
         } 
         elseif(isset($row['pre_reg_number']) != $std_number ){
            $errMsg[0][] = 'Student Number is not registered in library system!';
         }
         else{  
         }
        
         if (empty($errMsg)) {
         
            $hashed_password = password_hash($std_password, PASSWORD_DEFAULT);
            $updateQry = "UPDATE users SET stud_number=:stud_number,stud_first_name=:stud_first_name, stud_last_name=:stud_last_name, stud_email=:stud_email,stud_yrlvl=:stud_yrlvl,stud_gradelvl=:stud_gradelvl,stud_password=:stud_password, stud_contact_no=:stud_contact_no, stud_address=:stud_address,verification_code=:verification_code WHERE pre_reg_number = :stud_number";
            $insert_stmt = $conn->prepare($updateQry);
            $pdoExe= $insert_stmt->execute(array(':stud_number' => $std_number,
            ':stud_first_name' => $fname,
            ':stud_last_name' => $surname,
            ':stud_email' => $e_add,
            ':stud_yrlvl' => $yrlvl,
            ':stud_gradelvl' => $grlvl,
            ':stud_password' => $hashed_password,
            ':stud_contact_no' => $c_num,
            ':stud_address' => $add,
            ':verification_code' => $verification_code));
            if($pdoExe){

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
             $mail->addAddress($e_add, $fname." ".$surname);
 
             //Set email format to HTML
             $mail->isHTML(true);
 
            
 
             $mail->Subject = 'Account Verification';
             $mail->Body    = '
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
            <p>Dear Mr/Ms. <b>' . $fname." ".$surname. '</b>,</p>
            <p>Your verification code for your account registration is: <b style="font-size: 30px; background-color: #F5A623; padding: 5px 10px; border-radius: 5px;">' . $verification_code . '</b></p>
            <p>Please enter this code in the verification page after logging in, If you have concerns kindly reach us.</p>
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

             $error_message = "Email Verification Code has been sent!";
             $error_message_encoded = urlencode($error_message);
             header("Location: login.php?success=$error_message_encoded");

               
            }
            else{
            }
         }
      } 
   
      catch (PDOException $e) {
         $pdoError = $e->getMessage();
      }
   

   
   
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Sign Up</title>

   <!-- swiper css link  -->
   <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
   <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body style="background-color: #FCD116;">
   
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

<div class="heading" style="background:url(images/header-bg-2.jpg) no-repeat">
   <h1></h1>
</div>

<center>
<section class="login">

   <h1 class="heading-title">Bee one of us! </h1>
   <a href="#" class="trigger" style="font-size: 2rem;"><i class="fa-solid fa-circle-exclamation" >NOTICE BEFORE SIGN UP</i></a>
   
   <div class="message-box">
  <span class="message" style="text-transform: none;">"Before signing up, we kindly request that all students to pre-register their student numbers at the library. Please note that only students affiliated with our school will be able to register for the virtual library."</span>
</div>


   <form action="" method="post" class="book-form">

      <div class="flex">
      
         <div class="inputBox">
            <?php
            if (isset($errMsg[0])) {
               foreach ($errMsg[0] as $studnumbErrors) {
                  echo "<p class='small text-danger'>" . $studnumbErrors . "</p>";
               }
            }
            ?>
            <span>Student Number :</span>
            <input type="text" placeholder="Enter Student Number" name="stud_number" value="<?php echo isset($_POST['stud_number']) ? $_POST['stud_number'] : ''; ?>"required>
         </div>
        <div class="inputBox">

        <?php
            if (isset($errMsg[8])) {
               foreach ($errMsg[8] as $pass2Errors) {
                  echo "<p class='small text-danger'>" . $pass2Errors . "</p>";
               }
            }
            
            
            ?>
            <span>Password :</span>
            <input type="password" placeholder="Enter Your Password" name="password"  value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>" required>
         </div>
         <div class="inputBox">
         <?php
            if (isset($errMsg[1])) {
               foreach ($errMsg[1] as $passErrors) {
                  echo "<p class='small text-danger'>" . $passErrors . "</p>";
               }
            }
            
            
            ?>
            <span>Confirm Password :</span>
            <input type="password" placeholder="Enter Your Password" name="c_password" value="<?php echo isset($_POST['c_password']) ? $_POST['c_password'] : ''; ?>" required>
         </div>
         <div class="inputBox">
         <?php
            if (isset($errMsg[2])) {
               foreach ($errMsg[2] as $firtName) {
                  echo "<p class='small text-danger'>" . $firtName . "</p>";
               }
            }
            
            
            ?>
            <span>First Name :</span>
            <input type="text" placeholder="Enter First Name" name="f_name" value="<?php echo isset($_POST['f_name']) ? $_POST['f_name'] : ''; ?>" required>
         </div>
         <div class="inputBox">
         <?php
            if (isset($errMsg[3])) {
               foreach ($errMsg[3] as $SurName) {
                  echo "<p class='small text-danger'>" . $SurName . "</p>";
               }
            }
            
            
            ?>
            <span>Surname :</span>
            <input type="text" placeholder="Enter Surname" name="sur_name" value="<?php echo isset($_POST['sur_name']) ? $_POST['sur_name'] : ''; ?>" required>
         </div>
         <div class="inputBox">
         <?php
            if (isset($errMsg[5])) {
               foreach ($errMsg[5] as $eaddress) {
                  echo "<p class='small text-danger'>" . $eaddress . "</p>";
               }
            }
            
            
            ?>
            <span>Email Address :</span>
            <input type="text" placeholder="Enter Email Address" name="e_address" value="<?php echo isset($_POST['e_address']) ? $_POST['e_address'] : ''; ?>" required>
         </div>
         <div class="inputBox">
         <?php
            if (isset($errMsg[4])) {
               foreach ($errMsg[4] as $address) {
                  echo "<p class='small text-danger'>" . $address . "</p>";
               }
            }
            ?>
            <span>Address :</span>
            <input type="text" placeholder="Enter Address" name="address" value="<?php echo isset($_POST['address']) ? $_POST['address'] : ''; ?>" required>
         </div>
         <div class="inputBox">
         <?php
            if (isset($errMsg[7])) {
               foreach ($errMsg[7] as $numErr) {
                  echo "<p class='small text-danger'>" .$numErr . "</p>";
               }
            }
            ?>
            <span>Contact Number :</span>
            <input type="number" placeholder="Enter Contact Number +63" name="cont_num" value="<?php echo isset($_POST['cont_num']) ? $_POST['cont_num'] : ''; ?>" required>
         </div>
        
              <div class="inputBox">
              <?php
            if (isset($errMsg[6])) {
               foreach ($errMsg[6] as $yearlvl) {
                  echo "<p class='small text-danger'>" . $yearlvl . "</p>";
               }
            }
            ?>
            
            <span>Year Level :</span>
            <select name="yr_lvl" id="yr_lvl" value="<?php echo isset($_POST['yr_lvl']) ? $_POST['yr_lvl'] : ''; ?>" required>
               <option value="">Select Option</option>
               <option value="Elementary">Elementary</option>
               <option value="High-School">High-School</option>
               <option value="Senior High">Senior High</option>
               <option value="College">College</option>
            </select>
            </div>

            <div class="inputBox">
            <span id="Grade Level">Grade Level :</span>
            <select  name="grdlvl" id="grdlvl" required>
               <option value=""> Select Option</option>
               
            </select>
         </div>

            <div class="inputBox" id="courseBox">
            <span id="cs">Course :</span>
            <select  name="course" id="course" disabled>
               <option value="">Select Option</option>
               
            </select>
         </div>
<script>
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
            
        
      </div>

      <input type="submit" value="Register" class="btn" name="regis_btn">

   </form>

</section>
</center>



<!-- footer section starts  -->

<section class="footer">

   <div class="box-container">

      <div class="box">
         <h3>quick links</h3>
         
         <a href="http://www.southeastern.com.ph/"> <i class="fas fa-angle-right"></i> School's Official Website</a>
         <a href="https://www.facebook.com/SoutheasternCollegeOfficial"> <i class="fab fa-facebook-f"></i> facebook </a>
         <a href="https://www.youtube.com/channel/UCl_P7QwAFWhmoL10fPjVFyA"> <i class="fab fa-youtube"></i> youtube </a>
         
      </div>


      <div class="box">
         <h3>contact info</h3>
         <a href="#"> <i class="fas fa-phone"></i> +8831-8484 </a>
         <a href="#"> <i class="fas fa-phone"></i> +8899-3877 </a>
         <a href="mailto:seclibrabees@gmail.com?subject=My%20subject&body=My%20message"> <i class="fas fa-envelope"></i> seclibrabees@gmail.com</a>
         <a href="#"> <i class="fas fa-map"></i> College Road, Taft Avenue, Pasay City</a>
      </div>


   </div>



</section>





  




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<!-- swiper js link  -->
<script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
<style>
 .info-hover {
  display: none; /* Hide the hover content by default */
  position: absolute;
  top: 100%;
  left: 0;
  z-index: 1;
  background-color: #fff;
  box-shadow: 0px 2px 4px rgba(0,0,0,0.2);
  padding: 10px;
}


p:hover + .info-hover {
  display: block; /* Show the hover content when the paragraph is hovered over */
}
span{
   text-align: left;
}

</style>
<script>
   var messageBox = document.querySelector('.message-box');

// Show the message box
function showMessage() {
  messageBox.style.display = 'block';
}

// Hide the message box
function hideMessage() {
  messageBox.style.display = 'none';
}

// Attach event listener to trigger show/hide
var trigger = document.querySelector('.trigger');
trigger.addEventListener('mouseenter', showMessage);
trigger.addEventListener('mouseleave', hideMessage);
</script>
</html>

