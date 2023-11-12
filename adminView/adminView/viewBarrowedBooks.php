<?php
session_start();
if($_SESSION['user']['bookaccess'] == 0){
  debug_backtrace() || die ("<h2>Access Denied!</h2><br></br> Please contact the admin librarian"); 
}
?>
<div style="transform: scale(0.7);  transform-origin: top left; position:">
  <h2>Borrowed Books</h2>
  <table id="myTables" class="table">
    <thead>
      <tr>
        <th class="text-center">S.N.</th>
        <th class="text-center">Book Image</th>
        <th class="text-center">Book Title</th>
        <th class="text-center">Book Author</th>
        <th class="text-center">Book Status</th>
        <th class="text-center">Pick-Up TM</th>
        <th class="text-center">Borrow TM</th>
        <th class="text-center">Days Exceed</th>
        <th class="text-center">Student Number</th>
        <th class="text-center">Student Name</th>
        <th class="text-center">Borrow Duration</th>
        <th class="text-center">Change Status</th>
        <th class="text-center">Cancel</th>
      </tr>
    </thead>
    <?php
      include_once "../config/dbconnect.php";


      $sql="SELECT * from barrow_book WHERE book_status<=2 ORDER BY pickup_dt DESC";
      $result=$conns->query($sql);
      $count=1;
      if ($result-> num_rows > 0){
        while ($row=$result-> fetch_assoc()) {
          $borrow_id=$row['barrow_id'];
          $sqlUpdt = "UPDATE barrow_book
          SET dt_overdue = CAST(DATEDIFF(CURDATE(), DATE_ADD(barrow_dt, INTERVAL days_can_barrowed DAY)) AS UNSIGNED)
          WHERE barrow_id = '$borrow_id' AND book_status =2 AND barrow_dt <= DATE_SUB(CURRENT_TIMESTAMP(),INTERVAL days_can_barrowed DAY)";
  
            $resultUpdate = mysqli_query($conns, $sqlUpdt);
            
            if (!$resultUpdate) {
              // Handle update error
              echo "Error updating table: " . mysqli_error($conns);
            } else {
              // Handle successful update
              //echo "Table updated successfully!";
            }

        
  
    ?>
    <tr>
      <td><?=$count?></td>
      <td><img height='100px' src='<?=$row["book_image"]?>'></td>
      <td><?=$row["book_title"]?></td>  
      <td><?=$row["book_author"]?></td> 
      <?php
      if ($row["book_status"] == 1) {
        echo "<td>FOR PICK-UP</td>";  
      }
      elseif ($row["book_status"] == 2 && !is_null($row["dt_overdue"])) {
        echo "<td><span style='color: red;'>ON BORROW (OVERDUE)</span></td>";  
      }
      elseif ($row["book_status"] == 2) {
        echo "<td>ON BORROW</td>";  
      }
      elseif ($row["book_status"] == 3) {
        echo "<td>RETURNED</td>";  
      }
      ?>
      <td><?=$row["pickup_dt"]?></td>
      <?php
      if($row["barrow_dt"] == null ){
        echo "<td>N/A</td>";  
      }
      else{
        echo "<td>" .$row["barrow_dt"]. "</td>";  
      }
      ?> 
      <td><?php if($row['dt_overdue'] == null){ echo "N/A";}else{echo "<span style='color: red;'>" . $row['dt_overdue'] . "</span>";}?></td> 
      <td><?=$row["stud_number"]?></td> 
      <td><?=$row["stud_barr_name"]?></td>  
      <td><?=$row["days_can_barrowed"]?> Days</td>
      <td>
  <?php if($row['book_status'] == 1) { ?>
    <button id="statusBtn<?=$row['barrow_id']?>" class="btn btn-warning" style="height:40px" onclick="changeBookStatus(<?=$row['barrow_id']?>, 2)">Borrow</button>
  <?php } elseif ($row['book_status'] == 2) { ?>
    <button id="statusBtn<?=$row['barrow_id']?>" class="btn btn-success" style="height:40px" onclick="changeBookStatus(<?=$row['barrow_id']?>, 3)">Return</button>
  <?php } elseif ($row['book_status'] == 3) { ?>
    <button id="statusBtn<?=$row['barrow_id']?>" class="btn btn-success" style="height:40px" disabled>Already Returned</button>
  <?php } ?>
</td>
      <td><button class="btn btn-danger" style="height:40px" onclick="cancelBorrow(<?=$row['barrow_id']?>)">Cancel</button></td>
    </tr>
    <?php
          $count++;
        }
      }
      else{
        
      }
      $conns->close();
    ?>
  </table>
  <div>
<button type="button" class="btn btn-success " style="height:40px" onclick="showReturnedBooks()">
    View Returned Books
  </button><button type="button" class="btn btn-warning " style="height:40px" onclick="showReserveBook()">
    View Reserve Books
  
  </div>
 
  
 
</div>


<script>


    $(document).ready(function(){
        $('#myTables').DataTable();
        
        
    });

  



function changeBookStatus(borrowID, newStatus) {
  if(confirm("Are you sure you want to change the book status?")){
    
    $.ajax({
        type: "POST",
        url: "controller/updateBookStatController.php",
        data: { borrow_id: borrowID, new_status: newStatus },
        success: function(data) {
            $("#statusBtn" + borrowID).html(data);
            if (newStatus == 2) {
                $("#statusBtn" + borrowID).removeClass("btn-warning");
                
                $("#statusBtn" + borrowID).addClass("btn-success");
                $("#statusBtn" + borrowID).html("Return");
            } else if (newStatus == 3) {
                $("#statusBtn" + borrowID).removeClass("btn-warning");

                $("#statusBtn" + borrowID).addClass("btn-success");
                $("#statusBtn" + borrowID).html("Returned");
            }
            // Reload the table data
            
        }
    });
  }
}

</script>

