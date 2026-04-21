<?php
include("auth.php");
include("db.php");
include_once("clean.php");


// Brand UpDate
if(!empty($_POST['submit'])  && $_POST['submit']=='Back Date'){

//GET END DATE
      $datestring_end_date =$_POST['end_date'];
      list($day2, $month2, $year2) = explode('/', $datestring_end_date);
      $get_end_date = DateTime::createFromFormat('Ymd', $year2 . $month2 . $day2); 

$Date =  $get_end_date->format('Y-m-d');
$UserId = $_POST['User'];

$query_CustomDate = $conn->prepare("UPDATE `CustomDate` SET 
`Date` = '".$Date."'
WHERE `UserId` = '$UserId' ");
$query_CustomDate->execute();

header("Location: BackDateView.php?msg=1");

exit();
}else{
  header("Location: BackDateView.php?msg=0");
exit();

}
?>