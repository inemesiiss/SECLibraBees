<?php 
require  "../config/dbconnect.php";
require '../PhpSpreadsheet/src/Bootstrap.php';
require '../PhpSpreadsheet/src/PhpSpreadsheet/Spreadsheet.php';
require '../PhpSpreadsheet/src/PhpSpreadsheet/IOFactory.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

// Create new PHPExcel object
$objPHPExcel = new Spreadsheet();

// Query the database for the book data
$query = "SELECT * FROM books";
$result = mysqli_query($conns, $query);

// Set the worksheet headers
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'book_id');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'book_title');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'book_code');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'book_author');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'book_desc');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'book_image');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'book_status');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'days_can_borrowed');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'category_id');
$objPHPExcel->getActiveSheet()->setCellValue('J1', 'bookcategory_id');
$objPHPExcel->getActiveSheet()->setCellValue('K1', 'booksubject_id');
$objPHPExcel->getActiveSheet()->setCellValue('L1', 'book_copies');
$objPHPExcel->getActiveSheet()->setCellValue('M1', 'publication_date');

// Set the row counter to 2 (since the headers are already in the first row)
$rowCount = 2;

// Loop through the database results and add them to the worksheet
while ($row = mysqli_fetch_assoc($result)) {
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount, $row['book_id']);
    $objPHPExcel->getActiveSheet()->setCellValue('B'.$rowCount, $row['book_title']);
    $objPHPExcel->getActiveSheet()->setCellValue('C'.$rowCount, $row['book_code']);
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$rowCount, $row['book_author']);
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$rowCount, $row['book_desc']);
    $objPHPExcel->getActiveSheet()->setCellValue('F'.$rowCount, $row['book_image']);
    $objPHPExcel->getActiveSheet()->setCellValue('G'.$rowCount, $row['book_status']);
    $objPHPExcel->getActiveSheet()->setCellValue('H'.$rowCount, $row['days_can_borrowed']);
    $objPHPExcel->getActiveSheet()->setCellValue('I'.$rowCount, $row['category_id']);
    $objPHPExcel->getActiveSheet()->setCellValue('J'.$rowCount, $row['bookcategory_id']);
    $objPHPExcel->getActiveSheet()->setCellValue('K'.$rowCount, $row['booksubject_id']);
    $objPHPExcel->getActiveSheet()->setCellValue('L'.$rowCount, $row['book_copies']);
    $objPHPExcel->getActiveSheet()->setCellValue('M'.$rowCount, $row['publication_date']);
    $rowCount++;
}

// Save the Excel file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="books.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>
