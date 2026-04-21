<?php
require_once("auth.php");
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
include("db.php"); 


$LoginCheck = $conn->prepare("SELECT * FROM `UserInformation` WHERE `Token` = '".$Token."' ");
$LoginCheck->execute();
$LoginCheckCount = $LoginCheck->rowCount();

if($LoginCheckCount == 1){
    $Access ="login";
   }else{
    $Access ="logout";

   }

echo "data: $Access\n\n";
flush();