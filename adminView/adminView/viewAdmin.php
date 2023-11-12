<?php 
session_start();
if($_SESSION['user']['isAdmin'] == 0){
  debug_backtrace() || die ("<h2>Access Denied!</h2><br></br> Please contact the admin librarian"); 
}

?>
<div>
  <div style="transform: scale(0.7);  transform-origin: top left;">
  <h2>All Admins</h2>
  <table id="myAdminTable" class="table" >
    <thead>
      <tr>
        <th class="text-center">#</th>
        <th class="text-center">Position</th>
        <th class="text-center">Full Name</th>
        <th class="text-center">Username</th>
        <th class="text-center">Book Access</th>
        <th class="text-center">Chat Access</th>
        <th class="text-center">Student Access</th>
        <th class="text-center">Notif Access</th>
        <th class="text-center">Review Access</th>
        <th class="text-center">Edit</th>
        <th class="text-center">Delete</th>
      </tr>
    </thead>
    <?php
      include_once "../config/dbconnect.php";
      $sql="SELECT * from admin_Lib where isMainAdmin=0";
      $result=$conns-> query($sql);
      $count=1;
      if ($result-> num_rows > 0){
        while ($row=$result-> fetch_assoc()) {
           
    ?>
    <tr>
      <td><?=$count?></td>
      <td><?=$row["admin_pos"]?></td>
      <td><?=$row["admin_fname"]?> <?=$row["admin_sname"]?></td>
      <td><?=$row["admin_user"]?></td>
      <td><?php if($row["isBookAccess"] == 0){ echo"<span style='color: red;'>No<span>";}else{echo"<span style='color: green;'>Yes<span>";} ?></td>
      <td><?php if($row["isChatAccess"]  == 0){ echo"<span style='color: red;'>No<span>";}else{echo"<span style='color: green;'>Yes<span>";} ?></td>
      <td><?php if($row["isStudentAccess"]  == 0){ echo"<span style='color: red;'>No<span>";}else{echo"<span style='color: green;'>Yes<span>";} ?></td>
      <td><?php if($row["isNotifAccess"]  == 0){ echo"<span style='color: red;'>No<span>";}else{echo"<span style='color: green;'>Yes<span>";} ?></td>
      <td><?php if($row["isReviewsCommsAccess"]  == 0){ echo"<span style='color: red;'>No<span>";}else{echo"<span style='color: green;'>Yes<span>";} ?></td>
      <td><button class="btn btn-primary" style="height:40px" onclick="editAdminForm('<?=$row['admin_id']?>')">Edit</button></td>
      <td><button class="btn btn-danger" style="height:40px" onclick="adminInfoDelete('<?=$row['admin_id']?>')">Delete</button></td>
    </tr>
    <?php
            $count=$count+1;
           
        }
    }
    ?>
  </table>

<!-- Trigger the modal with a button -->
<button type="button" class="btn btn-success" style="height:40px" data-toggle="modal" data-target="#myModal">
    Add New Admin
  </button>
  </div>
 <!-- Modal -->
 <div class="modal fade" id="myModal" role="dialog" >
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content" style="transform: scale(0.7);">
        <div class="modal-header">
          <h4 class="modal-title">New Admin</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <section class="form admin">
          <form  action="" method="POST">
            <div class="form-group">
              <label for="pos">Admin Position:</label>
              <input type="text" class="form-control" name="adpos" required>
            </div>
            <div class="form-group">
              <label for="fname">Firstname:</label>
              <input type="text" class="form-control" name="adfname" required>
            </div>
            <div class="form-group">
              <label for="sname">Surname:</label>
              <input type="text" class="form-control" name="adsname" required>
            </div>
            <div class="form-group">
              <label for="aduid">Username:(Email)</label>
              <input type="text" class="form-control" name="aduserid" required>
            </div>
            <div class="form-group">
              <label for="adpss">Password:</label>
              <input type="password" class="form-control" name="adpass" id="adpass" required>
            </div>
            <div class="form-group">
              <label for="adcpss">Confirm Password:</label>
              <input type="password" class="form-control" name="adcpass" id="adcpass"required>
              <input type="checkbox" onclick="seePasscode()">Show Password 
            </div>
            

            <div id="message">
              <h3>Password must contain the following:</h3>
              <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
              <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
              <p id="number" class="invalid">A <b>number</b></p>
              <p id="match" class="invalid">Des not match <b></b></p>
              <p id="length" class="invalid">Minimum <b>8 characters</b></p>
            </div>

            <div class="form-group">
            <label >Book Management Access:</label>
            <select class="form-control" name="bookManagementAccess" id="bookManagementAccess" required>
            <option value=0>Please Select</option>
              <option value=1>Yes</option>
              <option value=0>No</option>
            </select>
            </div>
            

            <div class="form-group">
            <label >Student Management Access:</label>
            <select class="form-control" name="studManagementAccess" id="studManagementAccess" required>
            <option value=0>Please Select</option>
              <option value=1>Yes</option>
              <option value=0>No</option>
            </select>
            </div>

            <div class="form-group">
            <label >Chat Management Access:</label>
            <select class="form-control" name="chatManagementAccess" id="chatManagementAccess" required>
            <option value=0>Please Select</option>
              <option value=1>Yes</option>
              <option value=0>No</option>
            </select>
            </div>

            <div class="form-group">
            <label >Notification Management Access:</label>
            <select class="form-control" name="notifManagementAccess" id="notifManagementAccess" required>
            <option value=0>Please Select</option>
              <option value=1>Yes</option>
              <option value=0>No</option>
            </select>
            </div>

            <div class="form-group">
            <label >Reviews and Community Management Access:</label>
            <select class="form-control" name="revCommssMngtAccess" id="revCommssMngtAccess" required>
            <option value=0>Please Select</option>
              <option value=1>Yes</option>
              <option value=0>No</option>
            </select>
            </div>

           
          
            <div class="Btn admin1">
            <input type="submit" value="Submit"class="form-group"> 
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


<style>
  #message {
  display:none;
  background: #f1f1f1;
  color: #000;
  position: relative;
  padding: 20px;
  margin-top: 10px;
}

#message p {
  padding: 10px 35px;
  font-size: 18px;
}

/* Add a green text color and a checkmark when the requirements are right */
.valid {
  color: green;
}

.valid:before {
  position: relative;
  left: -35px;
  content: "&#10004";
}

/* Add a red text color and an "x" icon when the requirements are wrong */
.invalid {
  color: red;
}

.invalid:before {
  position: relative;
  left: -35px;
  content: "&#10006";
}
</style>



<script>




function seePasscode() {
  var x = document.getElementById("adcpass");
  var y = document.getElementById("adpass");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
  if (y.type === "password") {
    y.type = "text";
  } else {
    y.type = "password";
  }
} 


  









document.querySelector(".admin form").addEventListener("submit", function(event) {
    event.preventDefault();
   let xhr =  new XMLHttpRequest();
   xhr.open("POST", "./controller/addNewAdminController.php", true);
   xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
         if(xhr.status === 200){
            let adminData = xhr.responseText;
            
            if(adminData.includes("success")){
              console.log(adminData);
               alert("Admin Added Successfully!");
               event.target.reset(); // reset the form inputs
               
            }else{
              
              alert(adminData.toString());
            }
         }
      }
   };
   let formData = new FormData(event.target);
    xhr.send(formData);
});
</script>
<script>
  $(document).ready(function(){
    $('#myAdminTable').DataTable({
      
    });
  });
</script>
  


 