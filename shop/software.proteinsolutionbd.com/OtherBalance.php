<?php
include("auth.php");
include("db.php");
include_once("clean.php");
header('Content-Type: application/json');

if(!empty($_POST['OtherID'])){

$OtherID = clean($_POST['OtherID']);
$TableName = "temp_OtherBalance".$SessionID;
$query = $conn->prepare("DROP TABLE IF EXISTS `$TableName`"); 
$query->execute();

## CREATE TABLE 
$create = $conn->prepare("CREATE TABLE `$TableName`  
(
`ID` INT(75) NULL,
`Date` DATE NOT NULL,
`Time` VARCHAR(125) NULL,
`OtherID` INT(11) NULL,
`Invoice` VARCHAR(125) NULL,
`InvoiceType` VARCHAR(125) NULL,
`InvoiceAmount` DOUBLE NULL,
`ReceiveAmount` DOUBLE NULL,
`PaidAmount` DOUBLE NULL,
`Discount`DOUBLE NULL,
`Receivable` DOUBLE NULL,
`Payable` DOUBLE NULL,
`PaymentType` VARCHAR(125) NULL,
`Creator` INT(11) NULL
)
");
$create->execute();


//Other Receive
$OtherReceive = $conn->exec("INSERT INTO `$TableName` 
SELECT 
    `ReceiveID`,
    `ReceiveDate`,
    `CreateDate` AS `PaymentTime`,
    `OtherID`,
    `OtherReceiveInvoice`,
    'Other Receive' AS `ReceiveType`, 
    '0' AS `InvoiceAmount`, 
    '0' AS `ReceiveAmount`,
    `ReceiveAmount` AS `PaidAmount`,
    `ReceiveDiscount` AS `Discount`,
    '0' AS `Receivable`,
    `ReceiveAmount` AS `Payable`, 
    `PaymentName` AS `PaymentType`, 
    `EntryID` 
FROM `Receive` WHERE `OtherID` = '".$OtherID."'  AND `ReceiveDate` BETWEEN '".$i3_define_date."' AND '".$CurrentDate."' AND OtherReceiveInvoice != '' GROUP BY `OtherReceiveInvoice` ");


//Other Payment
$OtherPayment = $conn->exec("INSERT INTO `$TableName` 
SELECT 
    `PaymentID`,
    `PaymentDate`,
    `CreateDate` AS `PaymentTime`,
    `OtherID`,
    `OtherPaymentInvoice`,
    'Other Payment' AS `PaymentType`, 
    '0' AS `InvoiceAmount`, 
    `PaymentAmount` AS `PaymentAmount`,
    '0' AS `PaidAmount`,
    `PaymentDiscount` AS `Discount`,
    `PaymentAmount` AS `Receivable`,
    '0' AS `Payable`, 
    `PaymentName` AS `PaymentType`, 
    `EntryID` 
FROM `Payment` WHERE `OtherID` = '".$OtherID."'  AND `PaymentDate` BETWEEN '".$i3_define_date."' AND '".$CurrentDate."' AND OtherPaymentInvoice != '' GROUP BY `OtherPaymentInvoice` ");

//Opening Balance / Previous Balance
$Balance_qurry = $conn->prepare("SELECT 
IFNULL(A.`OpeningBalance`,0) AS `OpeningBalance`,
(IFNULL(B.`Payable`,0) - (IFNULL(B.`Receivable`,0) + IFNULL(B.`Discount`,0))) AS `Balance`
 FROM `OthersAccount` A 
 LEFT JOIN (SELECT
    `OtherID`,
    SUM(`Receivable`) `Receivable`,
    SUM(`Discount`) `Discount`,
    SUM(`Payable`) `Payable`

  FROM `$TableName` WHERE  `Date` BETWEEN '".$i3_define_date."' AND '".$CurrentDate."' GROUP BY `OtherID`  ) B ON (A.`OthersAccountID` = B.`OtherID`)
 WHERE A.`OthersAccountID` = '".$OtherID."' ");
$Balance_qurry->execute();
$OpeningBalance = $Balance_qurry->fetch(PDO::FETCH_ASSOC);

$OtherBalance = number_format($OpeningBalance['OpeningBalance'] + $OpeningBalance['Balance'],2,'.','');

if($OtherBalance){
  $data['OtherBalance'] = $OtherBalance;
}else{
  $data['OtherBalance'] = 0;
}

echo json_encode ($data);

// DROP TABLE
$sql = $conn->prepare("DROP TABLE IF EXISTS `$TableName` ");
$sql->execute();
}