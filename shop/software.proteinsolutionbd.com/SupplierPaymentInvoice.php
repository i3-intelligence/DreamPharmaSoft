<?php
require_once("auth.php");
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
include("db.php"); 
$query1 = $conn->prepare("SELECT COALESCE(MAX(CAST(SUBSTRING_INDEX(SupplierPaymentInvoice, 'M', -1) AS UNSIGNED)) + 1, 1)  AS `SupplierPaymentInvoice` FROM `Payment`  WHERE `EntryID` = '$SessionID' AND `PaymentDate` = '$CurrentDate' AND `PaymentType` = 'Supplier Payment' "); 
$query1->execute();
$fetch_Invoice = $query1->fetch(PDO::FETCH_ASSOC);
$SupplierPayment = "S".$InvoicePrefix.sprintf("%03d",$fetch_Invoice['SupplierPaymentInvoice']);
echo "data: $SupplierPayment\n\n";
flush();
?>