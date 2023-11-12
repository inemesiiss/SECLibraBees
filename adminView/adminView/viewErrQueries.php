<?php 
session_start();

if($_SESSION['user']['notifaccess'] == 0){
  debug_backtrace() || die ("<h2>Access Denied!</h2><br></br> Please contact the admin librarian"); 
}

?>
<div >
  <h2>Error Queries</h2>
  <table class="table " id="myErr">
  <thead>
      <tr>
        <th class="text-center">S.N.</th>
        <th class="text-center">Error Title</th>
        <th class="text-center">Error Img</th>
        <th class="text-center">Error Description</th>
        <th class="text-center">Error Sender</th>
        <th class="text-center">Error Time</th>
        <th class="text-center">Action/th>
       
      </tr>
    </thead>
    <?php
      include_once "../config/dbconnect.php";
      $sql="SELECT errQueries.*,users.stud_first_name, users.stud_last_name
      from errQueries
      LEFT JOIN users ON CAST(errQueries.err_sender AS UNSIGNED) = CAST(users.stud_number AS UNSIGNED)";
      $result=$conns-> query($sql);
      $count=1;
      if ($result-> num_rows > 0){
        while ($row=$result-> fetch_assoc()) {
           
    ?>
    <tr>
      <td><?=$count?></td>
      <td><?=$row["err_title"]?></td>
      <?php
      if ($row["err_Img"] == null) {
        echo "<td>" . $row["err_title"] . "</td>";
      } else {
        echo "<td><img height='300px' width='300px' src='../userViewLibraBees/images/" . $row['err_Img'] . "'></td>";
      }
      ?>
      <td><?=$row["err_desc"]?></td>
      <td><?=$row["stud_first_name"]?> <?=$row["stud_last_name"]?></td>
      <td><?=$row["err_report_created"]?></td>
      <td><button type="button" class="btn btn-success" style="height:40px" onclick="resolveErr('<?=$row['err_id']?>')">Resolve</button></td>
      
      
    </tr>
    <?php
            $count=$count+1;
           
        }
    }
    ?>

<script>
    $(document).ready(function(){
        $('#myErr').DataTable();
        
        
    });
</script>
  </table>
   