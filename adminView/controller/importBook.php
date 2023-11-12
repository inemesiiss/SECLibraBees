<?php
require "../config/dbconnect.php";

if(isset($_POST["import"])){
    $fileName = $_FILES["excel"]["name"];
    $fileExtension = explode('.', $fileName);
    $fileExtension = strtolower(end($fileExtension));
    $newFileName = date("Y.m.d") . " - " . date("h.i.sa") . "." . $fileExtension;
    $targetDirectory = "uploadFiles/" . $newFileName;
    move_uploaded_file($_FILES['excel']['tmp_name'], $targetDirectory);

    error_reporting(0);
    ini_set('display_errors', 0);

    require '../excelReader/excel_reader2.php';
    require '../excelReader/SpreadsheetReader.php';

    $reader = new SpreadsheetReader($targetDirectory);
    $duplicateBooks = array(); // to store duplicate book codes
    $insertedBooks = array(); // to store successfully inserted books
    foreach($reader as $key => $row){
        $book_title = mysqli_real_escape_string($conns, $row[0]);
        $book_code = mysqli_real_escape_string($conns, $row[1]);
        $book_author = mysqli_real_escape_string($conns, $row[2]);
        $book_image = mysqli_real_escape_string($conns, $row[3]);
        $book_status = mysqli_real_escape_string($conns, $row[4]);
        $days_can_barrowed = mysqli_real_escape_string($conns, $row[5]);
        $category_id = mysqli_real_escape_string($conns, $row[6]);
        $bookcategory_id = mysqli_real_escape_string($conns, $row[7]);
        $booksubject_id = mysqli_real_escape_string($conns, $row[8]);
        $bookdescription = mysqli_real_escape_string($conns, $row[9]);
        $bookcopies = mysqli_real_escape_string($conns, $row[10]);
        $pubdate = mysqli_real_escape_string($conns, $row[11]);
        $query = "INSERT IGNORE INTO books (book_title, book_code, book_author, book_desc, book_status, days_can_barrowed, category_id, bookcategory_id, booksubject_id, book_image, book_copies, publication_date) VALUES ('$book_title', '$book_code', '$book_author', '$bookdescription', '$book_status', '$days_can_barrowed', '$category_id', '$bookcategory_id', '$booksubject_id', '$book_image', '$bookcopies', '$pubdate')";
        if(mysqli_query($conns, $query)){
            if(mysqli_affected_rows($conns) > 0){
                $insertedBooks[] = $book_code;
            }
        }
        else{
            if(mysqli_errno($conns) == 1062){ // Check for duplicate entry error
                $duplicateBooks[] = $book_code;
            }
        }
    }
    if(count($insertedBooks) > 0){
        $message = "Successfully inserted books: " . implode(", ", $insertedBooks);
        echo "<script>alert('$message');</script>";
    }
    if(count($duplicateBooks) > 0){
        $message = "Books with the following codes already exist and were not inserted: " . implode(", ", $duplicateBooks);
        echo "<script>alert('$message');</script>";
    }
    header("Location: ../index.php");
}
?>
