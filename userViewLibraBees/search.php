<?php
session_start();
if (!isset($_SESSION['user'])) {
   header('location:login.php');
   
}
include '../config/dbconnect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Library</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <!-- swiper css link  -->
   <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
   <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
  

</head>
<body style="background-color: #FCD116;" >
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
   
<!-- header section starts  -->

<section class="header">

<a href="home.php" class="logo">LibraBees.</a>
   
   <nav class="navbar">
      <a href="home.php">HOME</a>   
      <a href="mybook.php">MYBOOKS</a>
      <a href="library.php">LIBRARY</a>
      <a href="logout.php">logout</a>
   </nav>

   <div id="menu-btn" class="fas fa-bars"></div>

</section>

<!-- sidebar section  -->
<nav class="w3-sidebar w3-bar-block w3-card w3-top w3-xlarge w3-animate-left" style="background-color: #FCD116; display:none;z-index:200; position:relative; width:40%;min-width:300px; margin-top: -100px; " id="mySidebar">
<a href="javascript:void(0)" onclick="w3_close()" class="w3-bar-item w3-button"></a>
<a href="javascript:void(0)" onclick="w3_close()" class="w3-bar-item w3-button"> </a>
<div style="text-align: right;">
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-bar-item w3-button"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
</div>

<div class="book-section" style="text-align: left; margin-left: 10%; margin-right: 10%;">
  <h1 class="section-heading">BOOK SECTION</h1>
  <div class="section1">
    <div class="section2">
      <?php
        $selBookFiltSec = "SELECT * FROM category";
        $resBookFiltSec = mysqli_query($conns, $selBookFiltSec);
        if(mysqli_num_rows($resBookFiltSec) > 0) {
          while($rowBookFiltSec = mysqli_fetch_assoc($resBookFiltSec)) {
            echo '<label><input type="checkbox" name="category[]" value="'.$rowBookFiltSec['category_id'].'">'.$rowBookFiltSec['category_name'].'</label>';
          }
        }
        else {
          echo "No Book Section Found.";
        }
      ?>
    </div>
  </div>
</div>


<div class="book-category" style="text-align: left; margin-left: 10%; margin-right: 10%;">
  <h1 class="category-heading">BOOK CATEGORY</h1>
  <div class="category1">
    <div class="category2">
      <?php
        $selBookFilCat = "SELECT * FROM bookcategory";
        $resBookFiltCat = mysqli_query($conns, $selBookFilCat);
        if(mysqli_num_rows($resBookFiltCat) > 0) {
          while($rowBookFiltCat = mysqli_fetch_assoc($resBookFiltCat)) {
            echo '<label><input type="checkbox" name="category[]" value="'.$rowBookFiltCat['bookcategory_id'].'">'.$rowBookFiltCat['bookcategory_name'].'</label>';
          }
        }
        else {
          echo "No Book Category Found.";
        }
      ?>
    </div>
  </div>
</div>


<div class="book-subject" style="text-align: left; margin-left: 10%;
    margin-right: 10%;">
    <h1 class="subject-heading">BOOK SUBJECT</h1>
    <div class="subject1">
      <div class="subject2">
      <?php
        $selBookFilSub = "SELECT * FROM subject";
        $resBookFiltSub = mysqli_query($conns, $selBookFilSub);
        if(mysqli_num_rows($resBookFiltCat) > 0) {
          while($rowBookFiltSub = mysqli_fetch_assoc($resBookFiltSub)) {
            echo '<label><input type="checkbox" name="category[]" value="'.$rowBookFiltSub['subject_id'].'">'.$rowBookFiltSub['subject_name'].'</label>';
          }
        }
        else {
          echo "No Book Category Found.";
        }
      ?>
      </div>
    </div>
</div>
   
</nav>

<!-- header section ends -->

<div class="heading" style="background:url(images/header-bg-2.jpg) no-repeat">
<h1>Books</h1>
</div>
<!-- search engine section starts  -->
<?php


if (isset($_GET['keyword'])) {
   $keyword = $_GET['keyword'];
} else {
   $keyword = "";
}

?>


<section class="booking">
            <form class="book-form" action="search.php" method="GET" style="background-color: #FCD116;">
            <div class="flex" style="background-color: #FCD116;">
            <div class="inputBox" style="text-align: center;">
            <input class= "form-control me-sm-2" type="text" placeholder="Book Title, Book Author..." name="keyword" requried maxlength="70" autocomplete="off" value="<?=  $keyword ?>">
            <br>
            <div style="text-align: center;">
            <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
            </div>
            </div>
            </div>
            </form>

</section>
<div style="text-align: center;">
<button class="btn btn-secondary my-2 my-sm-0" onclick="w3_open()" type="submit">Book Filter</button>
</div>

</form>
<?php
 $keyword=$_GET['keyword'];
 
 ?>


<!-- library section starts  -->

