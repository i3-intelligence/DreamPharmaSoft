<?php
require_once("auth.php");
include("db.php");
include("clean.php");

if(!empty($_POST['CashMemoInvoice'])){

$SalesType = clean($_POST['SalesType']);
$CashMemoInvoice = clean($_POST['CashMemoInvoice']);
$CashMemoDate = clean($_POST['CashMemoDate']);
$CustomerCategoryID = clean($_POST['CustomerCategoryID']);

if(!empty($_POST['CustomerID'])){
    $CustomerID = clean($_POST['CustomerID']);
}else{
    $CustomerID = '0';
}
if(!empty($_POST['CustomerName'])){
    $CustomerName = clean($_POST['CustomerName']);
}else{
    $CustomerName = '';
}
if(!empty($_POST['CustomerAddress'])){
    $CustomerAddress = clean($_POST['CustomerAddress']);
}else{
    $CustomerAddress = '';
}

$PreviousBalance = clean($_POST['PreviousBalance']);
$TotalAmount = clean($_POST['TotalAmount']);
$DiscountPercentage = clean($_POST['DiscountPercentage']);
$Discount = clean($_POST['Discount']);
$TransactionType = clean($_POST['TransactionType']);
$WalletID = clean($_POST['WalletID']);
$BankID = clean($_POST['BankID']);
$ReceiveName = clean($_POST['ReceiveName']);
$ReceiveAmount = clean($_POST['ReceiveAmount']);
$TotalDue = (clean($_POST['PreviousBalance']) + clean($_POST['TotalAmount']) - ( clean($_POST['ReceiveAmount']) + clean($_POST['Discount'])));
$Remarks = clean($_POST['Remarks']);



        //Cart Check
        $CheckCart = $conn->prepare("SELECT * FROM `CashMemo` WHERE `EntryID` = '$SessionID' AND `Cart` = '' ");
        $CheckCart->execute();
        $CountCart = $CheckCart->rowCount();
    
        if($CountCart <='0'){
            print "404";
            exit();
        }

        
        //Cash Customer Check
        if($CustomerID == '0'){

            if($TransactionType =='Due'){
                print "408";
                exit();
            }

            if($TotalDue !='0'){
                print "407";
                exit();
            }

            if($ReceiveAmount =='0'){
                print "407";
                exit();
            }

        }else{

            //Due Customer Credit Limit Check

                $CustomerCreditLimit = $conn->prepare("SELECT * FROM `Customer` WHERE `CustomerID` = '$CustomerID' AND `Status` = 'Active' ");
                $CustomerCreditLimit->execute();
                $CustomerCreditLimitFetch = $CustomerCreditLimit->fetch(PDO::FETCH_ASSOC);
                $CustomerCreditLimitAmount = $CustomerCreditLimitFetch['CreditLimit'];

                if($CustomerCreditLimitAmount != '0' && ($CustomerCreditLimitAmount < $TotalDue)){
                    print "406";
                    exit();
                }
            

        }
    
        $CashMemoUpdate = $conn->prepare("UPDATE `CashMemo` SET 
                    `SalesType` = '$SalesType',
                    `CashMemoInvoice` = '$CashMemoInvoice',
                    `CashMemoDate` = '$CurrentDate',
                    `CustomerCategoryID` = '$CustomerCategoryID',
                    `CustomerID` = '$CustomerID',
                    `CustomerName` = '$CustomerName',
                    `CustomerAddress` = '$CustomerAddress',
                    `PreviousBalance` = '$PreviousBalance',
                    `TotalAmount` = '$TotalAmount',
                    `DiscountPercentage` = '$DiscountPercentage',
                    `Discount` = '$Discount',
                    `TransactionType` = '$TransactionType',
                    `WalletID` = '$WalletID',
                    `BankID` = '$BankID',
                    `ReceiveName` = '$ReceiveName',
                    `ReceiveAmount` = '$ReceiveAmount',
                    `TotalDue` = '$TotalDue',
                    `Remarks` = '$Remarks',
                    `Cart` = 'Yes' 
                    WHERE `EntryID` = '$SessionID' AND `Cart` = ''AND `CashMemoInvoice` = '' ");
        $CashMemoUpdate->execute();

        if($CashMemoUpdate){
            print "200";
            exit();
        } //clsoe qry if brace
        else{
            print "400";
            exit();
        }

}

?>