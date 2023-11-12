<div style="transform: scale(0.7);  transform-origin: top left; position:">
  <h2>Returned Books</h2>
  <table class="table " id="myTables">
    <thead>
      <tr>
      <th class="text-center">S.N.</th>
        <th class="text-center">Book Image</th>
        <th class="text-center">Book Title</th>
        <th class="text-center">Book Author</th>
        <th class="text-center">Book Status</th>
        <th class="text-center">Pick-Up Time</th>
        <th class="text-center">Borrowed Time</th>
        <th class="text-center">Returned Time</th>
        <th class="text-center">Student Number</th>
        <th class="text-center">Student Name</th>
        <th class="text-center">Borrow Duration (days)</th>
        <th class="text-center">Days Exceeded</th>
        <th class="text-center">Total Fine</th>
        <th class="text-center">Adjust Fine</th>

       
      </tr>
    </thead>
    <?php
      include_once "../config/dbconnect.php";
      $sql="SELECT * from barrow_book where book_status=3 ORDER BY return_dt DESC";
      $result=$conns-> query($sql);
      $count=1;
      if ($result-> num_rows > 0){
        while ($row=$result-> fetch_assoc()) {
          $bookfine = $row['dt_overdue'] * 5;
           
    ?>
    <tr>
      <td><?=$count?></td>
      <td><img height='100px' src='<?=$row["book_image"]?>'></td>
      <td><?=$row["book_title"]?></td>
      <td><?=$row["book_author"]?></td>
      <?php
      if($row["book_status"] == 3){
        echo "<td>RETURNED</td>";  
      }
      else{
        echo "<td>Error</td>";  
      }
      ?> 
      <td><?=$row["pickup_dt"]?></td>
      <td><?=$row["barrow_dt"]?></td>
      <td><?=$row["return_dt"]?></td>
      <td><?=$row["stud_number"]?></td>
      <td><?=$row["stud_barr_name"]?></td>
      <td><?=$row["days_can_barrowed"]?>(days)</td>
      <td><?php if($row['dt_overdue'] == null){ echo "N/A";}else{echo "<span style='color: red;'>" . $row['dt_overdue'] . "</span>";}?></td> 
      <td><?php if($row['dt_overdue'] == null){ echo "N/A";}else{echo "<span style='color: red;'>" . $bookfine . " PHP</span>";}?></td> 
      <td>
        <button type="button" class="btn btn-success" style="height:40px" onclick="showInputBox('<?=$row['barrow_id']?>')">Edit</button>
        <div id="inputBox_<?=$row['barrow_id']?>" style="display:none">
          <input type="number" id="updatedValue_<?=$row['barrow_id']?>" value="<?=$row['dt_overdue']?>" />
          <button type="button" class="btn btn-primary" onclick="updateValue('<?=$row['barrow_id']?>')">Update</button>
        </div>
      </td>
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
</script>
  </table>
  </div>
  <script>
function showInputBox(borrowId) {
  document.getElementById('inputBox_' + borrowId).style.display = 'block';
}

function hideInputBox(borrowId) {
  document.getElementById('inputBox_' + borrowId).style.display = 'none';
}


function updateValue(borrowId) {
  var updatedValue = document.getElementById('updatedValue_' + borrowId).value;
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      // Update the table cell with the new value
      
      // Hide the input box
      hideInputBox(borrowId);
    }
  };
  xhttp.open('POST', 'controller/updateFineBooksController.php', true);
  xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhttp.send('borrow_id=' + borrowId + '&updated_value=' + updatedValue);
}
</script>
  