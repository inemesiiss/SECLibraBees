require './config/dbconnect.php';
<?php
// Retrieve form data
$rating = $_POST['rating'];
$comments = $_POST['comments'];
$stud_id = $_POST['stud_id'];
$book_id = $_POST['book_id'];

// Sanitize and validate form data (e.g. check if rating is a valid number)

// Insert form data into MySQL table
$sql = "INSERT INTO review (stud_id, book_id, ratingNumber, comments)
        VALUES ('$stud_id', '$book_id', '$rating', '$comments')";

if ($conns->query($sql) === TRUE) {
    echo "Rating saved successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conns->error;
}

// Close MySQL connection
$conns->close();

?>