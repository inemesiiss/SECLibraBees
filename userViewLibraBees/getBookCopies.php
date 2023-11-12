

<?php
require_once '../config/ddbconnect.php';
require_once '../config/dbconnect.php';
session_start();

$std_id=$_SESSION['user']['std_id'];
$bookid=$_SESSION['user']['book_id'];

    
   if(isset($_POST['data'])){
    $selectNumBookCop="SELECT book_copies FROM books WHERE book_id = $bookid";
    $result=$conns-> query($selectNumBookCop);

    if ($result-> num_rows > 0){
       while ($row=$result-> fetch_assoc()) {
        
      echo $row['book_copies'];

    
      
   
       }

       }

      }
      ?>

      
