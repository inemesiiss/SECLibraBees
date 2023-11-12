
<div class="container p-5">


<?php
    include_once "../config/dbconnect.php";
	$ID=$_POST['record'];
	$qry=mysqli_query($conns, "SELECT * FROM admin_Lib WHERE admin_id='$ID'");
	$numberOfRow=mysqli_num_rows($qry);
	if($numberOfRow>0){
		while($row1=mysqli_fetch_array($qry)){
      
?>
<section class="form editAdmin">
<form action="" enctype='multipart/form-data'>
<h4>Edit Admin Access  </h4>
<h5>Name : <?=$row1['admin_fname']?> <?=$row1['admin_sname']?></h5>
	<div class="form-group">
      <input type="number" class="form-control" name="admin_id" value="<?=$row1['admin_id']?>" hidden>
    </div>
    <div class="form-group">
      <label for="admin_p">Position:</label>
      <input type="text" class="form-control" name="pos" value="<?=$row1['admin_pos']?>">
    </div>
    <div class="form-group">
      
      <input type="text" class="form-control" name="ad_fname" value="<?=$row1['admin_fname']?>" hidden>
    </div>
    <div class="form-group">
      
      <input type="text" class="form-control" name="ad_sur" value="<?=$row1['admin_sname']?>" hidden>
    </div>
    <div class="form-group">
      
      <input type="text" class="form-control" name="ad_usern" value="<?=$row1['admin_user']?>" hidden>
    </div>
   
      
      <input type="text" class="form-control" name="ad_pass" value="<?=$row1['admin_password']?>" hidden>
    

    <div class="form-group">
            <label >Book Management Access:</label>
            <select class="form-control"  name="bookManagementAccess" >
            <?php
              if($row1['isBookAccess']==0){
                echo "<option value=0>No</option>";
                echo "<option value=1>Yes</option>";
              }elseif($row1['isBookAccess']==1){
                echo "<option value=1>Yes</option>";
                echo "<option value=0>No</option>";
              }
              ?>
            </select>
            </div>
            

            <div class="form-group">
            <label >Student Management Access:</label>
            <select class="form-control"  name="studManagementAccess" >
            <?php
              if($row1['isStudentAccess']==0){
                echo "<option value=0>No</option>";
                echo "<option value=1>Yes</option>";
              }elseif($row1['isStudentAccess']==1){
                echo "<option value=1>Yes</option>";
                echo "<option value=0>No</option>";
              }
              ?>
            </select>
            </div>

            <div class="form-group">
            <label >Chat Management Access:</label>
            <select class="form-control"  name="chatManagementAccess" >
            <?php
              if($row1['isChatAccess']==0){
                echo "<option value=0>No</option>";
                echo "<option value=1>Yes</option>";
              }elseif($row1['isChatAccess']==1){
                echo "<option value=1>Yes</option>";
                echo "<option value=0>No</option>";
              }
              ?>
              </select>
            </div>

            <div class="form-group">
            <label >Notification Management Access:</label>
            <select class="form-control"  name="notifManagementAccess" >
            <?php
              if($row1['isNotifAccess']==0){
                echo "<option value=0>No</option>";
                echo "<option value=1>Yes</option>";
              }elseif($row1['isNotifAccess']==1){
                echo "<option value=1>Yes</option>";
                echo "<option value=0>No</option>";
              }
              ?>
              </select>
            </div>
            <div class="form-group">
            <label >Reviews and Community Management Access:</label>
            <select class="form-control"  name="revCommssMngtAccess" >
              <?php
              if($row1['isReviewsCommsAccess']==0){
                echo "<option value=0>No</option>";
                echo "<option value=1>Yes</option>";
              }elseif($row1['isReviewsCommsAccess']==1){
                echo "<option value=1>Yes</option>";
                echo "<option value=0>No</option>";
              }
              
              
              ?>
            
              
              
            </select>
            </div>
  
    <div class="form-group">
      <button type="submit" style="height:40px" class="btn btn-success">Update Information</button>
    </div>
    <?php
    		}
    	}
    ?>
  </form>
  </section>

    </div>

<script>
   document.querySelector(".editAdmin form").addEventListener("submit", function(event) {
    event.preventDefault();
    
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./controller/updateAdminInfoController.php", true);
    xhr.onload = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let dataBook = xhr.responseText;
                if (dataBook.includes("success")) {
                    alert("Admin Information Saved!");
                    showAdmin();
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