<?php
include("db.php");
$SupplierPrevousBalance = "temp_supplier_balance".$SessionID;
$query = $conn->prepare("DROP TABLE IF EXISTS `$SupplierPrevousBalance`"); 
$query->execute();

## CREATE TABLE 
$create = $conn->prepare("CREATE TABLE `$SupplierPrevousBalance`  
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
$create->execute();

//Purchase
$Purchase = $conn->exec("INSERT INTO `$SupplierPrevousBalance` 
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
$PurchaseReturn = $conn->exec("INSERT INTO `$SupplierPrevousBalance` 
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
$payment = $conn->exec("INSERT INTO `$SupplierPrevousBalance` 
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


// Date
$pdate = date('Y-m-d', strtotime('-1 day', strtotime($end_date)));

$query = $conn->prepare("SELECT 
IFNULL(A.`OpeningBalance`,0) AS `OpeningBalance`,
(IFNULL(B.`pre_Payable`,0) - IFNULL(B.`pre_Receivable`,0) + IFNULL(B.`pre_Discount`,0)) AS `pre_Balance`,

(IFNULL(B.`Payable`,0) - IFNULL(B.`Receivable`,0) + IFNULL(B.`Discount`,0)) AS `Balance`
 FROM `Supplier` A 
 LEFT JOIN (SELECT
    `SupplierID`,
    SUM(CASE WHEN  `date` BETWEEN '".$i3_define_date."' AND '".$pdate."' THEN `Receivable` ELSE 0 END) `pre_Receivable`,
	SUM(CASE WHEN  `date` BETWEEN '".$i3_define_date."' AND '".$pdate."' THEN `Payable` ELSE 0 END) `pre_Payable`,

	SUM(CASE WHEN  `date` BETWEEN '".$i3_define_date."' AND '".$pdate."' THEN `Discount` ELSE 0 END) `pre_Discount`,

	SUM(CASE WHEN  `date` BETWEEN '".$start_date."' AND '".$end_date."' THEN `Receivable` ELSE 0 END) `Receivable`,


	SUM(CASE WHEN  `date` BETWEEN '".$start_date."' AND '".$end_date."' THEN `Discount` ELSE 0 END) `Discount`,

	SUM(CASE 
	WHEN  `date` BETWEEN  '".$start_date."' AND '".$end_date."' THEN (IFNULL(`Payable`,0)) 
	ELSE 0
	END ) `Payable`

  FROM `$SupplierPrevousBalance` GROUP BY `SupplierID`  ) B ON (A.`SupplierID` = B.`SupplierID`)
 GROUP BY A.`SupplierID` 
 ORDER BY A.`SupplierID` ASC
 ");
$query->execute();
                
$fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);

foreach($fetch_list AS $fetch) { 

    if($fetch['OpeningBalance'] >= 0 ){
        $Balance = number_format( $fetch['OpeningBalance'] + ($fetch['pre_Balance'] + $fetch['Balance']) ,2,'.','');
    }else{
        $Balance = number_format( ($fetch['pre_Balance'] + $fetch['Balance']) + $fetch['OpeningBalance'],2,'.','');
    }

	if($Balance <='0'){ 
		$NetReceivable = abs($Balance);
		$NetPayable = 0;
	}else{
		$NetReceivable = 0;
		$NetPayable = $Balance;
	} 

$PreviousdayReceivable += $NetReceivable;
$PreviousdayPayable += $NetPayable;
} //while 



$SupplierBalancePreviousday = number_format($PreviousdayReceivable - $PreviousdayPayable,2,'.',''); 


$query = $conn->prepare("DROP TABLE IF EXISTS `$SupplierPrevousBalance`"); 
$query->execute();

?>