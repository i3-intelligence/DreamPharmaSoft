<?php
require_once("auth.php");
include("db.php");
include_once("clean.php");

// Receive Delete
if($_POST['action']=='ReceiveDelete' && !empty($_POST['PrimaryID'])){

    $PrimaryID = clean($_POST['PrimaryID']);
    
    $BackupData = $conn->prepare("INSERT INTO `Delete_Receive`(`ReceiveID`, `CustomerDueReceiveInvoice`,`CustomerReceiveInvoice`, `ReceiveDate`, `CustomerID`, `CustomerBalance`, `TransactionType`, `PaymentName`, `ReceiveType`, `WalletID`, `BankID`, `ReceiveAmount`, `ReceiveDiscount`, `ReceiveNote`, `CreateDate`, `EntryID`, `DeleteID`, `DeleteDate`, `Status`)  SELECT `ReceiveID`, `CustomerDueReceiveInvoice`, `CustomerReceiveInvoice`, `ReceiveDate`, `CustomerID`, `CustomerBalance`, `TransactionType`, `PaymentName`, `ReceiveType`, `WalletID`, `BankID`, `ReceiveAmount`, `ReceiveDiscount`, `ReceiveNote`, `CreateDate`, `EntryID`, '$SessionID', '$CurrentDateTime', `Status` FROM `Receive` WHERE `ReceiveID` = '".$PrimaryID."' ");
    $BackupData->execute();


    $Delete = $conn->prepare("DELETE FROM `Receive` WHERE  `ReceiveID` = '".$PrimaryID."'  "); 
    $Delete->execute();


    if($Delete){
    Print "300";
    exit();
    }else{
    Print "400";
    }
    
    }

    
// Payment Delete
if($_POST['action']=='PaymentDelete' && !empty($_POST['PrimaryID'])){

    $PrimaryID = clean($_POST['PrimaryID']);
    
    $BackupData = $conn->prepare("INSERT INTO `Delete_Payment`(`PaymentID`, `SupplierPaymentInvoice`, `PaymentDate`, `SupplierID`, `SupplierBalance`, `TransactionType`, `PaymentName`, `PaymentType`, `WalletID`, `BankID`, `PaymentAmount`, `PaymentDiscount`, `PaymentNote`, `CreateDate`, `EntryID`, `DeleteID`, `DeleteDate`, `Status`)  SELECT `PaymentID`, `SupplierPaymentInvoice`, `PaymentDate`, `SupplierID`, `SupplierBalance`, `TransactionType`, `PaymentName`, `PaymentType`, `WalletID`, `BankID`, `PaymentAmount`, `PaymentDiscount`, `PaymentNote`, `CreateDate`, `EntryID`, '$SessionID', '$CurrentDateTime', `Status` FROM `Payment` WHERE `PaymentID` = '".$PrimaryID."' ");
    $BackupData->execute();


    $Delete = $conn->prepare("DELETE FROM `Payment` WHERE  `PaymentID` = '".$PrimaryID."'  "); 
    $Delete->execute();


    if($Delete){
    Print "300";
    exit();
    }else{
    Print "400";
    }
    
    }