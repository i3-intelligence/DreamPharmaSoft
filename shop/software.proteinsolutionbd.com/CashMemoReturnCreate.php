<?php
require_once("auth.php");
include("db.php");
include("clean.php");
// echo "<pre>".print_r($_POST,true)."</pre>";

if(!empty($_POST['CashMemoReturnInvoice'])){

$CashMemoReturnInvoice = clean($_POST['CashMemoReturnInvoice']);
$CashMemoReturnDate = clean($_POST['CashMemoReturnDate']);
$TotalAmount = clean($_POST['TotalAmount']);
$TransactionType = clean($_POST['TransactionType']);
$WalletID = clean($_POST['WalletID']);
$BankID = clean($_POST['BankID']);
$PaymentName = clean($_POST['PaymentName']);
$PaymentAmount = clean($_POST['PaymentAmount']);
$TotalDue = (clean($_POST['TotalAmount']) - clean($_POST['PaymentAmount']));
$Remarks = clean($_POST['Remarks']);



        //Cart Check
        $CheckCart = $conn->prepare("SELECT * FROM `CashMemoReturn` WHERE `EntryID` = '$SessionID' AND `Cart` = '' ");
        $CheckCart->execute();
        $CountCart = $CheckCart->rowCount();
    
        if($CountCart <='0'){
            print "404";
            exit();
        }


        $CashMemoReturnUpdate = $conn->prepare("UPDATE `CashMemoReturn` SET 
                    `CashMemoReturnInvoice` = '$CashMemoReturnInvoice',
                    `CashMemoReturnDate` = '$CashMemoReturnDate',
                    `TotalAmount` = '$TotalAmount',
                    `TransactionType` = '$TransactionType',
                    `WalletID` = '$WalletID',
                    `BankID` = '$BankID',
                    `PaymentName` = '$PaymentName',
                    `PaymentAmount` = '$PaymentAmount',
                    `TotalDue` = '$TotalDue',
                    `Remarks` = '$Remarks',
                    `Cart` = 'Yes' 
                    WHERE `EntryID` = '$SessionID' AND `Cart` = '' ");
        $CashMemoReturnUpdate->execute();

        if($CashMemoReturnUpdate){
            print "200";
            exit();
        } //clsoe qry if brace
        else{
            print "400";
            exit();
        }

}

?>