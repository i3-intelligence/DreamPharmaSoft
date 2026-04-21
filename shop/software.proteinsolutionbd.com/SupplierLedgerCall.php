<?php
include("db.php");
$TableName = "temp_supplier_ledger".$SessionID;
$query = $conn->prepare("DROP TABLE IF EXISTS `$TableName`"); 
$query->execute();

## CREATE TABLE 
$create = $conn->prepare("CREATE TABLE `$TableName`  
(
`ID` INT(75) NULL,
`Date` DATE NOT NULL,
`Time` VARCHAR(125) NULL,
`SupplierID` INT(11) NULL,
`Invoice` VARCHAR(125) NULL,
`InvoiceType` VARCHAR(125) NULL,
`InvoiceAmoint` DOUBLE NULL,
`PaidAmount` DOUBLE NULL,
`Discount`DOUBLE NULL,
`Receivable` DOUBLE NULL,
`Payable` DOUBLE NULL,
`PaymentType` VARCHAR(125) NULL,
`Title` VARCHAR(255) NULL,
`Creator` INT(11) NULL
)
");
$create->execute();

//Purchase
$Purchase = $conn->exec("INSERT INTO `$TableName` 
SELECT 
        `ChallanID`,
        `ChallanDate`,
        `CreateDate` AS `ChallanTime`,
        `SupplierID`,
        `ChallanInvoice`,
        'Purchase' AS `InvoiceType`,
        '' AS `InvoiceAmoint`, 
        '0' AS `PaidAmount`,
        '0' AS `Discount`,
        SUM(`Amount`) AS `Receivable`,
        '0' AS `Payable`,
        '' AS `PaymentType`, 
        `Remarks`,
        `EntryID` 
    FROM `Challan` WHERE `SupplierID` = '".$SupplierID."'  AND `Cart` = 'Yes' AND `ChallanDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' GROUP BY `ChallanInvoice`");

//Purchase Return
$PurchaseReturn = $conn->exec("INSERT INTO `$TableName` 
SELECT 
        `ChallanReturnID`,
        `ChallanReturnDate`,
        `CreateDate` AS `ChallanTime`,
        `SupplierID`,
        `ChallanReturnInvoice`,
        'Purchase Return' AS `InvoiceType`,
        '' AS `InvoiceAmoint`, 
        '0' AS `PaidAmount`,
        '0' AS `Discount`,
        '0' AS `Receivable`,
        SUM(`ReturnAmount`) AS `Payable`,
        '' AS `PaymentType`, 
        `Remarks`,
        `EntryID` 
    FROM `ChallanReturn` WHERE `SupplierID` = '".$SupplierID."'  AND `Cart` = 'Yes' AND `ChallanReturnDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' GROUP BY `ChallanReturnInvoice`");

//Payment
$payment = $conn->exec("INSERT INTO `$TableName` 
SELECT 
    `PaymentID`,
    `PaymentDate`,
    `CreateDate` AS `PaymentTime`,
    `SupplierID`,
    `SupplierPaymentInvoice`,
    'Supplier Payment' AS `InvoiceType`, 
    '0' AS `InvoiceAmoint`, 
    `PaymentAmount` AS `PaidAmount`,
    `PaymentDiscount` AS `Discount`,
    '0' AS `Receivable`,
    `PaymentAmount` AS `Payable`, 
    `PaymentName` AS `PaymentType`, 
    `PaymentNote`,
    `EntryID` 
FROM `Payment` WHERE `SupplierID` = '".$SupplierID."'  AND `PaymentDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' GROUP BY `SupplierPaymentInvoice` ");



//previus Date
$pdate = date('Y-m-d', strtotime('-1 day', strtotime($start_date)));
//Opening Balance / Previous Balance
$Balance_qurry = $conn->prepare("SELECT 
IFNULL(A.`OpeningBalance`,0) AS `OpeningBalance`,
(IFNULL(B.`Payable`,0) - IFNULL(B.`Receivable`,0) + IFNULL(B.`Discount`,0)) AS `Balance`
 FROM `Supplier` A 
 LEFT JOIN (SELECT
    `SupplierID`,
    SUM(`Receivable`) `Receivable`,
    SUM(`Discount`) `Discount`,
    SUM(`Payable`) `Payable`

  FROM `$TableName` WHERE  `Date` BETWEEN '".$i3_define_date."' AND '".$pdate."' GROUP BY `SupplierID`  ) B ON (A.`SupplierID` = B.`SupplierID`)
 WHERE A.`SupplierID` = '".$SupplierID."' ");
$Balance_qurry->execute();
$OpeningBalance = $Balance_qurry->fetch(PDO::FETCH_ASSOC);

if($OpeningBalance['OpeningBalance'] >= 0 ){
    $PreviousBalance = number_format($OpeningBalance['OpeningBalance']+$OpeningBalance['Balance'],2,'.','');
}else{
    $PreviousBalance = number_format($OpeningBalance['Balance'] + $OpeningBalance['OpeningBalance'],2,'.','');
}




?>