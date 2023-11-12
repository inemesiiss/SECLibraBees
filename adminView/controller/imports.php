
<?php require  "../config/dbconnect.php"; ?>
 
<?php
  
		if(isset($_POST["import"])){
			$fileName = $_FILES["excel"]["name"];
			$fileExtension = explode('.', $fileName);
      $fileExtension = strtolower(end($fileExtension));
			$newFileName = date("Y.m.d") . " - " . date("h.i.sa") . "." . $fileExtension;

			$targetDirectory = "uploadFiles/" . $newFileName;
			move_uploaded_file($_FILES['excel']['tmp_name'], $targetDirectory);

			error_reporting(0);
			ini_set('display_errors', 0);

			require '../excelReader/excel_reader2.php';
			require '../excelReader/SpreadsheetReader.php';

			$reader = new SpreadsheetReader($targetDirectory);
			foreach($reader as $key => $row){
				$book_title = $row[0];
				$book_code = $row[1];
				$book_author = $row[2];
				$book_image = $row[3];
				$book_status = $row[4];
				$days_can_barrowed = $row[5];
				$category_id = $row[6];
				$bookcategory_id = $row[7];
				$booksubject_id = $row[8];
				$bookdescription = $row[9];
				$bookcopies = $row[10];
				$pubdate = $row[11];
				$insert = mysqli_query($conns,"INSERT INTO books
				(book_title,book_code,book_author,book_desc,book_status,days_can_barrowed,category_id,bookcategory_id,booksubject_id,book_image,book_copies,publication_date) 
				VALUES ('$book_title','$book_code','$book_author','$bookdescription',$book_status,$days_can_barrowed,'$category_id','$bookcategory_id','$booksubject_id','$book_image','$bookcopies','$pubdate')");
			}
      if($insert){
		header("Location: ../index.php");

        echo
			"
			<script>
			alert('Succesfully Change');
			
			</script>
			";

      }
      else{
        echo mysqli_error($conns);
      }

			
		} 
		
		?>
	</body>
</html>