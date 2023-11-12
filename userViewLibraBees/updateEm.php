

<?php
require_once '../config/ddbconnect.php';
require 'phpmailer/vendor/autoload.php';
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
$std_oldEmail=$_SESSION['user']['std_id'];
$std_id=$_SESSION['user']['std_id'];
$std_id=$_SESSION['user']['std_id'];
$newEmail=  filter_var($_POST['newEmail'], FILTER_SANITIZE_EMAIL);
$_SESSION['user']['newmail'] =$newEmail;
$newVerification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
// Validate e-mail
try {
if (filter_var($newEmail, FILTER_VALIDATE_EMAIL) AND $newEmail != $_SESSION['user']['email'] AND strtolower(substr($newEmail, -4)) == '.com')  {
    $updateEmailQry = "UPDATE users SET verification_code=:verification_code WHERE stud_number = :stud_number Limit 1";
    $insert_stmt = $conn->prepare($updateEmailQry);
    $pdoExe= $insert_stmt->execute(array(':stud_number' => $std_id,':verification_code' => $newVerification_code));
/// send email t0 the user containing verfication code
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
             $mail->addAddress($newEmail, $_SESSION['user']['fullname']);
 
             //Set email format to HTML
             $mail->isHTML(true);
 
            
$mail->Subject = 'Update Email Verification';
$mail->Body = '
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
<p>Dear Mr/Ms. <b>' . $_SESSION['user']['fullname'] . '</b>,</p>
<p>Your verification code for updating your new email is: <b style="font-size: 30px; background-color: #F5A623; padding: 5px 10px; border-radius: 5px;">' . $newVerification_code . '</b></p>
<p>Please enter this code in the verification page to confirm your email change.</p>
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

if($pdoExe){
    echo "success";
    exit;
}
    
} 
elseif ($newEmail == $_SESSION['user']['email']){
    echo("$newEmail is your old email address");
}
else {
    echo("$newEmail is not a valid email address");
}
} catch (PDOException $e) {
    echo $e->getMessage();
 }


?>




