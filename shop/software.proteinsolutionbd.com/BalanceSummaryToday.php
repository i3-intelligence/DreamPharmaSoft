<?php
include("auth.php");
include("db.php");
$end_date = $get_end_date->format('Y-m-d');

$TableName = "temp_Balance_Customer_ledger".$SessionID;
$drop1 = $conn->prepare("DROP TABLE IF EXISTS `$TableName`"); 
$drop1->execute();
 
## CREATE TABLE 
$create1 = $conn->prepare("CREATE TABLE `$TableName`  
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
`Creator` INT(11) NULL
)
");
$create1->execute();

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
        `EntryID` 
    FROM `CashMemo` WHERE  `Cart` = 'Yes' AND `CashMemoDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' GROUP BY `CashMemoInvoice`");

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
        `EntryID` 
    FROM `CashMemoReturn` WHERE  `Cart` = 'Yes' AND `CashMemoReturnDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' GROUP BY `CashMemoReturnInvoice`");


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
    `EntryID` 
FROM `Receive` WHERE  `ReceiveDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' AND CustomerDueReceiveInvoice != '' GROUP BY `CustomerDueReceiveInvoice` ");


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
    `EntryID` 
FROM `Receive` WHERE  `ReceiveDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' AND CustomerReceiveInvoice != '' GROUP BY `CustomerReceiveInvoice` ");

