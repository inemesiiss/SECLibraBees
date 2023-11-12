


<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('location:login.php');
    
 }
    $std_id=$_SESSION['user']['std_id'];
    include_once "../config/dbconnect.php";
    
    
        $c_num = $_POST['stud_cnum'];
        $yrlvl = $_POST['yr_lvl'];
        $grlvl = $_POST['grdlvl'];
        $course = $_POST['course'];
        $stud_avatar = $_FILES['stud_avatar'];

        $update = mysqli_query($conns,"UPDATE users SET 
        stud_contact_no='$c_num', 
        stud_yrlvl='$yrlvl', 
        stud_gradelvl='$grlvl',
        stud_course='$course'
        WHERE stud_number=$std_id");
        if($update){
        echo "success";
        } else {
        echo "Update query failed: " . mysqli_error($conns);
        }
        var_dump($c_num, $yrlvl, $course, $std_id, $update);
        
            if(!empty($_FILES['stud_avatar'])){
                $imgname = $_FILES['stud_avatar']['name'];
                $tmp_name = $_FILES['stud_avatar']['tmp_name'];

                $img_explode = explode('.',$imgname);
                $img_ext = end($img_explode);

                $extensions = ['png','jpeg','jpg'];
                if(in_array($img_ext, $extensions)== true){
                    $time =  time();// will return the current time
                                    // we need this time beacaise when you uploading user img to in our folder rename user file cause we want the files to be unique for evry user upload
                    $new_img_name = $time.$imgname;
                    if(move_uploaded_file($tmp_name, "userpic/".$new_img_name));
                    $update = mysqli_query($conns,"UPDATE users SET 
                    stud_contact_no='$c_num', 
                    stud_yrlvl='$yrlvl', 
                    stud_course='$course',
                    stud_gradelvl='$grlvl',
                    stud_avatar='$new_img_name'
                    WHERE stud_number=$std_id");
                    if($update){
                        echo "success";
                    }else{
                        echo"something went wrong!";
                    }
                }
                else{
                    echo "please select an Image file! - jpeg, jpg, png!";
                }
            }

    
?>