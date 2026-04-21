<?php
include("auth.php");
include("db.php");

switch($ActivePage){

    // Supplier Ledger
        case "SupplierLedgerView":

            $query = $conn->prepare("DROP TABLE IF EXISTS `$TableName`"); 
            $query->execute();
        break;
        // Supplier Ledger Detalis
        case "SupplierLedgerDetalisView":

            $query = $conn->prepare("DROP TABLE IF EXISTS `$TableName`"); 
            $query->execute();
        break;
        
        // Customer Ledger
        case "CustomerLedgerView":
            $query = $conn->prepare("DROP TABLE IF EXISTS `$TableName`"); 
            $query->execute();
        break;

        // Customer Category Wise Due View
        case "CustomerCategoryWiseDueView":
            $query = $conn->prepare("DROP TABLE IF EXISTS `$TableName`"); 
            $query->execute();
        break;
    
        // Customer Ledger Detalis
        case "CustomerLedgerViewDetalisView":
            $query = $conn->prepare("DROP TABLE IF EXISTS `$TableName`"); 
            $query->execute();
        break;

        // Wallet Ledger
        case "WalletLedgerView":
            $query = $conn->prepare("DROP TABLE IF EXISTS `$TableName`"); 
            $query->execute();
        break;

        //Profit/Loss Category Wise Report
        case "ProfitLossReportView":
            $query = $conn->prepare("DROP TABLE IF EXISTS `$TableName`"); 
            $query->execute();
        break;
         
        //Profit/Loss Supplier Category Wise Report
        case "ProfitLossSupplierCategoryReportView":
            $query = $conn->prepare("DROP TABLE IF EXISTS `$TableName`"); 
            $query->execute();
        break;

            
        //Profit/Loss Customer Category Wise Report
        case "ProfitLossCustomerCategoryReportView":
            $query = $conn->prepare("DROP TABLE IF EXISTS `$TableName`"); 
            $query->execute();
        break;


        default: break;
}

?>