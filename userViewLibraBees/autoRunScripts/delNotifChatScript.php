<?php
session_start();
include '../config/dbconnect.php';

date_default_timezone_set('Asia/Manila');
echo "<span style='color:red;font-weight:bold;'>Date: </span>". date('F j, Y g:i:a  ');

$SelOldChat = "SELECT * FROM chat WHERE chat_time <= DATE_SUB(CURRENT_TIMESTAMP(),INTERVAL 30 DAY)";
$result = $conns->query($SelOldChat);

if ($result->num_rows > 0) {
$chat_id = $row['chat_id'];
// Get the chat messages that are older than 30 days and where chat_receiver and chat_sender are empty strings
$delOldChatMessages = "DELETE FROM chat WHERE chat_id=$chat_id";
$result = $conns->query($delOldChatMessages);

if ($result) {
    echo "Chat messages deleted successfully.";
} else {
    echo "Error deleting chat messages.";
}
}
?>
