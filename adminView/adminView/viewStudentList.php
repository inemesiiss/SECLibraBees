<?php 
session_start();
if($_SESSION['user']['studaccess'] == 0){
  debug_backtrace() || die ("<h2>Access Denied!</h2><br></br> Please contact the admin librarian"); 
}

?>
<div style="transform: scale(0.7);  transform-origin: top left;">
  <h2>All Students</h2>
  <table class="table" id="myTables">
  <thead>
    <tr>
      <th class="text-center">#</th>
      <th class="text-center">Pre Reg. #</th>
      <th class="text-center">Student ID#</th>
      <th class="text-center">Picture</th>
      <th class="text-center">Name</th>
      <th class="text-center">Email</th>
      <th class="text-center">Address</th>
      <th class="text-center">Level</th>
      <th class="text-center">Course</th>
      <th class="text-center">Contact Number</th>
      <th class="text-center">Currently Borrow</th>
      <th class="text-center">Password Reset</th>
      <th class="text-center">Remove</th>
    </tr>
  </thead>
  <tbody>
    <?php
    include_once "../config/dbconnect.php";
    $sql = "SELECT * FROM users WHERE email_verified_at IS NOT NULL";
    $result = $conns->query($sql);
    $count = 1;
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $stud_number = $row["stud_number"];
        $borrowed_books = [];

        $selBarBooks = "SELECT * FROM barrow_book WHERE stud_number = '$stud_number' AND book_status = 2";
        $result2 = $conns->query($selBarBooks);
        if ($result2->num_rows > 0) {
          while ($row2 = $result2->fetch_assoc()) {
            $borrowed_books[] = $row2["book_title"];
          }
        }

        $verification_status = ($row["email_verified_at"] == null) ? "Non Verified" : "Verified";
    ?>
        <tr>
          <td><?= $count ?></td>
          <td><?= $row["pre_reg_number"] ?></td>
          <td><?= $row["stud_number"] ?></td>
          <td><img height='100px' src='../userViewLibraBees/userpic/<?=$row["stud_avatar"]?>'></td>
          <td><?= $row["stud_last_name"] ?> <?= $row["stud_first_name"] ?></td>
          <td><?= $row["stud_email"] ?></td>
          <td><?= $row["stud_address"] ?></td>
          <td><?= $row["stud_yrlvl"] ?></td>
          <td><?= $row["stud_course"] ?></td>
          <td><?= $row["stud_contact_no"] ?></td>
          <td width="500"><?= (!empty($borrowed_books)) ? implode("<hr>", $borrowed_books) : "No books." ?></td>
          
          <td>
            <?php if ($row['email_verified_at'] != null) : ?>
              <button class="btn btn-danger" style="height:40px" onclick="resetPassConfirmation('<?= $row['stud_number'] ?>')">Reset</button>
            <?php else : ?>
              N/A
            <?php endif; ?>
          </td>
          <td>
            <?php if ($row['email_verified_at'] != null) : ?>
              <button class="btn btn-danger" style="height:40px" onclick="confirmDelStud('<?= $row['stud_number'] ?>')">Remove</button>
            <?php else : ?>
              N/A
            <?php endif; ?>
          </td>
        </tr>
    <?php
        $count++;
      }
    }
    ?>
  </tbody>
</table>
   <!-- Trigger the modal with a button -->
<button type="button" class="btn btn-success" style="height:40px" data-toggle="modal" data-target="#myModal">
    Pre-Regiser Student ID Number
  </button>
  </div>
 <!-- Modal -->
 <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content" style="transform: scale(0.7);">
        <div class="modal-header">
          <h4 class="modal-title">Pre-Registration</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
      <section class="form prereg">
          <form  action="" method="POST">
            <div class="form-group">
              <label for="title">Student Number:</label>
              <input type="text" class="form-control" name="preRegNum" required>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-success" name="upload" style="height:40px">Confirm</button>
            </div>
          </form>
    </section>

          <div class="modal-body">
            <form action="./controller/preRegImports.php" method="post" enctype="multipart/form-data">
			<input type="file" name="excel" required value="">
			<button type="submit" class="btn btn-success" value="import"name="import">Import</button>
      </form>
      </div>
		

        
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="height:40px">Close</button>
        </div>

        
      </div>
      
    </div>
  </div>
  </div>

<script>
  document.querySelector(".prereg form").addEventListener("submit", function(event) {
    event.preventDefault();
   let xhr =  new XMLHttpRequest();
   xhr.open("POST", "./controller/addPreRegNumController.php", true);
   xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
         if(xhr.status === 200){
            let preRegData = xhr.responseText;
            
            if(preRegData.includes("success")){
              console.log(preRegData);
               alert("Student Number Added Successfully!");
               event.target.reset(); // reset the form inputs
               
            }else{
              
              alert(preRegData.toString());
            }
         }
      }
   };
   let formData = new FormData(event.target);
    xhr.send(formData);
});


    $(document).ready(function(){
        $('#myTables').DataTable();
        
        
    });

</script>