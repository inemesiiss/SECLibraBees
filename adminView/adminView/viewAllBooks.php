<?php
session_start();
include_once "../config/dbconnect.php";

if($_SESSION['user']['bookaccess'] == 0){
  debug_backtrace() || die ("<h2>Access Denied!</h2><br></br> Please contact the admin librarian"); 
}

?>

<div class="book-Manage" style="transform: scale(0.7); transform-origin: top left;">

  <h2>Books</h2>
  <table id="myTableBook" class="table"  >
    <thead>
      <tr>
        <th class="text-center">#</th>
        <th class="text-center"> Image</th>
        <th class="text-center"> Code</th>
        <th class="text-center"> Title</th>
        <th class="text-center"> Author </th>
        <th class="text-center"> Status</th>
        <th class="text-center"> Borrow Duration</th>
        <th class="text-center"> Copies</th>
        <th class="text-center"> Section</th>
        <th class="text-center"> Category</th>
        <th class="text-center"> Subject</th>
        <th class="text-center"> Pub. Date</th>
        <th class="text-center">Edit</th>
        <th class="text-center">Delete</th>
      </tr>
    </thead>
    <?php
      $sql="SELECT * from books";
      
      $result=$conns-> query($sql);
      $count=1;
      if ($result-> num_rows > 0){
        while ($row=$result-> fetch_assoc()) {
    ?>
    <tr>
      <td><?=$count?></td>
      <td><img height='100px' src='<?=$row["book_image"]?>'></td>
      <td><?=$row["book_code"]?></td>
      <td><?=$row["book_title"]?></td>      
      <td><?=$row["book_author"]?></td> 
      <?php
      if($row["book_status"] == 0){
        echo "<td>Not Available</td>";  
      }
      elseif($row["book_status"] == 1){
        echo "<td>Available</td>";  
      }
      ?> 
      <td><?=$row["days_can_barrowed"]?> Days</td>
      <td><?=$row["book_copies"]?> pcs</td> 
      <td><?=$row["category_id"]?></td>  
      <td><?=$row["bookcategory_id"]?></td>
      <td><?=$row["booksubject_id"]?></td>
      <td><?=$row["publication_date"]?></td>
      <td><button type="button" class="btn btn-success" style="height:40px" onclick="itemEditForm('<?=$row['book_id']?>')">Edit</button></td>
      <td><button type="button"  class="btn btn-danger" style="height:40px" onclick="confirmDeleteBook('<?=$row['book_id']?>')">Delete</button></td>
      </tr>
      <?php
            $count=$count+1;
          }
        }
      ?>
  </table>
 
 <!-- Trigger the modal with a button -->
 <button type="button" class="btn btn-success" style="height:40px" data-toggle="modal" data-target="#myModal">
    Add New Book
  </button>

<script>
  $(document).ready(function(){
    $('#myTableBook').DataTable({
      
    });
  });
</script>




</div>


 

 <!-- Modal -->
 <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">New Book</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
        <section class="form book">
                  <form action="#" enctype='multipart/form-data'>
                  <div class="book-Err"></div>
            <div class="form-group">
              <label for="title">Book Title:</label>
              <input type="text" class="form-control" name="book_title" required>
            </div>
            <div class="form-group">
              <label for="code">Book Code:</label>
              <input type="text" class="form-control" name="book_code" required>
            </div>
            <div class="form-group">
              <label for="author">Book Author:</label>
              <input type="text" class="form-control" name="book_author" required>
            </div>
            <div class="form-group">
              <label for="desc">Book Description:</label>
              <textarea  class="form-control" name="book_desc" required></textarea>

            </div>
            <div class="form-group">
              <label for="status">Book Status:</label>
              <select class="form-control" name="book_status"  required>
            <option value=0>Please Select</option>
              <option value=1>Available</option>
              <option value=0>Not Available</option>
            </select>
            </div>
            <div class="form-group">
              <label for="dcbb">Borrow Duration:</label>
              <input type="number" class="form-control" name="days_can_barrowed" required>
            </div>
            <div class="form-group">
              <label for="yr_pub">Year Publish:</label>
              <input type="text" class="form-control" name="yr_pub" placeholder="-YYYY-"required>
            </div>
            <div class="form-group">
              <label for="b_copies">Book Copies:</label>
              <input type="number" class="form-control" name="b_copies" required>
            </div>

            <div class="form-group">
              <label>Subject:</label>
              <select name="booksubject_select" id="booksubject_select">
                <option disabled selected>Select Book Subject</option>
                <?php

                  $sql="SELECT * from subject";
                  $result = $conns-> query($sql);

                  if ($result-> num_rows > 0){
                    while($row = $result-> fetch_assoc()){
                      echo"<option value='".$row['subject_name']."'>".$row['subject_name'] ."</option>";
                    }
                  }
                ?>
              </select>
        

            </div>

            <div class="form-group">
              <label>Section:</label>
              <select name="booksection_select" id="booksection_select" >
                <option disabled selected>Select Book Section</option>
                <?php

                  $sql="SELECT * from category";
                  $result = $conns-> query($sql);

                  if ($result-> num_rows > 0){
                    while($row = $result-> fetch_assoc()){
                      echo"<option value='".$row['category_name']."'>".$row['category_name'] ."</option>";
                    }
                  }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label>Category:</label>
              <select name="bookcategory_select" id="bookcategory_select" >
                <option disabled selected>Select Book Category</option>
                <?php

                  $sql="SELECT * from bookcategory";
                  $result = $conns-> query($sql);

                  if ($result-> num_rows > 0){
                    while($row = $result-> fetch_assoc()){
                      echo"<option value='".$row['bookcategory_name']."'>".$row['bookcategory_name'] ."</option>";
                    }
                  }
                ?>
              </select>
            <div class="form-group">
                <label for="file">Choose Image:</label>
                <input type="file" id="file"name="file">
                
            </div>

            </div>
          
            <div class="form bookBtn">
            <input type="submit" value="Submit"class="form-group"> 
            </div>
          </form>
          <section>
          <hr />
<br>
<h4 class="modal-title">Excel Import</h4>
          <form action="./controller/imports.php" method="post" enctype="multipart/form-data">
			<input type="file" name="excel" required value="">
			<button type="submit" value="import"name="import">Import</button>
		</form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="height:40px">Close</button>
        </div>
      </div>
      
    </div>
  </div>

<script>
   document.querySelector(".book form").addEventListener("submit", function(event) {
    event.preventDefault();
    
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./controller/addItemController.php", true);
    xhr.onload = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let dataBook = xhr.responseText;
                if (dataBook.includes("success")) {
                    alert("Book Added Successfully!");
                    event.target.reset(); // reset the form inputs
                } else {
                    alert(dataBook);
                }
            }
        }
    };
    let formData = new FormData(event.target);
    xhr.send(formData);
});


</script>
