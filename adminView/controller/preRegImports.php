<?php 
require "../config/dbconnect.php"; 

if(isset($_POST["import"])){
	$fileName = $_FILES["excel"]["name"];
	$fileExtension = explode('.', $fileName);
	$fileExtension = strtolower(end($fileExtension));
	$newFileName = date("Y.m.d") . " - " . date("h.i.sa") . "." . $fileExtension;

	$targetDirectory = "uploadFilesStudNum/" . $newFileName;
	move_uploaded_file($_FILES['excel']['tmp_name'], $targetDirectory);

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	require_once '../excelReader/excel_reader2.php';
	require_once '../excelReader/SpreadsheetReader.php';

	$reader = new SpreadsheetReader($targetDirectory);
	foreach($reader as $key => $row){
		$preRegNum = trim($row[0]);

		if(!empty($preRegNum)){
			$insert = mysqli_query($conns, "INSERT IGNORE INTO users (pre_reg_number) VALUES ('$preRegNum')");
		}
	}
	if($insert){
		header("Location: ../index.php");
		echo "<script>alert('Import successful.')</script>";
	}
	else{
		echo "Error inserting record. SQL Error: " . mysqli_error($conns);
	}
}
?>
