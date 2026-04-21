<?php
include("db.php");
$TableName = "temp_Wallet_ledger".$SessionID;
$query = $conn->prepare("DROP TABLE IF EXISTS `$TableName`"); 
$query->execute();

## CREATE TABLE 
$create = $conn->prepare("CREATE TABLE `$TableName`  
(
`ID` INT(75) NULL,
`Date` DATE NOT NULL,
`Time` VARCHAR(125) NULL,
`WalletID` INT(11) NULL,
`Invoice` VARCHAR(125) NULL,
`InvoiceType` VARCHAR(125) NULL,
`Receivable` DOUBLE NULL,
`Payable` DOUBLE NULL,
`PaymentType` VARCHAR(125) NULL,
`Title` VARCHAR(125) NULL,
`Remarks` VARCHAR(500) NULL,
`Creator` INT(11) NULL
)
");
$create->execute();

//Cash Memo
$CashMemo = $conn->exec("INSERT INTO `$TableName` 
SELECT 
        A.`CashMemoID`,
        A.`CashMemoDate`,
        A.`CreateDate` AS `CashMemoTime`,
        A.`WalletID`,
        A.`CashMemoInvoice`,
        'Cash Memo' AS `InvoiceType`,
        (A.`ReceiveAmount`) AS `Receivable`,
        '0' AS `Payable`,
        '' AS `PaymentType`, 
        (CASE
            WHEN A.`CustomerID` ='0' THEN CONCAT(A.`CustomerName`,'-', A.`CustomerAddress`)
            ELSE CONCAT(B.`Name`,'-', B.`Address`)
            END
        ) AS `Title`, 
        A.`Remarks`,
        A.`EntryID` 
    FROM `CashMemo` A 
    LEFT JOIN `Customer` B ON (A.`CustomerID` = B.`CustomerID`)

    WHERE A.`WalletID` = '".$WalletID."'  AND A.`Cart` = 'Yes' AND A.`CashMemoDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' GROUP BY A.`CashMemoInvoice`");

//Cash Memo Return
$CashMemoReturn = $conn->exec("INSERT INTO `$TableName` 
SELECT 
        A.`CashMemoReturnID`,
        A.`CashMemoReturnDate`,
        A.`CreateDate` AS `CashMemoTime`,
        A.`WalletID`,
        A.`CashMemoReturnInvoice`,
        'Cash Memo Return' AS `InvoiceType`,
        '0' AS `Receivable`,
        A.`PaymentAmount` AS `Payable`,
        '' AS `PaymentType`, 
        (CASE
            WHEN A.`CustomerID` ='0' THEN CONCAT(A.`CustomerName`,'-', A.`CustomerAddress`)
            ELSE CONCAT(B.`Name`,'-', B.`Address`)
            END
        ) AS `Title`, 
        A.`Remarks`,
        A.`EntryID` 
    FROM `CashMemoReturn` A
    LEFT JOIN `Customer` B ON (A.`CustomerID` = B.`CustomerID`)
    WHERE A.`WalletID` = '".$WalletID."'  AND A.`Cart` = 'Yes' AND A.`CashMemoReturnDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' GROUP BY A.`CashMemoReturnInvoice`");

//Customer Receive
$CustomerReceive = $conn->exec("INSERT INTO `$TableName` 
SELECT 
    A.`ReceiveID`,
    A.`ReceiveDate`,
    A.`CreateDate` AS `ReceiveTime`,
    A.`WalletID`,
    A.`CustomerReceiveInvoice`,
    'Customer Receive' AS `InvoiceType`, 
    A.`ReceiveAmount` AS `Receivable`,
    '0' AS `Payable`, 
    '' AS `ReceiveType`, 
    CONCAT(B.`Name`,'-', B.`Address`) AS `Title`, 
    A.`ReceiveNote`,
    A.`EntryID` 
FROM `Receive` A
LEFT JOIN `Customer` B ON (A.`CustomerID` = B.`CustomerID`)
WHERE A.`WalletID` = '".$WalletID."'  AND A.`ReceiveDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' AND A.`CustomerReceiveInvoice` != '' GROUP BY A.`CustomerReceiveInvoice` ");


//CustomerDueReceive
$CustomerDueReceive = $conn->exec("INSERT INTO `$TableName` 
SELECT 
    A.`ReceiveID`,
    A.`ReceiveDate`,
    A.`CreateDate` AS `ReceiveTime`,
    A.`WalletID`,
    A.`CustomerDueReceiveInvoice`,
    'Customer Due' AS `InvoiceType`, 
    '0' AS `Receivable`,
    A.`ReceiveAmount` AS `Payable`, 
    '' AS `ReceiveType`, 
    CONCAT(B.`Name`,'-', B.`Address`) AS `Title`, 
    A.`ReceiveNote`,
    A.`EntryID` 
FROM `Receive` A
LEFT JOIN `Customer` B ON (A.`CustomerID` = B.`CustomerID`)
WHERE A.`WalletID` = '".$WalletID."'  AND A.`ReceiveDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' AND A.`CustomerDueReceiveInvoice` != '' GROUP BY A.`CustomerDueReceiveInvoice` ");


//Supplier Payment
$SupplierPayment = $conn->exec("INSERT INTO `$TableName` 
SELECT 
    A.`PaymentID`,
    A.`PaymentDate`,
    A.`CreateDate` AS `PaymentTime`,
    A.`WalletID`,
    A.`SupplierPaymentInvoice`,
    'Supplier Payment' AS `InvoiceType`, 
    '0' AS `Receivable`,
    A.`PaymentAmount` AS `Payable`, 
    '' AS `PaymentType`, 
    CONCAT(B.`Name`,'-', B.`Address`) AS `Title`,
    A.`PaymentNote`, 
    A.`EntryID` 
FROM `Payment` A
LEFT JOIN `Supplier` B ON (A.`SupplierID` = B.`SupplierID`)
WHERE A.`WalletID` = '".$WalletID."'  AND A.`PaymentDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' AND A.`SupplierPaymentInvoice` != '' GROUP BY A.`SupplierPaymentInvoice` ");


//previus Date
$pdate = date('Y-m-d', strtotime('-1 day', strtotime($start_date)));
//Opening Balance / Previous Balance
$balance_qurry = $conn->prepare("SELECT 

((IFNULL(A.`OpeningBalance`,0) + IFNULL(B.`Receivable`,0)) - IFNULL(B.`Payable`,0)) `balance`

 FROM `Wallet` A 
 LEFT JOIN (SELECT
    `WalletID`,
    SUM(`Receivable`) `Receivable`,
    SUM(`Payable`) `Payable`

  FROM `$TableName` WHERE  `Date` BETWEEN '".$i3_define_date."' AND '".$pdate."' GROUP BY `WalletID`  ) B ON (A.`WalletID` = B.`WalletID`)
 WHERE A.`WalletID` = '".$WalletID."' ");
$balance_qurry->execute();
$OpeningBalance = $balance_qurry->fetch(PDO::FETCH_ASSOC);
$PreviousBalance = number_format($OpeningBalance['balance'],2,'.','');

?>