<?php
if(!ISSET($_SESSION)){
	//Start session
	session_start();
}

date_default_timezone_set('Asia/Dhaka');

//Check whether the session variable SESS_MEMBER_ID is present or not
if(!isset($_SESSION['PS_SESS_MEMBER_ID']) || (trim($_SESSION['PS_SESS_MEMBER_ID']) == '')) {	
header("location:index.php?notify=ad");		
exit();
	}
 $SessionID = ($_SESSION['PS_SESS_MEMBER_ID']); 
 $Token = ($_SESSION['Token']);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>