


<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('location:login.php');
    
 }else{
    $std_id=$_SESSION['user']['std_id'];
    include_once "../config/dbconnect.php";
    
    
        $err_title = $_POST['titleRB'];
        $err_desc = $_POST['descRB'];
        $err_Img = $_FILES['imgBug'];
        
        
        
        if(!empty($err_title) AND !empty($err_desc) AND !empty($err_Img)){
            if($err_Img = $_FILES['imgBug']){
                $imgname = $_FILES['imgBug']['name'];
                $tmp_name = $_FILES['imgBug']['tmp_name'];

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
                        echo 1;
                        exit;
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

    }
?>