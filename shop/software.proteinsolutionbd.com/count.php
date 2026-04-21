<?php
require_once("auth.php");
include("db.php"); 
//Active Supplier Category Count
$QuerySupplierCategoryCount = $conn->prepare("SELECT COUNT(`SupplierCategoryID`) AS `Count` FROM `SupplierCategory` WHERE `Status` = 'Active' "); 
$QuerySupplierCategoryCount->execute();
$FetchSupplierCategoryCount = $QuerySupplierCategoryCount->fetch(PDO::FETCH_ASSOC);
$ActiveSupplierCategory = $FetchSupplierCategoryCount['Count'];

//Active Supplier Count
$QuerySupplierCount = $conn->prepare("SELECT COUNT(`SupplierID`) AS `Count` FROM `Supplier` WHERE `Status` = 'Active' "); 
$QuerySupplierCount->execute();
$FetchSupplierCount = $QuerySupplierCount->fetch(PDO::FETCH_ASSOC);
$ActiveSupplier = $FetchSupplierCount['Count'];

//Active Customer Count
$QueryCustomerCount = $conn->prepare("SELECT COUNT(`CustomerID`) AS `Count` FROM `Customer` WHERE `Status` = 'Active' "); 
$QueryCustomerCount->execute();
$FetchCustomerCount = $QueryCustomerCount->fetch(PDO::FETCH_ASSOC);
$ActiveCustomer = $FetchCustomerCount['Count'];

//Active Customer Category Count
$QueryCustomerCategoryCount = $conn->prepare("SELECT COUNT(`CustomerCategoryID`) AS `Count` FROM `CustomerCategory` WHERE `Status` = 'Active' "); 
$QueryCustomerCategoryCount->execute();
$FetchCustomerCategoryCount = $QueryCustomerCategoryCount->fetch(PDO::FETCH_ASSOC);
$ActiveCustomerCategory = $FetchCustomerCategoryCount['Count'];

//Active Sub Customer Category Count
$QueryCustomerSubCategoryCount = $conn->prepare("SELECT COUNT(`CustomerSubCategoryID`) AS `Count` FROM `CustomerSubCategory` WHERE `Status` = 'Active' "); 
$QueryCustomerSubCategoryCount->execute();
$FetchCustomerSubCategoryCount = $QueryCustomerSubCategoryCount->fetch(PDO::FETCH_ASSOC);
$ActiveSubCustomerCategory = $FetchCustomerSubCategoryCount['Count'];

//Active Item Category Count
$QueryItemCategoryCount = $conn->prepare("SELECT COUNT(`ItemCategoryID`) AS `Count` FROM `ItemCategory` WHERE `Status` = 'Active' "); 
$QueryItemCategoryCount->execute();
$FetchItemCategoryCount = $QueryItemCategoryCount->fetch(PDO::FETCH_ASSOC);
$ActiveItemCategory = $FetchItemCategoryCount['Count'];

//Active Package Size Count
$QueryPackageSizeCount = $conn->prepare("SELECT COUNT(`PackageSizeID`) AS `Count` FROM `PackageSize` WHERE `Status` = 'Active' "); 
$QueryPackageSizeCount->execute();
$FetchPackageSizeCount = $QueryPackageSizeCount->fetch(PDO::FETCH_ASSOC);
$ActivePackageSize = $FetchPackageSizeCount['Count'];


//Active Purchase Rate Count
$QueryPurchaseRateCount = $conn->prepare("SELECT COUNT(`PurchaseRateID`) AS `Count` FROM `PurchaseRate` WHERE `Status` = 'Active' "); 
$QueryPurchaseRateCount->execute();
$FetchPurchaseRateCount = $QueryPurchaseRateCount->fetch(PDO::FETCH_ASSOC);
$ActivePurchaseRate = $FetchPurchaseRateCount['Count'];

//Active Sales Rate Count
$QuerySalesRateCount = $conn->prepare("SELECT COUNT(`SalesRateID`) AS `Count` FROM `SalesRate` WHERE `Status` = 'Active' "); 
$QuerySalesRateCount->execute();
$FetchSalesRateCount = $QuerySalesRateCount->fetch(PDO::FETCH_ASSOC);
$ActiveSalesRate = $FetchSalesRateCount['Count'];

//Active Purchase Rate Count
$QueryPurchaseRateCount = $conn->prepare("SELECT COUNT(`PurchaseRateID`) AS `Count` FROM `PurchaseRate` WHERE `Status` = 'Active' "); 
$QueryPurchaseRateCount->execute();
$FetchPurchaseRateCount = $QueryPurchaseRateCount->fetch(PDO::FETCH_ASSOC);
$ActivePurchaseRate = $FetchPurchaseRateCount['Count'];

//Active Wallet Count
$QueryWalletCount = $conn->prepare("SELECT COUNT(`WalletID`) AS `Count` FROM `Wallet` WHERE `Status` = 'Active' "); 
$QueryWalletCount->execute();
$FetchWalletCount = $QueryWalletCount->fetch(PDO::FETCH_ASSOC);
$ActiveWallet = $FetchWalletCount['Count'];		

