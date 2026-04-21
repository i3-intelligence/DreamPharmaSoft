<?php
include("auth.php");
include("db.php");
$TableName = "temp_Customer_ledger".$SessionID;
$query = $conn->prepare("DROP TABLE IF EXISTS `$TableName`"); 
$query->execute();

## CREATE TABLE 
$create = $conn->prepare("CREATE TABLE `$TableName`  
(
`ID` INT(75) NULL,
`Date` DATE NOT NULL,
`Time` VARCHAR(125) NULL,
`CustomerID` INT(11) NULL,
`Invoice` VARCHAR(125) NULL,
`InvoiceType` VARCHAR(125) NULL,
`InvoiceAmount` DOUBLE NULL,
`ReceiveAmount` DOUBLE NULL,
`PaidAmount` DOUBLE NULL,
`Discount`DOUBLE NULL,
`Receivable` DOUBLE NULL,
`Payable` DOUBLE NULL,
`PaymentType` VARCHAR(125) NULL,
`Remarks` VARCHAR(300) NULL,
`Creator` INT(11) NULL
)
");
$create->execute();

//CashMemo
$CashMemo = $conn->exec("INSERT INTO `$TableName` 
SELECT 
        `CashMemoID`,
        `CashMemoDate`,
        `CreateDate` AS `CashMemoTime`,
        `CustomerID`,
        `CashMemoInvoice`,
        'Cash Memo' AS `InvoiceType`,
        `TotalAmount` AS `InvoiceAmount`, 
        `ReceiveAmount` AS `ReceiveAmount`,
        '0' AS `PaidAmount`,
        `Discount`,
        `ReceiveAmount` AS `Receivable`,
        `TotalAmount` AS `Payable`,
        `TransactionType` AS `PaymentType`, 
        `Remarks`,
        `EntryID` 
    FROM `CashMemo` WHERE `CustomerID` = '".$CustomerID."'  AND `Cart` = 'Yes' AND `CashMemoDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' GROUP BY `CashMemoInvoice`");

//Cash Memo Return
$CashMemoReturn = $conn->exec("INSERT INTO `$TableName` 
SELECT 
        `CashMemoReturnID`,
        `CashMemoReturnDate`,
        `CreateDate` AS `CashMemoReturnTime`,
        `CustomerID`,
        `CashMemoReturnInvoice`,
        'Cash Memo Return' AS `InvoiceType`,
        `TotalAmount` AS `InvoiceAmount`, 
        '0' AS `ReceiveAmount`,
        `PaymentAmount` AS `PaidAmount`,
        '0' AS `Discount`,
        SUM(`ReturnAmount`) AS `Receivable`,
         `PaymentAmount` AS `Payable`,
        `TransactionType` AS `PaymentType`, 
        `Remarks`,
        `EntryID` 
    FROM `CashMemoReturn` WHERE `CustomerID` = '".$CustomerID."'  AND `Cart` = 'Yes' AND `CashMemoReturnDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' GROUP BY `CashMemoReturnInvoice`");


//CustomerDue
$CustomerDue = $conn->exec("INSERT INTO `$TableName` 
SELECT 
    `ReceiveID`,
    `ReceiveDate`,
    `CreateDate` AS `PaymentTime`,
    `CustomerID`,
    `CustomerDueReceiveInvoice`,
    'Customer Due' AS `ReceiveType`, 
    '0' AS `InvoiceAmount`, 
    '0' AS `ReceiveAmount`,
    `ReceiveAmount` AS `PaidAmount`,
    `ReceiveDiscount` AS `Discount`,
    '0' AS `Receivable`,
    `ReceiveAmount` AS `Payable`, 
    `PaymentName` AS `PaymentType`, 
    `ReceiveNote` AS `Remarks`,
    `EntryID` 
FROM `Receive` WHERE `CustomerID` = '".$CustomerID."'  AND `ReceiveDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' AND CustomerDueReceiveInvoice != '' GROUP BY `CustomerDueReceiveInvoice` ");


//CustomerReceive
$CustomerReceive = $conn->exec("INSERT INTO `$TableName` 
SELECT 
    `ReceiveID`,
    `ReceiveDate`,
    `CreateDate` AS `PaymentTime`,
    `CustomerID`,
    `CustomerReceiveInvoice`,
    'Customer Receive' AS `ReceiveType`, 
    '0' AS `InvoiceAmount`, 
    `ReceiveAmount` AS `ReceiveAmount`,
    '0' AS `PaidAmount`,
    `ReceiveDiscount` AS `Discount`,
    `ReceiveAmount` AS `Receivable`,
    '0' AS `Payable`, 
    `PaymentName` AS `PaymentType`, 
    `ReceiveNote` AS `Remarks`,
    `EntryID` 
FROM `Receive` WHERE `CustomerID` = '".$CustomerID."'  AND `ReceiveDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' AND CustomerReceiveInvoice != '' GROUP BY `CustomerReceiveInvoice` ");

//previus Date
$pdate = date('Y-m-d', strtotime('-1 day', strtotime($start_date)));
//Opening Balance / Previous Balance
$Balance_qurry = $conn->prepare("SELECT 
IFNULL(A.`OpeningBalance`,0) AS `OpeningBalance`,
(IFNULL(B.`Payable`,0) - (IFNULL(B.`Receivable`,0) + IFNULL(B.`Discount`,0))) AS `Balance`
 FROM `Customer` A 
 LEFT JOIN (SELECT
    `CustomerID`,
    SUM(`Receivable`) `Receivable`,
    SUM(`Discount`) `Discount`,
    SUM(`Payable`) `Payable`

  FROM `$TableName` WHERE  `Date` BETWEEN '".$i3_define_date."' AND '".$pdate."' GROUP BY `CustomerID`  ) B ON (A.`CustomerID` = B.`CustomerID`)
 WHERE A.`CustomerID` = '".$CustomerID."' ");
$Balance_qurry->execute();
$OpeningBalance = $Balance_qurry->fetch(PDO::FETCH_ASSOC);

$PreviousBalance = number_format($OpeningBalance['OpeningBalance'] + $OpeningBalance['Balance'],2,'.','');

?>