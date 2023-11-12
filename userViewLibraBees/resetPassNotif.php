


<?php
session_start();

    include_once "../config/dbconnect.php";
    $std_id=$_POST['studnum'];
    $std_email=$_POST['user_email'];
    $err_title = $_POST['titleRB'];
    
    $err_Img = $_FILES['id_pic'];
    $selStud = "SELECT * FROM users WHERE stud_number = '$std_id'";
    $result = mysqli_query($conns, $selStud);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

    // Extract the student email and name
    $stud_email = $row['stud_email'];
    
    $stud_name = $row['stud_first_name'].' '.$row['stud_last_name'];
    $err_desc = "Password Reset Request by $stud_name and Student ID : $std_id";
    if($std_email == $stud_email){

        if(!empty($err_title) AND !empty($err_desc) AND !empty($err_Img)){
            if($err_Img = $_FILES['id_pic']){
                $imgname = $_FILES['id_pic']['name'];
                $tmp_name = $_FILES['id_pic']['tmp_name'];
                $img_explode = explode('.',$imgname);
                $img_ext = end($img_explode);

                $extensions = ['png','jpeg','jpg'];
                if(in_array($img_ext, $extensions)== true){
                    $time =  time();// will return the current time
                                    // we need this time beacaise when you uploading user img to in our folder rename user file cause we want the files to be unique for evry user upload
                    $new_img_name = $time.$imgname;
                    if(move_uploaded_file($tmp_name, "images/".$new_img_name));
                    $insert = mysqli_query($conns,"INSERT INTO errQueries
                    (err_title,err_sender,err_desc,err_Img) VALUES ('$err_title','$std_id','$err_desc','$new_img_name')") OR die();
                    if($insert){
                        echo "success";
                        
                    }else{
                        echo"something went wrong!";
                    }
                   

                }
                else{
                    echo "please select an Image file! - jpeg, jpg, png!";
                }
            }else{
                echo "please select an Image file!";
            }

        
        
            
        }else{
            echo"Please complete the required fields.";
        }
            // Rows are found, do something
    }else{
        echo"Email does not match!";
    }
    } else {
        echo"Details does not match!";
    }

    
?>