<?php
require_once("auth.php");
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
include("db.php"); 
$query1 = $conn->prepare("SELECT COALESCE(MAX(CAST(SUBSTRING_INDEX(CashMemoInvoice, 'M', -1) AS UNSIGNED)) + 1, 1)  AS `CashMemoInvoice` FROM `CashMemo`  WHERE `EntryID` = '$SessionID' AND `CashMemoDate` = '$CurrentDate'  "); 
$query1->execute();
$fetch_Invoice = $query1->fetch(PDO::FETCH_ASSOC);
$CashMemoInvoice = "C".$InvoicePrefix.sprintf("%03d",$fetch_Invoice['CashMemoInvoice']);
echo "data: $CashMemoInvoice\n\n";
flush();
?>