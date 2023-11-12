<?php
  include_once "../config/dbconnect.php";
  $sql="SELECT * from barrow_book WHERE book_status<=2";
  $result=$conns->query($sql);
  $data = array();
  if ($result-> num_rows > 0){
    while ($row=$result-> fetch_assoc()) {
      $data[] = $row;
    }
  }
  echo json_encode($data);
  $conns->close();
?>
