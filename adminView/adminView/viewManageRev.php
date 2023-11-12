<?php 
session_start();
if($_SESSION['user']['studaccess'] == 0){
  debug_backtrace() || die ("<h2>Access Denied!</h2><br></br> Please contact the admin librarian"); 
}

?>
<div >
  <h2>Manage Reviews</h2>
  <table class="table " id="myTables">
    <thead>
      <tr>
        <th class="text-center">#</th>
        <th class="text-center">Student Number</th>
        <th class="text-center">Student Name</th>
        <th class="text-center">Book Title</th>
        <th class="text-center">Rating Rate</th>
        <th class="text-center">Rating Comments</th>
        <th class="text-center">Review Status</th>
        <th class="text-center">Actions</th>
        <th class="text-center">Delete</th>
        
       
      </tr>
    </thead>
    <?php
      include_once "../config/dbconnect.php";
      $sql = "SELECT review.*, users.*, books.book_title
      FROM review
      LEFT JOIN users ON CAST(review.stud_id AS UNSIGNED) = CAST(users.stud_number AS UNSIGNED)
      LEFT JOIN books ON review.book_id = books.book_id ORDER BY created DESC";
      $result=$conns-> query($sql);
      $count=1;
      if ($result-> num_rows > 0){
        while ($row=$result-> fetch_assoc()) {
           
    ?>
    <tr>
      <td><?=$count?></td>
      <td><?=$row["stud_number"]?></td>
      <td><?=$row["stud_first_name"]?> <?=$row["stud_last_name"]?></td>
      <td><?=$row["book_title"]?></td>
      <td><?=$row["ratingNumber"]?></td>
      <td><?=$row["comments"]?></td>
      <?php
      if($row["status"] == 0){
        echo "<td>Not Posted</td>";  
      }
      else{
        echo "<td>Posted</td>";  
      }
    
      ?> 
      <td>
  <?php if($row['status'] == 0 ) { ?>
    <button id="statusRevBtn<?=$row['review_id']?>" class="btn btn-success" style="height:40px" onclick="changeRevStatus(<?=$row['review_id']?>, 1)">Approve</button>
  <?php } elseif ($row['status'] == 1) { ?>
    <button id="statusRevBtn<?=$row['review_id']?>" class="btn btn-warning" style="height:40px" onclick="changeRevStatus(<?=$row['review_id']?>, 0)">Remove</button>
  <?php } ?>
</td>
      <td><button type="button"  class="btn btn-danger" style="height:40px" onclick="confirmDelReview(<?=$row['review_id']?>)">Delete</button></td>
      
    </tr>
    <?php
            $count=$count+1;
           
        }
    }
    ?>

<script>
    $(document).ready(function(){
        $('#myTables').DataTable();
        
        
    });
    







function changeRevStatus(review_id, newStatus) {
if(confirm("Are you sure you want to change the review status?")){

$.ajax({
    type: "POST",
    url: "controller/update_review_status.php",
    data: { review_id: review_id, new_status: newStatus },
    success: function(data) {
        $("#statusRevBtn" + review_id).html(data);
        if (newStatus == 0) {
            $("#statusRevBtn" + review_id).removeClass("btn-warning");
            
            $("#statusRevBtn" + review_id).addClass("btn-success");
            $("#statusRevBtn" + review_id).html("Approve");
        } else if (newStatus == 1) {
            $("#statusRevBtn" + review_id).removeClass("btn-success");

            $("#statusRevBtn" + review_id).addClass("btn-warning");
            $("#statusRevBtn" + review_id).html("Remove");
        }
        // Reload the table data
        
    }
});
}
}

</script>
  </table>
  

