<?php
require_once 'Auth.php'; // Session Starting file
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
include 'Database.php'; // Database connection file;

$LoginCheck = $conn->prepare("SELECT * FROM `controller_information` WHERE `Token` = '".$Token."' ");
$LoginCheck->execute();
$LoginCheckCount = $LoginCheck->rowCount();

if($LoginCheckCount == 1){
    $Access ="login";
   }else{
    $Access ="logout";
    include 'Session.php';
    session_unset();
    session_destroy();

   }

echo "data: $Access\n\n";
flush();