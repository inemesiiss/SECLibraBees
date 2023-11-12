
<div class="container p-5">

<h4>Change Book Status</h4>



<?php
    include_once "../config/dbconnect.php";
	$ID=$_POST['record'];
	$qry=mysqli_query($conns, "SELECT * FROM barrow_book WHERE barrow_id='$ID'");
	$numberOfRow=mysqli_num_rows($qry);
	if($numberOfRow>0){
		while($row1=mysqli_fetch_array($qry)){
      
?>
<form method="POST"  action="./controller/updateBookStatController.php">
	<div class="form-group">
      <input type="number" class="form-control" name="barrow_id" value="<?=$row1['barrow_id']?>" hidden>
    </div>
    <div class="form-group">
      <label>Section:</label>
      <select name="book_status">
      <option>Select Status</option>
        
        <option value=2>BARROWED</option>
        <option value=3>RETURNED</option>
      </select>
    </div>
    
    <div class="form-group">
      <input type="submit" name="Update" value="Update" style="height:40px" class="btn btn-primary">Update Information</input>
    </div>
    <?php
    		}
    	}
    ?>
  </form>

    </div>