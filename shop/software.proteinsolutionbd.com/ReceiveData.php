<?php
require_once("auth.php");
include("db.php");
include("clean.php");
//GET DATA FROM AJAX
$action = $_POST['action'];

// print_r($_POST);
// exit();

switch($action){

    //Customer Due Receive Insert
    case "CustomerDueReceive":

        $CustomerID = clean($_POST['CustomerID']);
        $CustomerBalance = clean($_POST['CustomerBalance']);
        $TransactionType = clean($_POST['TransactionType']);
        $WalletID = clean($_POST['WalletID']);
        $BankID = clean($_POST['BankID']);
        $PaymentName = clean($_POST['PaymentName']);
        $ReceiveAmount = clean($_POST['ReceiveAmount']);
        $ReceiveDiscount = clean($_POST['ReceiveDiscount']);
        $ReceiveNote = clean($_POST['ReceiveNote']);
        $ReceiveDate = clean($_POST['ReceiveDate']);
        $CustomerDueReceiveInvoice = clean($_POST['CustomerDueReceiveInvoice']);
        $ReceiveType ="Customer Due Receive";
        
        $CustomerDueReceiveInsert = $conn->prepare("INSERT INTO `Receive`(
            `EntryID`,
             `CustomerID`, 
             `CustomerBalance`, 
             `TransactionType`, 
             `WalletID`, 
             `BankID`, 
             `PaymentName`, 
             `ReceiveAmount`, 
             `ReceiveDiscount`, 
             `ReceiveNote`, 
             `ReceiveDate`, 
             `CustomerDueReceiveInvoice`,
             `ReceiveType`,
            `CreateDate`
             ) 
             VALUES 
             (
                '$SessionID',
                '$CustomerID',
                '$CustomerBalance',
                '$TransactionType',
                '$WalletID',
                '$BankID',
                '$PaymentName',
                '$ReceiveAmount',
                '$ReceiveDiscount',
                '$ReceiveNote',
                '$ReceiveDate',
                '$CustomerDueReceiveInvoice',
                '$ReceiveType',
                '$CurrentDateTime'
                ) ");

        if($CustomerDueReceiveInsert->execute()){
            echo "100";
        }else{
            echo "400";
        }


    break;

    
    //Customer Receive Insert
    case "CustomerReceive":

        $CustomerID = clean($_POST['CustomerID']);
        $CustomerBalance = clean($_POST['CustomerBalance']);
        $TransactionType = clean($_POST['TransactionType']);
        $WalletID = clean($_POST['WalletID']);
        $BankID = clean($_POST['BankID']);
        $PaymentName = clean($_POST['PaymentName']);
        $ReceiveAmount = clean($_POST['ReceiveAmount']);
        $ReceiveDiscount = clean($_POST['ReceiveDiscount']);
        $ReceiveNote = clean($_POST['ReceiveNote']);
        $ReceiveDate = clean($_POST['ReceiveDate']);
        $CustomerReceiveInvoice = clean($_POST['CustomerReceiveInvoice']);
        $ReceiveType ="Customer Receive";
        
        $CustomerReceiveInsert = $conn->prepare("INSERT INTO `Receive`(
            `EntryID`,
             `CustomerID`, 
             `CustomerBalance`, 
             `TransactionType`, 
             `WalletID`, 
             `BankID`, 
             `PaymentName`, 
             `ReceiveAmount`, 
             `ReceiveDiscount`, 
             `ReceiveNote`, 
             `ReceiveDate`, 
             `CustomerReceiveInvoice`,
             `ReceiveType`,
            `CreateDate`
             ) 
             VALUES 
             (
                '$SessionID',
                '$CustomerID',
                '$CustomerBalance',
                '$TransactionType',
                '$WalletID',
                '$BankID',
                '$PaymentName',
                '$ReceiveAmount',
                '$ReceiveDiscount',
                '$ReceiveNote',
                '$ReceiveDate',
                '$CustomerReceiveInvoice',
                '$ReceiveType',
                '$CurrentDateTime'
                ) ");

        if($CustomerReceiveInsert->execute()){
            echo "100";
        }else{
            echo "400";
        }


    break;

    default:
    print "400";


    }