<?php
require_once("auth.php");
include("db.php");
include("clean.php");
//GET DATA FROM AJAX
$action = $_POST['action'];


switch($action){
      //Cash Memo Invoice Delete
      case "CashMemoInvoiceDelete":
        $CashMemoInvoice = clean($_POST['CashMemoInvoice']);

           //Duplicate Check
           $Duplicate = $conn->prepare("SELECT * FROM `CashMemo` WHERE `CashMemoInvoice` = '$CashMemoInvoice'");
           $Duplicate->execute();
       
           if($Duplicate->rowCount() == '0'){
               print 102;
               exit();
           }


        $FetchChallanData = $Duplicate->fetchAll(PDO::FETCH_ASSOC);
        foreach($FetchChallanData AS $FetchChallan) {
            $ChallanID = $FetchChallan['ChallanID'];
            $UpdateChallan = $conn->prepare("UPDATE `Challan` SET `Status` = 'Active' WHERE `ChallanID` = '$ChallanID'");
            $UpdateChallan->execute();
        }
        

        $BackupData = $conn->prepare("INSERT INTO `Delete_CashMemo`(`CashMemoID`, `ChallanID`, `SalesType`, `CustomerName`, `CustomerAddress`, `CustomerID`, `CashMemoInvoice`, `CashMemoDate`, `SupplierID`, `CustomerCategoryID`, `ItemCategoryID`, `PackageSizeID`, `ChallanRate`, `SalesRate`, `SalesQuantity`, `SalesAmount`, `PreviousBalance`, `TotalAmount`, `DiscountPercentage`, `Discount`, `TransactionType`, `WalletID`, `BankID`, `ReceiveName`, `ReceiveAmount`, `TotalDue`, `PerProductProfit`, `TotalProfit`, `CreateDate`, `Cart`, `Remarks`, `EntryID`, `DeleteID`, `DeleteDate`, `Status`)  SELECT  `CashMemoID`, `ChallanID`, `SalesType`, `CustomerName`, `CustomerAddress`, `CustomerID`, `CashMemoInvoice`, `CashMemoDate`, `SupplierID`, `CustomerCategoryID`, `ItemCategoryID`, `PackageSizeID`, `ChallanRate`, `SalesRate`, `SalesQuantity`, `SalesAmount`, `PreviousBalance`, `TotalAmount`, `DiscountPercentage`, `Discount`, `TransactionType`, `WalletID`, `BankID`, `ReceiveName`, `ReceiveAmount`, `TotalDue`, `PerProductProfit`, `TotalProfit`, `CreateDate`, `Cart`, `Remarks`, `EntryID`, '$SessionID', '$CurrentDateTime', `Status` FROM `CashMemo` WHERE `CashMemoInvoice` = '".$CashMemoInvoice."' ");
        $BackupData->execute();

    $Delete = $conn->prepare("DELETE FROM `CashMemo` WHERE  `CashMemoInvoice` = '".$CashMemoInvoice."'  "); 
    $Delete->execute();
    
    if($Delete){
        Print "300";
        exit();
        }else{
        Print "400";
        }

        break;


          //Cash Memo Return Invoice Delete
      case "CashMemoReturnInvoiceDelete":
        $CashMemoReturnInvoice = clean($_POST['CashMemoReturnInvoice']);

           //Duplicate Check
           $Duplicate = $conn->prepare("SELECT * FROM `CashMemoReturn` WHERE `CashMemoReturnInvoice` = '$CashMemoReturnInvoice'");
           $Duplicate->execute();
       
           if($Duplicate->rowCount() == '0'){
               print 102;
               exit();
           }



        $BackupData = $conn->prepare("INSERT INTO `Delete_CashMemoReturn`( `CashMemoReturnID`, `CashMemoID`, `ChallanID`, `SalesType`, `CustomerName`, `CustomerAddress`, `CustomerID`, `CashMemoReturnInvoice`, `CashMemoInvoice`, `CashMemoReturnDate`, `SupplierID`, `CustomerCategoryID`, `ItemCategoryID`, `PackageSizeID`, `SalesRate`, `ReturnRate`, `ReturnQuantity`, `ReturnAmount`, `TotalAmount`, `TransactionType`, `WalletID`, `BankID`, `PaymentName`, `PaymentAmount`, `TotalDue`, `CreateDate`, `Cart`, `Remarks`, `EntryID`, `DeleteID`, `DeleteDate`, `Status`)  SELECT  `CashMemoReturnID`, `CashMemoID`, `ChallanID`, `SalesType`, `CustomerName`, `CustomerAddress`, `CustomerID`, `CashMemoReturnInvoice`, `CashMemoInvoice`, `CashMemoReturnDate`, `SupplierID`, `CustomerCategoryID`, `ItemCategoryID`, `PackageSizeID`, `SalesRate`, `ReturnRate`, `ReturnQuantity`, `ReturnAmount`, `TotalAmount`, `TransactionType`, `WalletID`, `BankID`, `PaymentName`, `PaymentAmount`, `TotalDue`, `CreateDate`, `Cart`, `Remarks`, `EntryID`, '$SessionID', '$CurrentDateTime', `Status` FROM `CashMemoReturn` WHERE `CashMemoReturnInvoice` = '".$CashMemoReturnInvoice."' ");
        $BackupData->execute();

    $Delete = $conn->prepare("DELETE FROM `CashMemoReturn` WHERE  `CashMemoReturnInvoice` = '".$CashMemoReturnInvoice."'  "); 
    $Delete->execute();
    
    if($Delete){
        Print "300";
        exit();
        }else{
        Print "400";
        }

        break;

        
          //Customer Receive Invoice Delete
      case "CustomerReceiveInvoiceDelete":
        $CustomerReceiveInvoice = clean($_POST['CustomerReceiveInvoice']);

          
    $BackupData = $conn->prepare("INSERT INTO `Delete_Receive`(`ReceiveID`, `CustomerReceiveInvoice`, `ReceiveDate`, `CustomerID`, `CustomerBalance`, `TransactionType`, `PaymentName`, `ReceiveType`, `WalletID`, `BankID`, `ReceiveAmount`, `ReceiveDiscount`, `ReceiveNote`, `CreateDate`, `EntryID`, `DeleteID`, `DeleteDate`, `Status`)  SELECT `ReceiveID`, `CustomerReceiveInvoice`, `ReceiveDate`, `CustomerID`, `CustomerBalance`, `TransactionType`, `PaymentName`, `ReceiveType`, `WalletID`, `BankID`, `ReceiveAmount`, `ReceiveDiscount`, `ReceiveNote`, `CreateDate`, `EntryID`, '$SessionID', '$CurrentDateTime', `Status` FROM `Receive` WHERE `CustomerReceiveInvoice` = '".$CustomerReceiveInvoice."' ");
    $BackupData->execute();


    $Delete = $conn->prepare("DELETE FROM `Receive` WHERE  `CustomerReceiveInvoice` = '".$CustomerReceiveInvoice."'  "); 
    $Delete->execute();


    if($Delete){
    Print "300";
    exit();
    }else{
    Print "400";
    }

        break;

        
    //Customer Due Receive Invoice Delete
      case "CustomerDueReceiveInvoiceDelete":
        $CustomerDueReceiveInvoice = clean($_POST['CustomerDueReceiveInvoice']);

          
    $BackupData = $conn->prepare("INSERT INTO `Delete_Receive`(`ReceiveID`, `CustomerDueReceiveInvoice`, `ReceiveDate`, `CustomerID`, `CustomerBalance`, `TransactionType`, `PaymentName`, `ReceiveType`, `WalletID`, `BankID`, `ReceiveAmount`, `ReceiveDiscount`, `ReceiveNote`, `CreateDate`, `EntryID`, `DeleteID`, `DeleteDate`, `Status`)  SELECT `ReceiveID`, `CustomerDueReceiveInvoice`, `ReceiveDate`, `CustomerID`, `CustomerBalance`, `TransactionType`, `PaymentName`, `ReceiveType`, `WalletID`, `BankID`, `ReceiveAmount`, `ReceiveDiscount`, `ReceiveNote`, `CreateDate`, `EntryID`, '$SessionID', '$CurrentDateTime', `Status` FROM `Receive` WHERE `CustomerDueReceiveInvoice` = '".$CustomerDueReceiveInvoice."' ");
    $BackupData->execute();


    $Delete = $conn->prepare("DELETE FROM `Receive` WHERE  `CustomerDueReceiveInvoice` = '".$CustomerDueReceiveInvoice."'  "); 
    $Delete->execute();


    if($Delete){
    Print "300";
    exit();
    }else{
    Print "400";
    }

        break;

        
    //Supplier Payment Invoice Delete
      case "SupplierPaymentInvoiceDelete":
        $SupplierPaymentInvoice = clean($_POST['SupplierPaymentInvoice']);

          
    $BackupData = $conn->prepare("INSERT INTO `Delete_Payment`(`PaymentID`, `SupplierPaymentInvoice`, `PaymentDate`, `SupplierID`, `SupplierBalance`, `TransactionType`, `PaymentName`, `PaymentType`, `WalletID`, `BankID`, `PaymentAmount`, `PaymentDiscount`, `PaymentNote`, `CreateDate`, `EntryID`, `DeleteID`, `DeleteDate`, `Status`)  SELECT `PaymentID`, `SupplierPaymentInvoice`, `PaymentDate`, `SupplierID`, `SupplierBalance`, `TransactionType`, `PaymentName`, `PaymentType`, `WalletID`, `BankID`, `PaymentAmount`, `PaymentDiscount`, `PaymentNote`, `CreateDate`, `EntryID`, '$SessionID', '$CurrentDateTime', `Status` FROM `Payment` WHERE `SupplierPaymentInvoice` = '".$SupplierPaymentInvoice."' ");
    $BackupData->execute();


    $Delete = $conn->prepare("DELETE FROM `Payment` WHERE  `SupplierPaymentInvoice` = '".$SupplierPaymentInvoice."'  "); 
    $Delete->execute();


    if($Delete){
    Print "300";
    exit();
    }else{
    Print "400";
    }

        break;

 
    default:
    print "400";

}
?>