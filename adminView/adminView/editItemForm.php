
<div class="container p-5">

<?php
    include_once "../config/dbconnect.php";
	$ID=$_POST['record'];
	$qry=mysqli_query($conns, "SELECT * FROM books WHERE book_id='$ID'");
	$numberOfRow=mysqli_num_rows($qry);
	if($numberOfRow>0){
		while($row1=mysqli_fetch_array($qry)){
      $catID=$row1["category_id"];
      $bcatID=$row1["bookcategory_id"];
      $scatID=$row1["booksubject_id"];
      
?>
<section class="form bookEdit" style="transform: scale(0.7);  transform-origin: top left; position:">
<form action="#" enctype='multipart/form-data'>
<h4>Edit Book Detail</h4>
	<div class="form-group">
      <input type="text" class="form-control" name="book_id" value="<?=$row1['book_id']?>" hidden>
    </div>
    <div class="form-group">
      <label for="title">Book Title:</label>
      <input type="text" class="form-control" name="b_title" value="<?=$row1['book_title']?>">
    </div>
    <div class="form-group">
      <label for="desc">Book Code:</label>
      <input type="text" class="form-control" name="b_code" value="<?=$row1['book_code']?>">
    </div>
    <div class="form-group">
      <label for="bauthor">Book Author:</label>
      <input type="text" class="form-control" name="b_author" value="<?=$row1['book_author']?>">
    </div>
    <div class="form-group" >
      <label for="bdesc">Book Description:</label>
      <textarea  class="form-control" name="b_desc" ><?=$row1['book_desc']?></textarea>
    </div>
    <div class="form-group">
      <label for="bstat">Book Status:</label>
      <select class="form-control" name="b_stat" >
            <option value=<?=$row1['book_status']?>>Please Select</option>
              <option value=1>Available</option>
              <option value=0>Not Available</option>
            </select>
            </div>
    <div class="form-group">
      <label for="bauthor">Book Copies:</label>
      <input type="number" class="form-control" name="b_copies" value="<?=$row1['book_copies']?>">
    </div>
    <div class="form-group">
      <label for="bauthor">Year Publish:</label>
      <input type="number" class="form-control" name="yr_pub" value="<?=$row1['publication_date']?>">
    </div>
    
    <div class="form-group">
      <label for="days">Borrow Duration:(days)</label>
      <input type="number" class="form-control" name="daysbarrowed" value="<?=$row1['days_can_barrowed']?>">
    </div>
      <!-- book section -->
    <div class="form-group">
      <label>Section:</label>
      <select name="category">
        <?php
          $sql="SELECT * from category WHERE category_name='$catID'";
          $result = $conns-> query($sql);
          if ($result-> num_rows > 0){
            while($row = $result-> fetch_assoc()){
              echo"<option value='". $row['category_name'] ."'>" .$row['category_name'] ."</option>";
            }
          }
        ?>
        <?php
          $sql="SELECT * from category WHERE category_name!='$catID'";
          $result = $conns-> query($sql);
          if ($result-> num_rows > 0){
            while($row = $result-> fetch_assoc()){
              echo"<option value='". $row['category_name'] ."'>" .$row['category_name'] ."</option>";
            }
          }
        ?>
      </select>
    </div>
          <!-- book category -->

    <div class="form-group">
      <label>Category:</label>
      <select name="b_category">
        <?php
          $sql="SELECT * from bookcategory WHERE bookcategory_name='$bcatID'";
          $result = $conns-> query($sql);
          if ($result-> num_rows > 0){
            while($row = $result-> fetch_assoc()){
              echo"<option value='". $row['bookcategory_name'] ."'>" .$row['bookcategory_name'] ."</option>";
            }
          }
        ?>
        <?php
          $sql="SELECT * from bookcategory WHERE bookcategory_name!='$bcatID'";
          $result = $conns-> query($sql);
          if ($result-> num_rows > 0){
            while($row = $result-> fetch_assoc()){
              echo"<option value='". $row['bookcategory_name'] ."'>" .$row['bookcategory_name'] ."</option>";
            }
          }
        ?>
      </select>
    </div>

     <!-- book subject -->
     <div class="form-group">
      <label>Subject:</label>
      <select name="b_subject">
        <?php
          $sql="SELECT * from subject WHERE subject_name='$scatID'";
          $result = $conns-> query($sql);
          if ($result-> num_rows > 0){
            while($row = $result-> fetch_assoc()){
              echo"<option value='". $row['subject_name'] ."'>" .$row['subject_name'] ."</option>";
            }
          }
        ?>
        <?php
          $sql="SELECT * from subject WHERE subject_name!='$scatID'";
          $result = $conns-> query($sql);
          if ($result-> num_rows > 0){
            while($row = $result-> fetch_assoc()){
              echo"<option value='". $row['subject_name'] ."'>" .$row['subject_name'] ."</option>";
            }
          }
        ?>
      </select>
    </div>

      <div class="form-group">
         <img width='200px' height='150px' src='<?=$row1["book_image"]?>'>
         <div>
            <label for="file">Choose Image:</label>
            <input type="text" name="existingImage" class="form-control" value="<?=$row1['book_image']?>" hidden>
            <input type="file" name="newImage" class="form-control">
         </div>
    </div>
    <div class="form-group">
    <input type="submit" value="Submit"class="form-group"> 
    </div>
    <?php
    		}
    	}
    ?>
  </form>
    </section>
    </div>

    <script>
   document.querySelector(".bookEdit form").addEventListener("submit", function(event) {
    event.preventDefault();
    
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./controller/updateItemController.php", true);
    xhr.onload = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let dataBook = xhr.responseText;
                if (dataBook.includes("success")) {
                    alert("Book Information Saved!");
                    showBookManagement();
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