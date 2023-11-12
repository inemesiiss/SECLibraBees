<?php
require_once './config/ddbconnect.php';
session_start();
if (isset($_SESSION['user'])) {
    header('Location: https://localhost/thesis/adminView/index.php');
} else{
    
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>SEC LibraBees</title>
    <link rel="stylesheet" href="css/styleAdminLogin.css">
    <link rel="icon" type="image/x-icon" href="LB.ico">
</head>
<body>
    <div class="main">
        <div class="navbar">
            <div class="icon">
                <h2 class="logo">SECLibraBees.</h2>
            </div>
            <div class="menu">
                <ul>
                    
                    
                </ul>
            </div>
        </div>
        <div class="content">
            <img src="images/seclogo.png" width="180" height="180" alt="">
            <h1>Southeastern College <br><span>Virtual</span> <br>Library Management</h1>
            <button class="cn"><a href="about.php">ABOUT US</a></button>
            <div class="form">
                <h2>Login as Admin</h2>
                <section class="login">
                    <form action="loginDataAdmin.php">
                    <?php
                    // Check if an error message was passed in the URL
                    if(isset($_GET['error'])){
                        $error_message = $_GET['error'];
                        echo "<div class='error-message' style='color: red; text-align: center;'>$error_message</div>";
                        }elseif(isset($_GET['success'])){
                            $error_message = $_GET['success'];
                            echo "<div class='error-message' style='color: green; text-align: center;'>$error_message</div>";
                        }
                    ?>
                        <input type="text" name="ad_email" id="ad_email" placeholder="Enter Email Here">
                        <input type="password" name="ad_password" id="ad_password" placeholder="Enter Password Here">
                        <i class="far fa-eye" id="togglePassword" style="margin-left: -30px; cursor: pointer;"></i>
                        <div class="field button">
                            <input type="submit" value="LOGIN" name="login_btn" id="login_btn">
                        </div>
                    </form>
                </section>
                <p class="link">Don't have an account<br>
                <a href="login.php">Sign Up as Student</a> here</p>
            </div>
        </div>
    </div>
    <script src="js/loginAsAdmin.js"></script>
</body>
</html>