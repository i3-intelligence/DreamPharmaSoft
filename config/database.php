<?php
## FOR OFFLINE
	## FOR ONLINE
	$prefix = "";
	$servername = "localhost";
	$username = $prefix."root";
	$Password = "";
	$database = $prefix."pharmacy";

try {
	$conn = new PDO ("mysql:host=$servername;dbname=$database", "$username", "$Password", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //Print "Connected successfully"; 
    }
catch(PDOException $e)
{
Print "Connection failed: " . $e->getMessage();
}

if(!empty($_SESSION['DPS_ADMIN_SSN_ID']))
{		//CAll User Information
		$query1 = $conn->prepare("SELECT * FROM `controller_information` 
		 WHERE `id` = '".$_SESSION['DPS_ADMIN_SSN_ID']."' "); 
		$query1->execute();
		$FetchUserInfo = $query1->fetch(PDO::FETCH_ASSOC);

		$SessionID = $_SESSION['DPS_ADMIN_SSN_ID'];
		$OperatorName = $FetchUserInfo['UserName'];
		$OperatorDesignation = $FetchUserInfo['Designation'];
		$operator_address = $FetchUserInfo['Address'];
		$operator_phone = $FetchUserInfo['Phone'];
		$OperatorPicture = $FetchUserInfo['Picture'];
		$EditAccess = $FetchUserInfo['EditAccess'];
		$DeleteAccess = $FetchUserInfo['DeleteAccess'];

		
		$LastUpdate = $OperatorName . ' Date: ' . date("d-M-Y") . ' Time: ' . date("h:i:s a") .' IP ' . $_SERVER['REMOTE_ADDR'];
		$ActivePage = basename($_SERVER['PHP_SELF'], ".php");

}
  $CurrentDate = date("Y-m-d");
  $InvoiceDate = date("dmy",strtotime($CurrentDate));
  $InvoicePrefix = $InvoiceDate."U"."M";


//User Information
$currency = "BDT";
$currency_sym = "Tk";
$NumberValidity = "onfocus=\"if(this.value == '0') { this.value = ''; }\" onblur=\"if(this.value == '') { this.value = '0'; }\" oninput=\"this.value = this.value.replace(/[^-0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');\" ";
$c_logo = "dist/img/logo.png";
$CreateDate = "2023-01-01";
$maintenance = "01883008651";
$quantity = "Quantity";
$AutoComplete = "AutoComplete=\"off\"";
$CurrentTime = date("H:i:s");
$CurrentDateTime = date("$CurrentDate H:i:s");

$Development = "Dream Pharma Soft";
$DevelopmentLink = "https://www.facebook.com/shafayetnuralam";  

// print $_SESSION['CSRF'];
?>