$CustomerBalance ='0';
$query2 = $conn->prepare("SELECT 
IFNULL(A.`OpeningBalance`,0) AS `OpeningBalance`,
((IFNULL(B.`pre_Payable`,0)) - (IFNULL(B.`pre_Receivable`,0) + IFNULL(B.`pre_Discount`,0))) `pre_balance`
 FROM `Customer` A 
 LEFT JOIN (SELECT
    `CustomerID`,
    SUM(CASE WHEN  `date` BETWEEN '".$i3_define_date."' AND '".$end_date."' THEN `Receivable` ELSE 0 END) `pre_Receivable`,
	
	SUM(CASE WHEN  `date` BETWEEN '".$i3_define_date."' AND '".$end_date."' THEN `PaidAmount` ELSE 0 END) `pre_PaidAmount`,

	SUM(CASE WHEN  `date` BETWEEN '".$i3_define_date."' AND '".$end_date."' THEN `Discount` ELSE 0 END) `pre_Discount`,

	SUM(CASE 
		WHEN  `date` BETWEEN  '".$i3_define_date."' AND '".$end_date."' THEN (IFNULL(`Payable`,0)) 
		ELSE 0
		END ) `pre_Payable`

  FROM `$TableName` GROUP BY `CustomerID`  ) B ON (A.`CustomerID` = B.`CustomerID`)
 GROUP BY A.`CustomerID` 
 ORDER BY A.`CustomerID` ASC
 ");
$query2->execute();
$fetch_list1 = $query2->fetchAll(PDO::FETCH_ASSOC);
foreach($fetch_list1 AS $fetch1) { 
	$CustomerBalance += ($fetch1['OpeningBalance'] + $fetch1['pre_balance']);	
}



$TableName2 = "temp_Balance_supplier_ledger".$SessionID;
$query3 = $conn->prepare("DROP TABLE IF EXISTS `$TableName2`"); 
$query3->execute();

## CREATE TABLE 
$create2 = $conn->prepare("CREATE TABLE `$TableName2`  
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
`Creator` INT(11) NULL
)
");
$create2->execute();

//Purchase
$Purchase = $conn->exec("INSERT INTO `$TableName2` 
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
        `EntryID` 
    FROM `Challan` WHERE  `Cart` = 'Yes' AND `ChallanDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' GROUP BY `ChallanInvoice`");

//Purchase Return
$PurchaseReturn = $conn->exec("INSERT INTO `$TableName2` 
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
        `EntryID` 
    FROM `ChallanReturn` WHERE  `Cart` = 'Yes' AND `ChallanReturnDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' GROUP BY `ChallanReturnInvoice`");

//Payment
$payment = $conn->exec("INSERT INTO `$TableName2` 
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
    `EntryID` 
FROM `Payment` WHERE  `PaymentDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' GROUP BY `SupplierPaymentInvoice` ");

$SupplierBalance =0;
$query3 = $conn->prepare("SELECT 
A.`SupplierID`,
IFNULL(A.`OpeningBalance`,0) AS `OpeningBalance`,

(IFNULL(B.`pre_Payable`,0) - IFNULL(B.`pre_Receivable`,0) + IFNULL(B.`pre_Discount`,0)) AS `pre_Balance`

 FROM `Supplier` A 
 LEFT JOIN (SELECT
    `SupplierID`,
    SUM(CASE WHEN  `date` BETWEEN '".$i3_define_date."' AND '".$end_date."' THEN `Receivable` ELSE 0 END) `pre_Receivable`,
	SUM(CASE WHEN  `date` BETWEEN '".$i3_define_date."' AND '".$end_date."' THEN `Payable` ELSE 0 END) `pre_Payable`,

	SUM(CASE WHEN  `date` BETWEEN '".$i3_define_date."' AND '".$end_date."' THEN `Discount` ELSE 0 END) `pre_Discount`

  FROM `$TableName2` GROUP BY `SupplierID`  ) B ON (A.`SupplierID` = B.`SupplierID`)
 GROUP BY A.`SupplierID` 
 ORDER BY A.`SupplierID` ASC
 ");
$query3->execute();
      
    $fetch_list2 = $query3->fetchAll(PDO::FETCH_ASSOC);

    foreach($fetch_list2 AS $fetch2) { 
        $SupplierBalance += number_format($fetch2["OpeningBalance"] + $fetch2["pre_Balance"],2,'.','');
    }

    
    $TableName3 = "temp_Balance_Wallet_ledger".$SessionID;
    $query4 = $conn->prepare("DROP TABLE IF EXISTS `$TableName3`"); 
    $query4->execute();
    
    ## CREATE TABLE 
    $create3 = $conn->prepare("CREATE TABLE `$TableName3`  
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
    `Creator` INT(11) NULL
    )
    ");
    $create3->execute();
    
    //Cash Memo
    $CashMemo2 = $conn->exec("INSERT INTO `$TableName3` 
    SELECT 
            `CashMemoID`,
            `CashMemoDate`,
            `CreateDate` AS `CashMemoTime`,
            `WalletID`,
            `CashMemoInvoice`,
            'Cash Memo' AS `InvoiceType`,
            (`ReceiveAmount`) AS `Receivable`,
            '0' AS `Payable`,
            '' AS `PaymentType`, 
            `EntryID` 
        FROM `CashMemo` WHERE  `Cart` = 'Yes' AND `CashMemoDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' GROUP BY `CashMemoInvoice`");
    
    //Cash Memo Return
    $CashMemoReturn2 = $conn->exec("INSERT INTO `$TableName3` 
    SELECT 
            `CashMemoReturnID`,
            `CashMemoReturnDate`,
            `CreateDate` AS `CashMemoTime`,
            `WalletID`,
            `CashMemoReturnInvoice`,
            'Cash Memo Return' AS `InvoiceType`,
            '0' AS `Receivable`,
            `PaymentAmount` AS `Payable`,
            '' AS `PaymentType`, 
            `EntryID` 
        FROM `CashMemoReturn` WHERE  `Cart` = 'Yes' AND `CashMemoReturnDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' GROUP BY `CashMemoReturnInvoice`");
    
    //CustomerReceive
    $CustomerReceive2 = $conn->exec("INSERT INTO `$TableName3` 
    SELECT 
        `ReceiveID`,
        `ReceiveDate`,
        `CreateDate` AS `ReceiveTime`,
        `WalletID`,
        `CustomerReceiveInvoice`,
        'Customer Receive' AS `InvoiceType`, 
        `ReceiveAmount` AS `Receivable`,
        '0' AS `Payable`, 
        '' AS `ReceiveType`, 
        `EntryID` 
    FROM `Receive` WHERE  `ReceiveDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' AND `CustomerReceiveInvoice` != '' GROUP BY `CustomerReceiveInvoice` ");
    
    
    //CustomerDueReceive
    $CustomerDueReceive2 = $conn->exec("INSERT INTO `$TableName3` 
    SELECT 
        `ReceiveID`,
        `ReceiveDate`,
        `CreateDate` AS `ReceiveTime`,
        `WalletID`,
        `CustomerDueReceiveInvoice`,
        'Customer Due' AS `InvoiceType`, 
        '0' AS `Receivable`,
        `ReceiveAmount` AS `Payable`, 
        '' AS `ReceiveType`, 
        `EntryID` 
    FROM `Receive` WHERE  `ReceiveDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' AND `CustomerDueReceiveInvoice` != '' GROUP BY `CustomerDueReceiveInvoice` ");
    
    
    //Supplier Payment
    $SupplierPayment2 = $conn->exec("INSERT INTO `$TableName3` 
    SELECT 
        `PaymentID`,
        `PaymentDate`,
        `CreateDate` AS `PaymentTime`,
        `WalletID`,
        `SupplierPaymentInvoice`,
        'Supplier Payment' AS `InvoiceType`, 
        '0' AS `Receivable`,
        `PaymentAmount` AS `Payable`, 
        '' AS `PaymentType`, 
        `EntryID` 
    FROM `Payment` WHERE  `PaymentDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' AND `SupplierPaymentInvoice` != '' GROUP BY `SupplierPaymentInvoice` ");
    
    $WalletBalance = 0;
    $query5 = $conn->prepare("SELECT 
    A.`WalletID`,
    ((IFNULL(A.`OpeningBalance`,0) + IFNULL(B.`pre_Receivable`,0)) - (IFNULL(B.`pre_Payable`,0))) `pre_balance`
    
     FROM `Wallet` A 
     LEFT JOIN (SELECT
        `WalletID`,
        SUM(CASE WHEN  `date` BETWEEN '".$i3_define_date."' AND '".$end_date."' THEN `Receivable` ELSE 0 END) `pre_Receivable`,
    
        SUM(CASE 
            WHEN  `date` BETWEEN  '".$i3_define_date."' AND '".$end_date."' THEN (IFNULL(`Payable`,0)) 
            ELSE 0
            END ) `pre_Payable`
    
      FROM `$TableName3` GROUP BY `WalletID`  ) B ON (A.`WalletID` = B.`WalletID`)
     GROUP BY A.`WalletID` 
     ORDER BY A.`WalletID` ASC
     ");
    $query5->execute();
    $fetch_list3 = $query5->fetchAll(PDO::FETCH_ASSOC);
    
    foreach($fetch_list3 AS $fetch3) { 
        $WalletBalance += number_format($fetch3['pre_balance'],2,'.','');
    }
    
    
$ClosingBalance =0;
$query6 = $conn->prepare("SELECT 
A.`Rate`,
(CASE WHEN `Cart` = 'Yes' AND A.`ChallanDate` BETWEEN '$i3_define_date' AND '$end_date' THEN A.`Quantity` ELSE 0 END) AS `OpeningPurchaseQuantity`,
(CASE WHEN `Cart` = 'Yes' AND A.`ChallanDate` = '$end_date'  THEN A.`Quantity` ELSE 0 END) AS `PurchaseQuantity`,
CONCAT(B.`SupplierID`,'-',B.`Name`,'-',B.`MobileNo`,'-',B.`Address`) AS `SupplierInfo`,
IFNULL(E.`OpeningPurchaseReturnQuantity`,0) AS `OpeningPurchaseReturnQuantity`,
IFNULL(F.`OpeningSalesQuantity`,0) AS `OpeningSalesQuantity`,
IFNULL(G.`OpeningSalesReturnQuantity`,0) AS `OpeningSalesReturnQuantity`
FROM `Challan` A 
LEFT JOIN `Supplier` B ON (A.`SupplierID` = B.`SupplierID`) 
LEFT JOIN `ItemCategory` C ON (A.`ItemCategoryID` = C.`ItemCategoryID`) 

LEFT JOIN (SELECT
`PackageSizeID`,
`Thickness`,
`Size`
FROM `PackageSize` ) D ON (A.`PackageSizeID` = D.`PackageSizeID`)

LEFT JOIN (SELECT
`ChallanID`,
SUM(CASE WHEN `Cart` = 'Yes' AND `ChallanReturnDate` BETWEEN '$i3_define_date'  AND '$end_date' THEN `ReturnQuantity` ELSE 0 END) AS `OpeningPurchaseReturnQuantity`
FROM `ChallanReturn` WHERE `ChallanReturnDate` BETWEEN '$i3_define_date'  AND '$end_date' GROUP BY `ChallanID` ) E ON (A.`ChallanID` = E.`ChallanID`)


LEFT JOIN (SELECT
`ChallanID`,
SUM(CASE WHEN `Cart` = 'Yes' AND `CashMemoDate` BETWEEN '$i3_define_date'  AND '$end_date' THEN `SalesQuantity` ELSE 0 END) AS `OpeningSalesQuantity`
FROM `CashMemo` WHERE `CashMemoDate` BETWEEN '$i3_define_date'  AND '$end_date' GROUP BY `ChallanID` ) F ON (A.`ChallanID` = F.`ChallanID`)

LEFT JOIN (SELECT
`ChallanID`,
SUM(CASE WHEN `Cart` = 'Yes' AND `CashMemoReturnDate` BETWEEN '$i3_define_date'  AND '$end_date' THEN `ReturnQuantity` ELSE 0 END) AS `OpeningSalesReturnQuantity`
FROM `CashMemoReturn` WHERE `CashMemoReturnDate` BETWEEN '$i3_define_date'  AND '$end_date' GROUP BY `ChallanID` ) G ON (A.`ChallanID` = G.`ChallanID`)

 
WHERE A.`ChallanDate` BETWEEN '$i3_define_date'  AND '$end_date' 
GROUP BY A.`ChallanID`
ORDER BY A.`ChallanDate`,A.`ChallanInvoice` ASC");
$query6->execute();
$fetch_list4 = $query6->fetchAll(PDO::FETCH_ASSOC);

foreach($fetch_list4 AS $fetch4) { 
    $OpeningBalanceQuantity = (($fetch4['OpeningPurchaseQuantity'] + $fetch4['OpeningSalesReturnQuantity']) - ($fetch4['OpeningPurchaseReturnQuantity'] + $fetch4['OpeningSalesQuantity']));
    
    $ClosingBalance += number_format(($OpeningBalanceQuantity) * $fetch4['Rate'],2,'.',''); 
}

?>