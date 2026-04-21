<?php
require_once("auth.php");
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
include("db.php"); 
$query1 = $conn->prepare("SELECT COALESCE(MAX(CAST(SUBSTRING_INDEX(ChallanReturnInvoice, 'M', -1) AS UNSIGNED)) + 1, 1)  AS `ChallanReturnInvoice` FROM `ChallanReturn`  WHERE `EntryID` = '$SessionID' AND `ChallanReturnDate` = '$CurrentDate' AND `Cart` = 'Yes' "); 
$query1->execute();
$fetch_Invoice = $query1->fetch(PDO::FETCH_ASSOC);
$ChallanReturn = "ChallanReturn".$InvoicePrefix.sprintf("%03d",$fetch_Invoice['ChallanReturnInvoice']);
echo "data: $ChallanReturn\n\n";
flush();
?>