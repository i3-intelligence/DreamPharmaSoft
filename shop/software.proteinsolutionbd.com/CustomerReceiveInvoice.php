<?php
require_once("auth.php");
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
include("db.php"); 
$query1 = $conn->prepare("SELECT COALESCE(MAX(CAST(SUBSTRING_INDEX(CustomerReceiveInvoice, 'M', -1) AS UNSIGNED)) + 1, 1)  AS `CustomerReceiveInvoice` FROM `Receive`  WHERE `EntryID` = '$SessionID' AND `ReceiveDate` = '$CurrentDate' AND `ReceiveType` = 'Customer Receive' "); 
$query1->execute();
$fetch_Invoice = $query1->fetch(PDO::FETCH_ASSOC);
$CustomerReceive = "R".$InvoicePrefix.sprintf("%03d",$fetch_Invoice['CustomerReceiveInvoice']);
echo "data: $CustomerReceive\n\n";
flush();
?>