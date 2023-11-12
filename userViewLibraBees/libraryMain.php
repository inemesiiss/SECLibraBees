<?php
require './config/dbconnect.php';
session_start();
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['verify_status'] == null) {
      header("Location: verifyemail.php");
      exit();
    } else {
      // this code will be executed when the user is verified
      
    }
  } else {
    // user is not logged in, redirect to login page
    header("Location: login.php");
    exit();
  }
$std_id=$_SESSION['user']['std_id'];
$yr_lvl=$_SESSION['user']['yr_lvl'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>SECLibraBees</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/jquery-ui.css">
    <link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/x-icon" href="LB.ico">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed" style="--kt-toolbar-height:55px;
--kt-toolbar-height-tablet-and-mobile:55px  " cz-shortcut-listen="true">


<section class="header">
   

<a href="home.php" class="logo" style="text-decoration: none;"><img src="images/LB.png" alt="" style="  height: 3rem; margin-left: 1.5rem;"> LibraBees</a>
<div class="box">
   <?php
   $selAvatar ="SELECT stud_avatar FROM users where stud_number ='$std_id'";
   $result = mysqli_query($conns, $selAvatar);
      if ($result) {
      $row = mysqli_fetch_assoc($result);
      $stud_avatar = $row['stud_avatar'];
      }
   ?>
         
         
         <h6></h6>
      </div>


      <nav class="navbar" style="margin-right: 2.5rem; font-size: 1.8rem; display: flex; align-items: center;">
   <div class="box">
      <img style="height: 3rem;" id="myNotifImg" src="images/icon-5.png" alt="">
      <span class="badge bg-danger rounded-pill float-end" style="font-size:1rem;" id="notifNum"></span>
   </div>

   <a href="home.php">HOME</a>   
   <a href="mybook.php">MYBOOKS</a>
   <a href="libraryMain.php">LIBRARY</a>
   <a href="#" onclick="logout();" >
         <img src="userpic/<?php echo ($stud_avatar != null) ? $stud_avatar : 'images/student1.png'; ?>" alt="Profile Picture" style="border-radius: 50%;   margin-left: 1.5rem;" width="45" height="45">
         log out
      </a>
</nav>
   

   <div id="menu-btn" class="fas fa-bars"></div>

</section>

<!-- header section ends -->

<div class="heading" style="background:url(images/header-bg-2.jpg) no-repeat">
   <h1></h1>
</div>
<center>
<a href="#" class="trigger" style="font-size: 6rem; color: #222;"><i class="fa-solid fa-circle-exclamation" style="font-size: 2rem; color: #222;">Rules & Regulations</i></a>
</center>                  
                        <div class="message-box">
                        <span class="message" style="text-transform: none;">Library Rules and Regulations:

1. Silence must be observed at all times in the library.
2. Food and drinks are not allowed inside the library.
3. Use of mobile phones is strictly prohibited inside the library.
4. Borrowed materials must be returned on or before the due date.
5. Users must not deface, damage or destroy library materials and equipment.
6. Only registered library users are allowed to use the library facilities.
7. Users are required to present their library ID when borrowing books or accessing electronic resources.
8. Library staff have the authority to enforce library rules and regulations.
9. Violation of library rules and regulations may result in suspension of library privileges.
10. All library users are required to comply with the library rules and regulations.

Thank you for your cooperation.</span>
                        </div>


    <div class="d-flex flex-column flex-root" style="background-color: #FCD116;">
        <div class="page d-flex flex-row flex-column-fluid" style="background-color: #FCD116;">

            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper" style="background-color: #FCD116;">

                <div id="kt_header" >
                    <div class="container-xxl d-flex align-items-center">

                        <div class="header-logo me-5 me-md-10 flex-grow-1 flex-lg-grow-0">
                            
                               
                            </a>
                        </div>
                        
                        

                        <div class="d-flex w-100 align-items-center">
                            <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black"></rect>
                                    <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black"></path>
                                </svg>
                            </span>
                            <input id="searchKeyword" type="text" class="form-control form-control-solid ps-14" placeholder="Book Title... Book Author..">
                        </div>

                    </div>
                </div>

                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="product d-flex flex-column-fluid" id="kt_product">
                        <div id="kt_content_container" class="container-xxl">

                            <div class="d-flex flex-column flex-xl-row">
                                <div class="flex-column flex-lg-row-auto w-100 w-xl-300px mb-1">
                                    <div class="card fs-6 text-gray-700 fw-bold card-flush ">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>Filters</h2>
                                            </div>
                                            <div class="card-toolbar d-block d-lg-none drop-inactive">
                                                <svg width="12" height="12" viewBox="0 0 16 27" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M16 23.207L6.11 13.161 16 3.093 12.955 0 0 13.161l12.955 13.161z" fill="#5e6278" ></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="card-body filter-card p-0" >
                                            
                                           
                                            <div class="separator "></div>
                                            <div class="card card-flush ">
                                                <div class="card-header">
                                                    <div class="card-title">
                                                        <h4>Book Section</h4>
                                                    </div>
                                                    <div class="card-toolbar drop-active">
                                                        <svg width="12" height="12" viewBox="0 0 16 27" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M16 23.207L6.11 13.161 16 3.093 12.955 0 0 13.161l12.955 13.161z" fill="#5e6278" ></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="pt-0 card-body">
                                                    <?php
                                                    $query = mysqli_query($conns, "SELECT DISTINCT(category_id) FROM books ORDER BY book_id ASC ");
                                                    while ($row = mysqli_fetch_array($query)) {
                                                        echo '<div class="mb-2 form-check form-check-custom form-check-solid me-10">
                                                            <input class="form-check-input" data-filter="bk_sec" type="checkbox" value="' . $row["category_id"] . '" id="bk_sec' . $row["category_id"] . '" />
                                                            <label class="form-check-label" for="bk_sec' . $row["category_id"] . '">
                                                                ' . $row["category_id"] . '
                                                            </label>
                                                        </div>';
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                            <div class="separator "></div>
                                            <div class="card card-flush ">
                                                <div class="card-header">
                                                    <div class="card-title">
                                                        <h4>Book Category</h4>
                                                    </div>
                                                    <div class="card-toolbar drop-active">
                                                        <svg width="12" height="12" viewBox="0 0 16 27" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M16 23.207L6.11 13.161 16 3.093 12.955 0 0 13.161l12.955 13.161z" fill="#5e6278" ></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="pt-0 card-body">
                                                    <?php
                                                    $query = mysqli_query($conns, "SELECT DISTINCT(bookcategory_id) FROM books ORDER BY book_id ASC ");
                                                    while ($row = mysqli_fetch_array($query)) {
                                                        echo '<div class="mb-2 form-check form-check-custom form-check-solid me-10">
                                                    <input class="form-check-input" type="checkbox"  data-filter="bk_cat"  value="' . $row["bookcategory_id"] . '" id="bk_cat' . $row["bookcategory_id"] . '" />
                                                    <label class="form-check-label" for="bk_cat' . $row["bookcategory_id"] . '">
                                                        ' . $row["bookcategory_id"] . ' 
                                                    </label>
                                                </div>';
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="separator "></div>
                                            <div class="card card-flush ">
                                                <div class="card-header">
                                                    <div class="card-title">
                                                        <h4>Book Subject</h4>
                                                    </div>
                                                    <div class="card-toolbar drop-active">
                                                        <svg width="12" height="12" viewBox="0 0 16 27" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M16 23.207L6.11 13.161 16 3.093 12.955 0 0 13.161l12.955 13.161z" fill="#5e6278" ></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="pt-0 card-body">
                                                    <?php
                                                    $query = mysqli_query($conns, "SELECT DISTINCT(booksubject_id) FROM books ORDER BY book_id ASC ");
                                                    while ($row = mysqli_fetch_array($query)) {
                                                        echo '<div class="mb-2 form-check form-check-custom form-check-solid me-10">
                                                    <input class="form-check-input" type="checkbox"  data-filter="bk_subj" value="' . $row["booksubject_id"] . '" id="bk_subj' . $row["booksubject_id"] . '" />
                                                    <label class="form-check-label" for="bk_subj' . $row["booksubject_id"] . '">
                                                        ' . $row["booksubject_id"] . ' 
                                                    </label>
                                                </div>';
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-lg-row-fluid ms-lg-1">
                                    <div id="productsContainer" class="row g-1">

                                    </div>
                                    <div id="pagination">


                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>


                

            </div>
        </div>
    </div>



 <!-- .Notification Modal -->
<div class="modal fade" id="myNotifModal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
         <h1 class="modal-title">Notification</h1>   
         <button type="button" class="close" style="font-size: 3rem; background-color: #FCD116;"data-bs-dismiss="modal">&times;</button>                                                           
			</div> 
			<div class="modal-body" id="modal-body" style="height:500px; overflow-y: scroll;">
            <div>
            <h1> Announcement </h1>
         <?php
         // getting the announcement
               require './config/dbconnect.php';
               $sql = "SELECT *
               FROM notifications
               WHERE (send_to = 'All' AND CURDATE() BETWEEN notif_time AND notif_end)
                  OR (send_to = '$yr_lvl' AND CURDATE() BETWEEN notif_time AND notif_end)
               ORDER BY notif_time DESC";
                  $result=$conns-> query($sql);
               if ($result-> num_rows > 0){
                  while ($row=$result-> fetch_assoc()) {    
            ?>
            <div><h2 style="float:left;"><?=$row["notif_title"]?></div>
            <input class="myNotifButton bee-theme" type="button" value="Read"></input>
               <div class="notifcontainer" style='text-align:right;'>
               <div style="background-color: #fbee34; border: 2px solid #f6c90e; border-radius: 5px; padding: 10px; margin-bottom: 10px;">
                     <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                     <h6><?=$row["notif_time"]?></h6>
                     </div>
                     <div style="background-color:#fff; border-radius: 5px; padding: 10px;">
                     <h2 style="font-size: 14px; margin: 0; text-transform: none; text-align: justify;"><?=$row["notif_msg"]?>.</h2>
                     </div>
                     <div style="display: flex; justify-content: flex-end; margin-top: 5px;">
                     </div>
                     </div>
               </div>
               <hr />
               <?php
                     }
               }else{
                  echo"<div style='text-align: center;'>
                 Currently No Announcement. 
                  </div>";
               }
               ?>
               </div>
               <div>
               <h1>  Book Notification </h1>
         <?php
         // getting the notification based on student ID,year level and ALL filter
               require './config/dbconnect.php';
               $std_id=$_SESSION['user']['std_id'];
               $sqlBookNotif = "SELECT * FROM notifications WHERE send_to ='$std_id' ORDER BY publish_dt DESC";
                  $result=$conns-> query($sqlBookNotif);

               if ($result-> num_rows > 0){
                  while ($row=$result-> fetch_assoc()) {
            ?>
            <div><h2 style="float:left"><?=$row["notif_title"]?></h2></div>
            <input class="myNotifButton bee-theme" type="button" value="Read"></input>
            <div  class="notifcontainer" style='text-align:right;'>
                     <div style="background-color: #fbee34; border: 2px solid #f6c90e; border-radius: 5px; padding: 10px; margin-bottom: 10px;">
                     <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                     <h6><?=$row["notif_time"]?></h6>
                     </div>
                     <div style="background-color:#fff; border-radius: 5px; padding: 10px;">
                     <h2 style="font-size: 14px; margin: 0; text-transform: none; text-align: justify;"><?=$row["notif_msg"]?>.</h2>
                     </div>
                     <div style="display: flex; justify-content: flex-end; margin-top: 5px;">
                     </div>
                     </div>
               </div>
               <?php
                     }
                     
                     
               }else{
                  echo"<div style='text-align: center;'>
                 Currently No Book Notification. 
                  </div>";
               }

               ?>
               </div>
			</div>  
		</div>                                                                       
	</div>                                      
</div>
    

    <!-- swiper js link  -->
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <!-- custom js file link  -->
    <script src="js/script.js"></script>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/script.js"></script>
    

</body>


<style>
 .info-hover {
  display: none; /* Hide the hover content by default */
  position: absolute;
  top: 100%;
  left: 0;
  z-index: 1;
  background-color: #fff;
  box-shadow: 0px 2px 4px rgba(0,0,0,0.2);
  padding: 10px;
}


p:hover + .info-hover {
  display: block; /* Show the hover content when the paragraph is hovered over */
}
span{
   text-align: left;
}

</style>




</html>
<script>
var messageBox = document.querySelector('.message-box');


function showMessage() {
  messageBox.style.display = 'block';
}


function hideMessage() {
  messageBox.style.display = 'none';
}


var trigger = document.querySelector('.trigger');
trigger.addEventListener('mouseenter', showMessage);
trigger.addEventListener('mouseleave', hideMessage);
</script>



