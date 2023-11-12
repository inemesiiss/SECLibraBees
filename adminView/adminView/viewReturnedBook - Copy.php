<div >
  <h2>Reserve Books</h2>
  <table class="table " id="myTables">
    <thead>
      <tr>
      <th class="text-center">S.N.</th>
        <th class="text-center">Book Image</th>
        <th class="text-center">Book Title</th>
        <th class="text-center">Book Author</th>
        <th class="text-center">Reserve Time</th>
        <th class="text-center">Student Number</th>
        <th class="text-center">Student Name</th>
        <th class="text-center">Action</th>

       
      </tr>
    </thead>
    <?php
      include_once "../config/dbconnect.php";
      $sql="SELECT *
      FROM reserve_book
      INNER JOIN books ON reserve_book.book_id = books.book_id
      INNER JOIN users ON reserve_book.stud_number = users.stud_number
      ORDER BY reserve_time ASC; -- or ORDER BY reserve_time DESC for descending order";
      $result=$conns-> query($sql);
      $count=1;
      if ($result-> num_rows > 0){
        while ($row=$result-> fetch_assoc()) {
           
    ?>
    <tr>
      <td><?=$count?></td>
      <td><img height='100px' src='<?=$row["book_image"]?>'></td>
      <td><?=$row["book_title"]?></td>
      <td><?=$row["book_author"]?></td> 
      <td><?=$row["reserve_time"]?></td>
      <td><?=$row["stud_number"]?></td>
      <td><?=$row["stud_first_name"]?> <?=$row["stud_last_name"]?></td>
      <td><button class="btn btn-danger" style="height:40px" onclick="cancelBorrow(<?=$row['reserve_id']?>)">Cancel</button></td>
      
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