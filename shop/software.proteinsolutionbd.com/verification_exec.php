<?php
require_once("auth.php");
//Include database connection details
require_once('db.php');
include('clean.php');

	//Array to store validation errors
	$errmsg_arr = array();

	//Validation error flag
	$errflag = false;

	//Function to sanitize values received from the form. Prevents SQL injection

	//Sanitize the POST values
	$otp = clean($_POST['otp']);
	$verify_id = clean($_POST['verify_id']);
 

//Create query
$result = $conn->prepare("SELECT * FROM `UserInformation` WHERE `OTP` = '$otp' AND `Id` = '$verify_id' "); 
$result->execute();
//Check whether the query was successful or not
if($result) {
if($result->rowCount() == 1){
$member = $result->fetch(PDO::FETCH_ASSOC);
//Login Successful
$LastLogin2miniteextra = date("Y-m-d H:i:s", strtotime($member['LastLogin'] . ' +5 minutes'));
if($LastLogin2miniteextra >= $CurrentDateTime){ 
// print "Login Successful";
header("location: home.php");
exit();
}else{
	// print "OTP Expired";
	header("location: logout.php");
exit();

}		


exit();
	}else {
//Login failed
header("location: /login/verification.php?verify_id=$verify_id&notify=invalid");
// print "Login Failed";
exit();

	}
	}else {
die("Query failed");
	}
?>