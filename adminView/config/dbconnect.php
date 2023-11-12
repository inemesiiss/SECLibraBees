<?php

$server = "127.0.0.1:4306";
$user = "root";
$password = "";
$db = "librabees_DB";

$conns = mysqli_connect($server,$user,$password,$db);

if(!$conns) {
    die("Connection Failed:".mysqli_connect_error());
}

?>

