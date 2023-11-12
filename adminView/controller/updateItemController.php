<?php
    include_once "../config/dbconnect.php";

    $book_id=$_POST['book_id'];
    $b_title= $_POST['b_title'];
    $b_code= $_POST['b_code'];
    $b_author= $_POST['b_author'];
    $b_desc= $_POST['b_desc'];
    $b_stat= $_POST['b_stat'];
    $daysbarrowed= $_POST['daysbarrowed'];
    $category= $_POST['category'];
    $b_category= $_POST['b_category'];
    $b_subject= $_POST['b_subject'];
    $b_copies= $_POST['b_copies'];
    $yr_pub= $_POST['yr_pub'];

    
        $sql = "UPDATE books SET 
            book_title='$b_title', 
            book_code='$b_code', 
            book_author='$b_author',
            book_desc='$b_desc',
            book_status=$b_stat,
            days_can_barrowed=$daysbarrowed,
            category_id='$category',
            bookcategory_id='$b_category',
            booksubject_id='$b_subject',
            book_copies=$b_copies,
            publication_date='$yr_pub'
            WHERE book_id=$book_id";
            $result = mysqli_query($conns, $sql);

            if($result) {
                echo "success";
            } else {
                echo "Error updating record: " . mysqli_error($conns);
            }
        
    if(isset($_FILES['newImage'])){
        $location="./uploads/";
        $img = $_FILES['newImage']['name'];
        $tmp = $_FILES['newImage']['tmp_name'];
        $dir = '../uploads/';
        $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif','webp');
        $image =rand(1000,1000000).".".$ext;
        $final_image=$location.$image;
        if (in_array($ext, $valid_extensions)) {
            $path = UPLOAD_PATH . $image;
            move_uploaded_file($tmp, $dir.$image); 
            $sql = "UPDATE books SET 
            book_title='$b_title', 
            book_code='$b_code', 
            book_author='$b_author',
            book_desc='$b_desc',
            book_status=$b_stat,
            days_can_barrowed=$daysbarrowed,
            category_id='$category',
            bookcategory_id='$b_category',
            booksubject_id='$b_subject',
            book_image='$final_image' 
            WHERE book_id=$book_id";
        } else {
            echo "Invalid file extension";
            
        }
        $result = mysqli_query($conns, $sql);

    if($result) {
        echo "success";
    } else {
        echo "Error updating record: " . mysqli_error($conns);
    }

    
    }
    

   

    
?>