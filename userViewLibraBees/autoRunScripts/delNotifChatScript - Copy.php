<?php
session_start();
include '../config/dbconnect.php';

date_default_timezone_set('Asia/Manila');
echo "<span style='color:red;font-weight:bold;'>Date: </span>". date('F j, Y g:i:a  ');

// Get the notifications that are older than 7 days
$delOldNotifications = "SELECT * FROM notifications WHERE publish_dt <= DATE_SUB(CURRENT_TIMESTAMP(),INTERVAL 7 DAY)";
$result4 = $conns->query($delOldNotifications);

if ($result4->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Delete the notification from the table
        $deleteNotification = "DELETE FROM notifications WHERE notif_id=" . $row['notif_id'];
        $deleteResult = $conns->query($deleteNotification);

        if ($deleteResult) {
            echo "Notification deleted successfully.";
        } else {
            echo "Error deleting notification.";
        }
    }
} // <- add this closing curly brace


$SelOldChat = "SELECT * FROM chat WHERE chat_time <= DATE_SUB(CURRENT_TIMESTAMP(),INTERVAL 30 DAY)";
$result2 = $conns->query($SelOldChat);

if ($result2->num_rows > 0) {

// Get the chat messages that are older than 30 days and where chat_receiver and chat_sender are empty strings
$delOldChatMessages = "DELETE FROM chat WHERE chat_id=" . $row['chat_id'];
$result1 = $conns->query($delOldChatMessages);

if ($result1) {
    echo "Chat messages deleted successfully.";
} else {
    echo "Error deleting chat messages.";
}
}
?>
