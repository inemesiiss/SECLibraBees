<?php
include_once "../config/dbconnect.php";
$searchTerm =$_POST['searchTerm'];

$output = "";

$selStudChat = $selStudChat = "SELECT *
FROM chat
INNER JOIN users ON chat.chat_sender = users.stud_number
WHERE users.stud_first_name LIKE '%$searchTerm%'
GROUP BY chat_sender
ORDER BY users.stud_first_name ASC, chat_time DESC";
$result = $conns->query($selStudChat);

if (!$result) {
    die("Query failed: " . $conns->error);
}

if ($result->num_rows > 0) {
    include "data.php";
} else {
    $output .="No user found related to your search";
}
echo $output;

?>