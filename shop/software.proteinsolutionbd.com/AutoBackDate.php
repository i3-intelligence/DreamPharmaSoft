<?php
// require_once("auth.php");
include("db.php");
date_default_timezone_set('Asia/Dhaka');
$Today = date("Y-m-d");

$BackDate = $conn->prepare("UPDATE `CustomDate` SET `Date` = '$Today' ");
$BackDate->execute();
if($BackDate){
    print "200";
}else{
    print "500";
}
?>