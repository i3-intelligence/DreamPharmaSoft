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
		$query1 = $conn->prepare("SELECT A.*,B.`ShopName`,B.`ShopAddress`,B.`ShopContact`,B.`CreateDate` AS `ShopCreateDate`,B.`ShopDB` FROM `UserInformation` A
		 JOIN `Shop` B ON (A.`ShopId` = B.`id`)
		 WHERE A.`id` = '".$_SESSION['DPS_ADMIN_SSN_ID']."' "); 
		$query1->execute();
		$fetch_operator = $query1->fetch(PDO::FETCH_ASSOC);

		$SessionID = $_SESSION['DPS_ADMIN_SSN_ID'];
		$ShopId = $fetch_operator['ShopId'];
		$ShopDB = $fetch_operator['ShopDB'];
		$ShopCreateDate = $fetch_operator['ShopCreateDate'];
		$ShopName = $fetch_operator['ShopName'];
		$ShopAddress = $fetch_operator['ShopAddress'];
		$ShopContact = $fetch_operator['ShopContact'];
		$OperatorName = $fetch_operator['UserName'];
		$operator_designation = $fetch_operator['Designation'];
		$operator_address = $fetch_operator['Address'];
		$operator_phone = $fetch_operator['Phone'];
		$operator_picture = $fetch_operator['Picture'];
		$EditAccess = $fetch_operator['EditAccess'];
		$DeleteAccess = $fetch_operator['DeleteAccess'];

		
		$LastUpdate = $OperatorName . ' Date: ' . date("d-M-Y") . ' Time: ' . date("h:i:s a") .' IP ' . $_SERVER['REMOTE_ADDR'];
		$ActivePage = basename($_SERVER['PHP_SELF'], ".php");

		$query_custom_date = $conn->prepare("SELECT * FROM `CustomDate` WHERE `UserId` = '$SessionID' "); 
		$query_custom_date->execute();
		$fetch_custom_date = $query_custom_date->fetch(PDO::FETCH_ASSOC);

} 

if(!empty($fetch_custom_date['Date']) && $fetch_custom_date['Date'] != "")
{
 $CurrentDate = $fetch_custom_date['Date'];
 $InvoiceDate = date("dmy",strtotime($CurrentDate));
 $InvoicePrefix = $InvoiceDate."U".$SessionID."M";
}
else
{
  $CurrentDate = date("Y-m-d");
  $InvoiceDate = date("dmy",strtotime($CurrentDate));
  $InvoicePrefix = $InvoiceDate."U"."M";
}

//User Information
$company = "Protein Solution";
$SortName = "Protein Solution";
$c_address = "Mudaforgonj Bazar, Laksham, Cumilla.";
$c_mobile = "Mobile: 01866-640666, 01939-041951, 01880-383940.";
$c_email = "";
$currency = "BDT";
$currency_sym = "Tk";
$NumberValidity = "onfocus=\"if(this.value == '0') { this.value = ''; }\" onblur=\"if(this.value == '') { this.value = '0'; }\" oninput=\"this.value = this.value.replace(/[^-0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');\" ";
$c_logo = "dist/img/logo.png";
$i3_define_date = "2023-01-01";
$maintenance = "01883008651";
$quantity = "Quantity";
$AutoComplete = "AutoComplete=\"off\"";
$QtyCheck = "onfocus=\"if(this.value == '0') { this.value = ''; }\" onblur=\"if(this.value == '') { this.value = '0'; }\" oninput=\"this.value = this.value.replace(/[^-0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');\" ";
$CurrentTime = date("H:i:s");
$CurrentDateTime = date("$CurrentDate H:i:s");

$Development = "Dream Pharma Soft";
$DevelopmentLink = "https://www.facebook.com/shafayetnuralam";  

// print $_SESSION['CSRF'];
?>