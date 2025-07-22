<?php
if(!ISSET($_SESSION)){
	//Start session
	session_start();
}

date_default_timezone_set('Asia/Dhaka');

//Check whether the session variable SESS_MEMBER_ID is present or not
if(!isset($_SESSION['DPS_ADMIN_SSN_ID']) || (trim($_SESSION['DPS_ADMIN_SSN_ID']) == '')) {	
header("location:public/index.php?notify=ad");		
exit();
	}
 $SessionID = ($_SESSION['DPS_ADMIN_SSN_ID']); 
 $Token = ($_SESSION['Token']);
?>