//Active Bank Count
$QueryBankCount = $conn->prepare("SELECT COUNT(`BankID`) AS `Count` FROM `Bank` WHERE `Status` = 'Active' "); 
$QueryBankCount->execute();
$FetchBankCount = $QueryBankCount->fetch(PDO::FETCH_ASSOC);
$ActiveBank = $FetchBankCount['Count'];		

//Active Others Account Count
$QueryOthersAccountCount = $conn->prepare("SELECT COUNT(`OthersAccountID`) AS `Count` FROM `OthersAccount` WHERE `Status` = 'Active' "); 
$QueryOthersAccountCount->execute();
$FetchOthersAccountCount = $QueryOthersAccountCount->fetch(PDO::FETCH_ASSOC);
$ActiveOthersAccount = $FetchOthersAccountCount['Count'];	


//Total Customer Due Receive Invoice Count
$QueryCustomerDueReceiveInvoiceCount = $conn->prepare("SELECT COUNT(`CustomerDueReceiveInvoice`) AS `Count` FROM `Receive` WHERE `ReceiveType` = 'Customer Due Receive' "); 
$QueryCustomerDueReceiveInvoiceCount->execute();
$FetchCustomerDueReceiveInvoiceCount = $QueryCustomerDueReceiveInvoiceCount->fetch(PDO::FETCH_ASSOC);
$ActiveCustomerDueReceiveInvoice = $FetchCustomerDueReceiveInvoiceCount['Count'];	

//Total Customer Receive Invoice Count
$QueryCustomerReceiveInvoiceCount = $conn->prepare("SELECT COUNT(`CustomerReceiveInvoice`) AS `Count` FROM `Receive` WHERE `ReceiveType` = 'Customer Receive' "); 
$QueryCustomerReceiveInvoiceCount->execute();
$FetchCustomerReceiveInvoiceCount = $QueryCustomerReceiveInvoiceCount->fetch(PDO::FETCH_ASSOC);
$ActiveCustomerReceiveInvoice = $FetchCustomerReceiveInvoiceCount['Count'];	

//Total Other Receive Invoice Count
$QueryOtherReceiveInvoiceCount = $conn->prepare("SELECT COUNT(`OtherReceiveInvoice`) AS `Count` FROM `Receive` WHERE `ReceiveType` = 'Other Receive' "); 
$QueryOtherReceiveInvoiceCount->execute();
$FetchOtherReceiveInvoiceCount = $QueryOtherReceiveInvoiceCount->fetch(PDO::FETCH_ASSOC);
$ActiveOtherReceiveInvoice = $FetchOtherReceiveInvoiceCount['Count'];	

//Total Supplier Payment Invoice Count
$QuerySupplierPaymentInvoiceCount = $conn->prepare("SELECT COUNT(`SupplierPaymentInvoice`) AS `Count` FROM `Payment` WHERE `PaymentType` = 'Supplier Payment' "); 
$QuerySupplierPaymentInvoiceCount->execute();
$FetchSupplierPaymentInvoiceCount = $QuerySupplierPaymentInvoiceCount->fetch(PDO::FETCH_ASSOC);
$ActiveSupplierPaymentInvoice = $FetchSupplierPaymentInvoiceCount['Count'];	



//Total Challan Invoice Count
$QueryChallanInvoiceCount = $conn->prepare("SELECT COUNT(DISTINCT `ChallanInvoice`) AS `Count` FROM `Challan` WHERE `Cart` = 'Yes' "); 
$QueryChallanInvoiceCount->execute();
$FetchChallanInvoiceCount = $QueryChallanInvoiceCount->fetch(PDO::FETCH_ASSOC);
$ActiveChallanInvoice = $FetchChallanInvoiceCount['Count'];	

//Total Cash Memo Count
$QueryCashMemoInvoiceCount = $conn->prepare("SELECT COUNT(DISTINCT `CashMemoInvoice`) AS `Count` FROM `CashMemo` WHERE `Cart` = 'Yes' "); 
$QueryCashMemoInvoiceCount->execute();
$FetchCashMemoInvoiceCount = $QueryCashMemoInvoiceCount->fetch(PDO::FETCH_ASSOC);
$ActiveCashMemoInvoice = $FetchCashMemoInvoiceCount['Count'];	


//Total Cash Memo Return Count
$QueryCashMemoReturnInvoiceCount = $conn->prepare("SELECT COUNT(DISTINCT `CashMemoReturnInvoice`) AS `Count` FROM `CashMemoReturn` WHERE `Cart` = 'Yes' "); 
$QueryCashMemoReturnInvoiceCount->execute();
$FetchCashMemoReturnInvoiceCount = $QueryCashMemoReturnInvoiceCount->fetch(PDO::FETCH_ASSOC);
$ActiveCashMemoReturnInvoice = $FetchCashMemoReturnInvoiceCount['Count'];	

//Total Challan Return Count
$QueryChallanReturnInvoiceCount = $conn->prepare("SELECT COUNT(DISTINCT `ChallanReturnInvoice`) AS `Count` FROM `ChallanReturn` WHERE `Cart` = 'Yes' "); 
$QueryChallanReturnInvoiceCount->execute();
$FetchChallanReturnInvoiceCount = $QueryChallanReturnInvoiceCount->fetch(PDO::FETCH_ASSOC);
$ActiveChallanReturnInvoice = $FetchChallanReturnInvoiceCount['Count'];	
?>