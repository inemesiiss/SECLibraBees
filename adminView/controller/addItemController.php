<?php
    include_once "../config/dbconnect.php";
        $booktitle = $_POST['book_title'];
        $bookcode = $_POST['book_code'];
        $bookauthor = $_POST['book_author'];
        $bookdescription = $_POST['book_desc'];
        $bookstatus = $_POST['book_status'];
        $dcb = $_POST['days_can_barrowed'];
        $yrpub = $_POST['yr_pub'];
        $bcop = $_POST['b_copies'];
        $booksection = $_POST['booksection_select'];
        $bookcategories = $_POST['bookcategory_select'];
        $booksubj = $_POST['booksubject_select'];

        $name = $_FILES['file']['name'];
        $temp = $_FILES['file']['tmp_name'];
    
        $location="./uploads/";
        $image=$location.$name;

        $target_dir="../uploads/";
        $finalImage=$target_dir.$name;

        move_uploaded_file($temp,$finalImage);

        // Execute SELECT query to check for duplicates
        $query = "SELECT * FROM books WHERE book_code = '$bookcode'";
        $result = mysqli_query($conns, $query);

        // Check if book code already exists
        if (mysqli_num_rows($result) > 0) {
            echo 'Book Code is Duplicate!';
        } else {
            $insert = mysqli_query($conns,"INSERT INTO books
             (book_title,book_code,book_author,book_desc,book_status,days_can_barrowed,category_id,bookcategory_id,booksubject_id,book_image,publication_date,book_copies) 
             VALUES ('$booktitle','$bookcode','$bookauthor','$bookdescription','$bookstatus',$dcb,'$booksection','$bookcategories','$booksubj','$image','$yrpub',$bcop)");
     
             if(!$insert)
             {
                 echo mysqli_error($conns);
                 
             }
             else
             {
                echo"success";
             }
        }
       

      
?>
