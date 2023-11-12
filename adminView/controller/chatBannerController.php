<?php
session_start();

$admin_id = $_SESSION['user']['ad_email'];
include_once "../config/dbconnect.php";
$selChat = "SELECT * FROM admin_Lib WHERE admin_user = '$admin_id'";
$result = mysqli_query($conns, $selChat);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $currChat = $row['admin_currChat'];
} else {
    echo "Error: " . mysqli_error($conns);
}


    $output = "";
    $sql = "SELECT * FROM users WHERE stud_number = '$currChat'";
    $result = $conns->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $output .= '<img src="../userViewLibraBees/userpic/' . $row['stud_avatar'] . '" alt="./assets/images/student1.png" class="d-flex align-self-center me-3" width="60" height="60" style="border-radius: 50%;">';
            $output .= '<h3 style="margin: 0; font-size: 1.5rem;">' . $row['stud_first_name'] ." ". $row['stud_last_name'].'</h3>';
        }
    }
    echo $output;

?>
