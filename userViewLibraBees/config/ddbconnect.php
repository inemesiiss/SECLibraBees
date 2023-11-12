<?php

$server = "127.0.0.1:4306";
$user = "root";
$password = "";
$db = "librabees_DB";
try {

    $conn = new PDO("mysql:host={$server};dbname={$db}", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    echo $e->getMessage();

}




?>

