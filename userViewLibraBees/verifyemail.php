<?php
require_once './config/dbconnect.php';

session_start();

if (!isset($_SESSION['user'])) {
   header('location:login.php');
}
 

date_default_timezone_set('Asia/Manila');
$currDate = new DateTime();

// change password code below
if (isset($_POST["verify_email"])) {
    $email = $_SESSION['user']['email'];
    $verification_code = $_POST["verification_code"];

    // connect with database
    

    // mark email as verified
    $sql = ("UPDATE users SET email_verified_at = NOW() WHERE stud_email = '$email' AND verification_code = '$verification_code'");
    $result = mysqli_query($conns, $sql);


    if ($result) {
      $rows_affected = mysqli_affected_rows($conns);
      if ($rows_affected > 0) {
         session_destroy();
         $error_message = "Verification Success! you may now Login!";
         $error_message_encoded = urlencode($error_message);
         header("Location: login.php?success=$error_message_encoded");
      } else {
         $error_message = "Verification code does not match!";
         $error_message_encoded = urlencode($error_message);
         header("Location: verifyemail.php?error=$error_message_encoded");
      }
  } else {
      
  }

   
   
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>book</title>

   <!-- swiper css link  -->
   <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body style="background-color: #FCD116;">
   
<!-- header section starts  -->
<center>
<section class="header">

<a href="login.php" class="logo">LibraBees.</a>

<nav class="navbar">
   
   
   <a href="logout.php">log out</a>
   
</nav>

<div id="menu-btn" class="fas fa-bars"></div>

</section>

<!-- header section ends -->

<div class="heading" style="background:url(images/header-bg-3.png) no-repeat">
   <h1>Login Now</h1>
</div>

<!-- booking section starts  -->

<section class="login">

   <h1 class="heading-title">Email Verification</h1>
   
   <form method="POST" class="book-form">
   
   <div class="flex">
    <input type="hidden" name="email" value="<?php echo $email ?>" required>
    <div class="inputBox">
    <input type="text" name="verification_code" placeholder="Enter verification code" required />
         </div>
         <?php
         if(isset($_GET['error'])){
            $error_message = $_GET['error'];
            echo "<div class='error-message' style='color: red;'>$error_message</div>";
        }
         ?>
         </div>
    <input type="submit" name="verify_email" value="Verify Email" class="btn">
</form>

</section>
</center>
<!-- booking section ends -->


<!-- swiper js link  -->
<script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
