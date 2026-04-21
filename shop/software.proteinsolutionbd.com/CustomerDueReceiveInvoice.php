<?php
require_once("auth.php");
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
include("db.php"); 
$query1 = $conn->prepare("SELECT COALESCE(MAX(CAST(SUBSTRING_INDEX(CustomerDueReceiveInvoice, 'M', -1) AS UNSIGNED)) + 1, 1)  AS `CustomerDueReceiveInvoice` FROM `Receive`  WHERE `EntryID` = '$SessionID' AND `ReceiveDate` = '$CurrentDate' AND `ReceiveType` = 'Customer Due Receive' "); 
$query1->execute();
$fetch_Invoice = $query1->fetch(PDO::FETCH_ASSOC);
$CustomerDueReceive = "D".$InvoicePrefix.sprintf("%03d",$fetch_Invoice['CustomerDueReceiveInvoice']);
echo "data: $CustomerDueReceive\n\n";
flush();
?>