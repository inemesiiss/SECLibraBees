
<?php 
session_start();
if($_SESSION['user']['notifaccess'] == 0){
  debug_backtrace() || die ("<h2>Access Denied!</h2><br></br> Please contact the admin librarian"); 
}

?>

<div >
  <h2>Manage Notifications</h2>
  <table class="table " id="myTables">
    <thead>
      <tr>
        <th class="text-center">#</th>
        <th class="text-center">Title</th>
        <th class="text-center">Message</th>
        <th class="text-center">Send To</th>
        <th class="text-center">Start</th>
        <th class="text-center">End</th>
        <th class="text-center">Delete</th>


       
      </tr>
    </thead>
    
    <?php
   $education_levels = array(
    'Elementary',
    'High-School',
    'Senior High',
    'College',
    'All'
);

include_once "../config/dbconnect.php";

// Prepare the SQL statement
$sql = "SELECT * FROM notifications WHERE send_to IN (";
$sql .= implode(',', array_fill(0, count($education_levels), '?'));
$sql .= ")";
$stmt = $conns->prepare($sql);

// Bind the values to the placeholders
$stmt->bind_param(str_repeat('s', count($education_levels)), ...$education_levels);

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

$count = 1;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Do something with each row
    

           
    ?>
    <tr>
      <td><?=$count?></td>
      <td><?=$row["notif_title"]?></td>
      <td><?=$row["notif_msg"]?></td>
      <td><?=$row["send_to"]?></td>
      <td><?=$row["notif_time"]?></td>
      <td><?=$row["notif_end"]?></td>
      <td><button class="btn btn-danger" style="height:40px" onclick="notifDelete('<?=$row['notif_id']?>')">Delete</button></td>
      
      
     
      
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
   <!-- Trigger the modal with a button -->
<button type="button" class="btn btn-success " style="height:40px" data-toggle="modal" data-target="#myModal">
    Send Notification
  </button>

 <!-- Modal -->
 <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Notification</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <section class="form addNewNotif">
          <form  enctype='multipart/form-data' action="" method="POST">
            <div class="wrapper">
              <label for="title">Notification Title:</label>
              <input type="text" class="form-control" name="notif_title" required>
            </div>
            <div class="form-group">
            <br>
            <label for="title">Notification Content:</label>
              <br>

              <textarea style="width: 100%;" name="notif_content" required ></textarea>
              
            </div>
            <div class="form-group">
              <label for="title">Start Date:</label>
              <input type="date" class="form-control" name="notif_Schedule" required min="<?= date('Y-m-d', time() + 86400) ?>">
            </div>
            <div class="form-group">
              <label for="title">End Date:</label>
              <input type="date" class="form-control" name="notif_end_date" required min="<?= date('Y-m-d', time() + 86400) ?>">
            </div>
            <label for="title"> Send to:</label>
            <select name = "notif_receiver">
               <option value="All">All</option>
               <option value="Elementary">Elementary</option>
               <option value="High-School">High-School</option>
               <option value="Senior High">Senior High</option>
               <option value="College">College</option>
            </select>
            <br></br>
            
            <div class="form-group">
              <button type="submit" class="btn btn-success" name="upload" style="height:40px">Confirm</button>
            </div>
          </form>
      </section>

         
	
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="height:40px">Close</button>
        </div>

        
      </div>
      
    </div>
  </div>
  </div>
  <script>
    

    document.querySelector(".addNewNotif form").addEventListener("submit", function(event) {
    event.preventDefault();
   let xhr =  new XMLHttpRequest();
   xhr.open("POST", "./controller/addNewNotif.php", true);
   xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
         if(xhr.status === 200){
            let notifData = xhr.responseText;
            
            if(notifData.includes("success")){
              console.log(notifData);
               alert("Notification Added Successfully!");
               event.target.reset(); // reset the form inputs
               
            }else{
              
              alert(notifData.toString());
            }
         }
      }
   };
   let formData = new FormData(event.target);
    xhr.send(formData);
});


    
  </script>