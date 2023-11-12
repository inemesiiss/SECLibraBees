<?php
require_once './config/dbconnect.php';

session_start();

if (!isset($_SESSION['user'])) {
   header('location:loginasadmin.php');
}


date_default_timezone_set('Asia/Manila');
$currDate = new DateTime();

// change password code below
if (isset($_POST["ad_password"]) && isset($_POST["ad_cpassword"])) {
    $email = $_SESSION['user']['ad_email'];
    $verification_code = $_POST["adcode"];
    $password = $_POST["ad_password"];
    $cpassword = $_POST["ad_cpassword"];
    $hashed_password = password_hash($cpassword, PASSWORD_DEFAULT);
    if(!password_verify($cpassword,$_SESSION['user']['ad_pass'])) {
       
    // check if password is at least 8 characters long and contains different combinations of characters
    if (preg_match('/^(?=.*\d)(?=.*[A-Za-z])(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/', $password)) {

        // check if passwords match
        if ($password === $cpassword) {
            // mark email as verified
            $sql = ("UPDATE admin_Lib SET admin_password = '$hashed_password', ademail_verified_at = NOW() WHERE admin_user = '$email' AND adverification_code = '$verification_code'");
            $result = mysqli_query($conns, $sql);

            if ($result) {
                $rows_affected = mysqli_affected_rows($conns);
                if ($rows_affected > 0) {
                    session_destroy();
                    $error_message = "Verification Success! you may now Login!";
                    $error_message_encoded = urlencode($error_message);
                    header("Location: loginasadmin.php?success=$error_message_encoded");
                } else {
                    $error_message = "Verification code does not match!";
                    $error_message_encoded = urlencode($error_message);
                    header("Location: adminVerification.php?error=$error_message_encoded");
                }
            } else {
                // handle database error
            }

        } else {
            $error_message = "Password does not match!";
            $error_message_encoded = urlencode($error_message);
            header("Location: adminVerification.php?error=$error_message_encoded");
        }

    } else {
        $error_message = "Should be at least 8 characters and contains [a-Z],[0-9] and one (!@#$%^&*)!";
        $error_message_encoded = urlencode($error_message);
        header("Location: adminVerification.php?error=$error_message_encoded");
    }
    
}else{
            $error_message = "Cannot use your temporary password!";
            $error_message_encoded = urlencode($error_message);
            header("Location: adminVerification.php?error=$error_message_encoded");
}
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>SEC LibraBees</title>
    <link rel="stylesheet" href="css/styleAdminLogin.css">
</head>
<body>
    <div class="main">
        <div class="navbar">
            <div class="icon">
                <h2 class="logo">LibraBees.</h2>
            </div>
            <div class="menu">
                <ul>
                </ul>
            </div>
        </div>
        <div class="content">
            <img src="images/seclogo.png" alt="">
            <h1>Southeastern College <br><span>Virtual</span> <br>Library Management</h1>
            <div class="form">
                <h2>Verify Account</h2>
                <a style ="text-decoration: none; color: white; font-size: 2rem;"href="https://localhost/thesis/adminView/logout.php">←</a> 
                <section class="login">
                    <form action="" method="POST">
                    <?php
                    // Check if an error message was passed in the URL
                    if(isset($_GET['error'])){
                        $error_message = $_GET['error'];
                        echo "<div class='error-message' style='color: red; text-align: center;'>$error_message</div>";
                        }
                    ?>
                        <input type="text" name="adcode" id="adcode" placeholder="Enter Code Here">
                        <input type="password" name="ad_password" id="ad_password" placeholder="Enter New Password Here">
                        <input type="password" name="ad_cpassword" id="ad_cpassword" placeholder="Confirm Password Here">
                        <i class="far fa-eye" id="togglePassword" style="margin-left: -30px; cursor: pointer;"></i>
                        <div class="field button">
                        <input type="submit" name="verify_email" value="Submit" class="btn">
                        </div>
                        <label style="display: flex; align-items: center;">
                            <input type="checkbox" onclick="seePasscode()" style="transform: scale(0.4); width: 40px; height: 40px; margin-top: 0px;"><span style="font-size: 1rem;">Show Password</span>
                            
                            
                        </label>

                    </form>
                </section>
                
                
 
                
                
            </div>
        </div>
    </div>
    <script src="js/loginAsAdmin.js"></script>
</body>
</html>
<script>
    function seePasscode() {
  var x = document.getElementById("ad_password");
  var y = document.getElementById("ad_cpassword");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
  if (y.type === "password") {
    y.type = "text";
  } else {
    y.type = "password";
  }
} 
</script>