<section class="packages">

   <h1 class="heading-title">Search Result For: <span><?=$keyword ?></span></h1>

   <div class="box-container">

      <?php
      require './config/dbconnect.php';
      //pagination
      if(empty($keyword)){
         header("location:library.php");
      }

      if (!isset($_GET['page'])) {
         $page = 1;
      
      } 
      else 
      {
         $page = $_GET['page'];
      }
      $limit = 3;
      $offset = ($page - 1) * $limit;
      //--------------------
      $query = "SELECT * FROM books WHERE book_title LIKE '%$keyword%' limit $offset,$limit";
      $query_run = mysqli_query($conns, $query);
      $check_books = mysqli_num_rows($query_run)>0;

      if ($check_books)
      {
         while ($row = mysqli_fetch_assoc($query_run)) 
         
         {
            ?>

<form method="GET" class="box" action="book.php">
               <div class="image">
               <img src='../adminView<?=$row["book_image"]?>' alt="./uploads/lookhomewardangel.jpg">
               </div>
               <div class="content">
              <h3><?=$row["book_title"]?></h3>
               <p>By: <?=$row["book_author"]?></p>
              <input type="text" name = "currBook_ID" value="<?=$row['book_id']?>"hidden>
                  <button class="btn" type="submit">View Full Details</button>
             </div>

            </form>
         
            <?php


         }

      
      
      
      } else {

         echo "

         <div style='font-size: 24px;'>
             <h3 style='color: red;'>No Records Found</h3>
            <b>Suggestion:</b>
          <ul>
         <li>Make sure that words are spelled correctly.</li>
         <li>Try different keywords.</li>
         </ul>
      </div>";
      }



      ?>

   


   </div>

   <div><br></br></div>
   <nav aria-label="Page navigation example">
    <!--pagination begin--->
    <?php

      require './config/dbconnect.php';
    $pagination = "SELECT * FROM books WHERE book_title LIKE '%$keyword%'";
    $run_q = mysqli_query($conns,$pagination);
    $total_post = mysqli_num_rows($run_q);
    $limit = 3;
    $pages = ceil($total_post / $limit);

    ?>
    

    <ul class="pagination pagination-lg justify-content-center">
      <?php for($i=1; $i <=$pages ;  $i++) { ?>



      <li class="page-item <? ($i==$page) ? $active='active':''; ?>">
         <a href="search.php?keyword=<?=$keyword?>&page=<?= $i ?>" class="page-link">
            <?= $i ?>
         </a>
      </li>
      <?php } ?>
      <a class="page-link" href="#"></a>
</ul>
</nav>
</section>

<!-- library section ends -->




<!-- footer section starts  -->

<section class="footer">

   <div class="box-container">

      <div class="box">
         <h3>quick links</h3>
         <a href="home.php"> <i class="fas fa-angle-right"></i> home</a>
         <a href="about.php"> <i class="fas fa-angle-right"></i> about</a>
         <a href="library.php"> <i class="fas fa-angle-right"></i> library</a>
         <a href="book.php"> <i class="fas fa-angle-right"></i> book</a>
      </div>

      <div class="box">
         <h3>extra links</h3>
         <a href="#"> <i class="fas fa-angle-right"></i> ask questions</a>
         <a href="#"> <i class="fas fa-angle-right"></i> about us</a>
         <a href="#"> <i class="fas fa-angle-right"></i> privacy policy</a>
         <a href="#"> <i class="fas fa-angle-right"></i> terms of use</a>
      </div>

      <div class="box">
         <h3>contact info</h3>
         <a href="#"> <i class="fas fa-phone"></i> +123-456-7890 </a>
         <a href="#"> <i class="fas fa-phone"></i> +111-222-3333 </a>
         <a href="#"> <i class="fas fa-envelope"></i> shaikhanas@gmail.com </a>
         <a href="#"> <i class="fas fa-map"></i> mumbai, india - 400104 </a>
      </div>

      <div class="box">
         <h3>follow us</h3>
         <a href="#"> <i class="fab fa-facebook-f"></i> facebook </a>
         <a href="#"> <i class="fab fa-twitter"></i> twitter </a>
         <a href="#"> <i class="fab fa-instagram"></i> instagram </a>
         <a href="#"> <i class="fab fa-linkedin"></i> linkedin </a>
      </div>

   </div>

   <div class="credit"> created by <span>mr. web designer</span> | all rights reserved! </div>

</section>

<!-- footer section ends -->
<!-- swiper js link  -->
<script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
<style>

#filterSidebar{
   background-color:white; /* Black*/
      height: 100%; /* 100% Full-height */
      width: 0; /* 0 width - change this with JavaScript */
      position: fixed; /* Stay in place */
      z-index: 1; /* Stay on top */
      top: 0;
      left: 0;
      display: flex;
  align-items: flex-start;
      
      overflow-x: hidden; /* Disable horizontal scroll */
      padding-top: 20%; /* Place content 60px from the top */
      transition: 0.5s; /* 0.5 second transition effect to slide in the sidebar */
}


*{padding:0;margin:0;}



.float{
	position:fixed;
	width:60px;
	height:60px;
	bottom:40px;
	right:40px;
	background-color:#0C9;
	color:#FFF;
	border-radius:50px;
	text-align:center;
	box-shadow: 2px 2px 3px #999;
}

.my-float{
	margin-top:22px;
}

#mySidebar {
  
  width: 300px;
  
  top: 200px;
 
   /* adjust the value to match the height of your header */
}
</style>
<script>
// Script to open and close sidebar
function w3_open() {
  document.getElementById("mySidebar").style.display = "block";
}
 
function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
}
</script>
</html>
