<?php
require_once '../includes/Auth.php'; // Session Starting file
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
include '../config/Database.php'; // Database connection file;

$LoginCheck = $conn->prepare("SELECT * FROM `controller_information` WHERE `Token` = '".$Token."' ");
$LoginCheck->execute();
$LoginCheckCount = $LoginCheck->rowCount();

if($LoginCheckCount == 1){
    $Access ="login";
   }else{
    $Access ="logout";

   }

echo "data: $Access\n\n";
flush();