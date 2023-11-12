<?php 
session_start();
if($_SESSION['user']['bookaccess'] == 0){
  debug_backtrace() || die ("<h2>Access Denied!</h2><br></br> Please contact the admin librarian"); 
}

?>

<div >
  <h3>Book Subject</h3>
  <table class="table " id="subjectTables">
    <thead>
      <tr>
        <th class="text-center">S.N.</th>
        <th class="text-center">Subjects Name</th>
        <th class="text-center">Action</th>
      </tr>
    </thead>
    <?php
      include_once "../config/dbconnect.php";
      $sql="SELECT * from subject";
      $result=$conns-> query($sql);
      $count=1;
      if ($result-> num_rows > 0){
        while ($row=$result-> fetch_assoc()) {
    ?>
    <tr>
      <td><?=$count?></td>
      <td><?=$row["subject_name"]?></td>   
      <!-- <td><button class="btn btn-primary" >Edit</button></td> -->
      <td><button class="btn btn-danger" style="height:40px" onclick="subjectDelete('<?=$row['subject_id']?>')">Delete</button></td>
      </tr>
      <?php
            $count=$count+1;
          }
        }
      ?>
  </table>

  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-success" style="height:40px" data-toggle="modal" data-target="#myModal">
    Add New Subjects
  </button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">New Book Subject</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <section class="form addSubj">
          <form  enctype='multipart/form-data' action="" method="POST">
            <div class="form-group">
              <label for="c_name">Subject Name:</label>
              <input type="text" class="form-control" name="booksubject" required>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-success" name="upload" id="upload" style="height:40px">Add Subject</button>
            </div>
          </form>
          </section>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="height:40px">Close</button>
        </div>
      </div>
      
    </div>
  </div>

  
</div>
<script>
    $(document).ready(function(){
        $('#subjectTables').DataTable();
        
        
    });


    document.querySelector(".addSubj form").addEventListener("submit", function(event) {
    event.preventDefault();
   let xhr =  new XMLHttpRequest();
   xhr.open("POST", "./controller/addBookSubjectsController.php", true);
   xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
         if(xhr.status === 200){
            let subjData = xhr.responseText;
            
            if(subjData.includes("success")){
              console.log(subjData);
               alert("Book Subject Added Successfully!");
               event.target.reset(); // reset the form inputs
               
            }else{
              
              alert(subjData.toString());
            }
         }
      }
   };
   let formData = new FormData(event.target);
    xhr.send(formData);
});
</script>