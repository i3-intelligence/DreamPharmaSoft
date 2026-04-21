<?php
require_once("auth.php");
include("db.php");
include("clean.php");
//GET DATA FROM AJAX
$action = $_POST['action'];

// print_r($_POST);
// exit();

switch($action){

    //Supplier Payment Insert
    case "SupplierPayment":

        $SupplierID = clean($_POST['SupplierID']);
        $SupplierBalance = clean($_POST['SupplierBalance']);
        $TransactionType = clean($_POST['TransactionType']);
        $WalletID = clean($_POST['WalletID']);
        $BankID = clean($_POST['BankID']);
        $PaymentName = clean($_POST['PaymentName']);
        $PaymentAmount = clean($_POST['PaymentAmount']);
        $PaymentDiscount = clean($_POST['PaymentDiscount']);
        $PaymentNote = clean($_POST['PaymentNote']);
        $PaymentDate = clean($_POST['PaymentDate']);
        $SupplierPaymentInvoice = clean($_POST['SupplierPaymentInvoice']);
        $PaymentType ="Supplier Payment";
        
        $SupplierPaymentInsert = $conn->prepare("INSERT INTO `Payment`(
             `EntryID`,
             `SupplierID`, 
             `SupplierBalance`, 
             `TransactionType`, 
             `WalletID`, 
             `BankID`, 
             `PaymentName`, 
             `PaymentAmount`, 
             `PaymentDiscount`, 
             `PaymentNote`, 
             `PaymentDate`, 
             `SupplierPaymentInvoice`,
             `PaymentType`,
             `CreateDate`
             ) 
             VALUES 
             (
                '$SessionID',
                '$SupplierID',
                '$SupplierBalance',
                '$TransactionType',
                '$WalletID',
                '$BankID',
                '$PaymentName',
                '$PaymentAmount',
                '$PaymentDiscount',
                '$PaymentNote',
                '$PaymentDate',
                '$SupplierPaymentInvoice',
                '$PaymentType',
                '$CurrentDateTime'
                ) ");

        if($SupplierPaymentInsert->execute()){
            echo "100";
        }else{
            echo "400";
        }

    break;

    default:
    print "400";


    }