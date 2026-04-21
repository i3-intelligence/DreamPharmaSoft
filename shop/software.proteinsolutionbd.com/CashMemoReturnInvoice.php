<?php
require_once("auth.php");
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
include("db.php"); 
$query1 = $conn->prepare("SELECT COALESCE(MAX(CAST(SUBSTRING_INDEX(CashMemoReturnInvoice, 'M', -1) AS UNSIGNED)) + 1, 1)  AS `CashMemoReturnInvoice` FROM `CashMemoReturn`  WHERE `EntryID` = '$SessionID' AND `CashMemoReturnDate` = '$CurrentDate'  "); 
$query1->execute();
$fetch_Invoice = $query1->fetch(PDO::FETCH_ASSOC);
$CashMemoReturnInvoice = "RCM".$InvoicePrefix.sprintf("%03d",$fetch_Invoice['CashMemoReturnInvoice']);
echo "data: $CashMemoReturnInvoice\n\n";
flush();
?>