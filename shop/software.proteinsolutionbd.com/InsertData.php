<?php
require_once("auth.php");
include("db.php");
include("clean.php");
//GET DATA FROM AJAX
$action = $_POST['action'];

// print_r($_POST);
// exit();

switch($action){

    //Customer Category Insert
    case "SupplierCategory":
    
        $Name = clean($_POST['Name']);
    
        //Duplicate Check
        $Duplicate = $conn->prepare("SELECT * FROM `SupplierCategory` WHERE `Name` = '$Name'");
        $Duplicate->execute();
    
        if($Duplicate->rowCount() >= 1){
            print 102;
            exit();
        }
    
        $SupplierCategoryInsert = $conn->exec("INSERT INTO `SupplierCategory`
        (
            `Name`, 
            `CreateDate`,
            `LastModifiedDate`,
            `EntryID`,
            `UpdateId`,
            `Status`
        ) VALUES (
            '".$Name."',
            '$CurrentDateTime',
            '$CurrentDateTime',
            '$SessionID',
            '$SessionID',
            'Active') ");
    
        if($SupplierCategoryInsert){
            print 101;
            exit();
        }else{
            print 400;
            exit();
        }

        break;
    
        //Item Category Insert
        case "ItemCategory":
        
            $Name = clean($_POST['Name']);
            $SupplierID = clean($_POST['SupplierID']);
        
            //Duplicate Check
            $Duplicate = $conn->prepare("SELECT * FROM `ItemCategory` WHERE `Name` = '$Name' ");
            $Duplicate->execute();
        
            if($Duplicate->rowCount() >= 1){
                print 102;
                exit();
            }
        
            $ItemCategoryInsert = $conn->exec("INSERT INTO `ItemCategory`
            (
                `Name`, 
                `SupplierID`, 
                `CreateDate`,
                `LastModifiedDate`,
                `EntryID`,
                `UpdateId`,
                `Status`
            ) VALUES (
                '".$Name."',
                '".$SupplierID."',
                '$CurrentDateTime',
                '$CurrentDateTime',
                '$SessionID',
                '$SessionID',
                'Active') ");
        
            if($ItemCategoryInsert){
                print 101;
                exit();
            }else{
                print 400;
                exit();
            }
    
        break;

    //Supplier Insert
    case "Supplier":

        $Name = clean($_POST['Name']);
        $ColorCode = clean($_POST['ColorCode']);
        $SupplierCategoryID = clean($_POST['SupplierCategoryID']);
        $MobileNo = clean($_POST['MobileNo']);
        $Address = clean($_POST['Address']);
        $ContactPersonInfo = clean($_POST['ContactPersonInfo']);
        $OpeningBalance = clean($_POST['OpeningBalance']);
    
        //Duplicate Check
        $Duplicate = $conn->prepare("SELECT * FROM `Supplier` WHERE `Name` = '$Name' AND `MobileNo` = '$MobileNo'");
        $Duplicate->execute();
    
        if($Duplicate->rowCount() >= 1){
            print 102;
            exit();
        }
    
        $SupplierInsert = $conn->exec("INSERT INTO `Supplier`
        (
            `Name`, 
            `ColorCode`, 
            `SupplierCategoryID`, 
            `MobileNo`, 
            `Address`, 
            `ContactPersonInfo`, 
            `OpeningBalance`,
            `CreateDate`,
            `LastModifiedDate`,
            `EntryID`,
            `UpdateId`,
            `Status`
        ) VALUES (
            '".$Name."',
            '".$ColorCode."',
            '".$SupplierCategoryID."',
            '".$MobileNo."',
            '".$Address."',
            '".$ContactPersonInfo."',
            '".$OpeningBalance."',
            '$CurrentDateTime',
            '$CurrentDateTime',
            '$SessionID',
            '$SessionID',
            'Active') ");
    
        if($SupplierInsert){
            print 101;
            exit();
        }else{
            print 400;
            exit();
        }
    
    break;
    
    //Customer Category Insert
    case "CustomerCategory":
    
        $Name = clean($_POST['Name']);
    
        //Duplicate Check
        $Duplicate = $conn->prepare("SELECT * FROM `CustomerCategory` WHERE `Name` = '$Name'");
        $Duplicate->execute();
    
        if($Duplicate->rowCount() >= 1){
            print 102;
            exit();
        }
    
        $CustomerCategoryInsert = $conn->exec("INSERT INTO `CustomerCategory`
        (
            `Name`, 
            `CreateDate`,
            `LastModifiedDate`,
            `EntryID`,
            `UpdateId`,
            `Status`
        ) VALUES (
            '".$Name."',
            '$CurrentDateTime',
            '$CurrentDateTime',
            '$SessionID',
            '$SessionID',
            'Active') ");
    
        if($CustomerCategoryInsert){
            print 101;
            exit();
        }else{
            print 400;
            exit();
        }

        break;
    
        
    //Customer Sub Category Insert
    case "CustomerSubCategory":
    
        $Name = clean($_POST['Name']);
    
        //Duplicate Check
        $Duplicate = $conn->prepare("SELECT * FROM `CustomerSubCategory` WHERE `Name` = '$Name'");
        $Duplicate->execute();
    
        if($Duplicate->rowCount() >= 1){
            print 102;
            exit();
        }
    
        $CustomerSubCategoryInsert = $conn->exec("INSERT INTO `CustomerSubCategory`
        (
            `Name`, 
            `CreateDate`,
            `LastModifiedDate`,
            `EntryID`,
            `UpdateId`,
            `Status`
        ) VALUES (
            '".$Name."',
            '$CurrentDateTime',
            '$CurrentDateTime',
            '$SessionID',
            '$SessionID',
            'Active') ");
    
        if($CustomerSubCategoryInsert){
            print 101;
            exit();
        }else{
            print 400;
            exit();
        }

        break;

        //Item Category Insert
        case "ItemCategory":
        
            $Name = clean($_POST['Name']);
            $SupplierID = clean($_POST['SupplierID']);
        
            //Duplicate Check
            $Duplicate = $conn->prepare("SELECT * FROM `ItemCategory` WHERE `Name` = '$Name' AND `SupplierID` = '$SupplierID'");
            $Duplicate->execute();
        
            if($Duplicate->rowCount() >= 1){
                print 102;
                exit();
            }
        
            $ItemCategoryInsert = $conn->exec("INSERT INTO `ItemCategory`
            (
                `Name`, 
                `SupplierID`, 
                `CreateDate`,
                `LastModifiedDate`,
                `EntryID`,
                `UpdateId`,
                `Status`
            ) VALUES (
                '".$Name."',
                '".$SupplierID."',
                '$CurrentDateTime',
                '$CurrentDateTime',
                '$SessionID',
                '$SessionID',
                'Active') ");
        
            if($ItemCategoryInsert){
                print 101;
                exit();
            }else{
                print 400;
                exit();
            }
    
        break;


        
        //Package Size Insert
        case "PackageSize":

            $Thickness = clean($_POST['Thickness']);
            $Size = clean($_POST['Size']);
            $SupplierID = clean($_POST['SupplierID']);
            $ItemCategoryID = clean($_POST['ItemCategoryID']);
            $LowStock = clean($_POST['LowStock']);
            
            //Duplicate Check
            $Duplicate = $conn->prepare("SELECT * FROM `PackageSize` WHERE `Thickness` = '$Thickness' AND `SupplierID` = '$SupplierID' AND `ItemCategoryID` = '$ItemCategoryID' AND `Size` = '$Size' ");
            $Duplicate->execute();
        
            if($Duplicate->rowCount() >= 1){
                print 102;
                exit();
            }
        
            $PackageSizeInsert = $conn->exec("INSERT INTO `PackageSize`
            (
                `Thickness`, 
                `Size`, 
                `SupplierID`, 
                `ItemCategoryID`, 
                `LowStock`, 
                `CreateDate`,
                `LastModifiedDate`,
                `EntryID`,
                `UpdateId`,
                `Status`
            ) VALUES (
                '".$Thickness."',
                '".$Size."',
                '".$SupplierID."',
                '".$ItemCategoryID."',
                '".$LowStock."',
                '$CurrentDateTime',
                '$CurrentDateTime',
                '$SessionID',
                '$SessionID',
                'Active') ");
        
            if($PackageSizeInsert){
                print 101;
                exit();
            }else{
                print 400;
                exit();
            }
    
        break;
        
    //Customer Insert
    case "Customer":

        $Name = clean($_POST['Name']);
        $CustomerCategoryID = clean($_POST['CustomerCategoryID']);
        $CustomerSubCategoryID = clean($_POST['CustomerSubCategoryID']);
        $MobileNo = clean($_POST['MobileNo']);
        $Address = clean($_POST['Address']);
        $CreditLimit = clean($_POST['CreditLimit']);
        $OpeningBalance = clean($_POST['OpeningBalance']);
    
        //Duplicate Check
        $Duplicate = $conn->prepare("SELECT * FROM `Customer` WHERE `Name` = '$Name' AND `MobileNo` = '$MobileNo'");
        $Duplicate->execute();
    
        if($Duplicate->rowCount() >= 1){
            print 102;
            exit();
        }
    
        $CustomerInsert = $conn->exec("INSERT INTO `Customer`
        (
            `Name`, 
            `CustomerCategoryID`, 
            `CustomerSubCategoryID`, 
            `MobileNo`, 
            `Address`, 
            `CreditLimit`, 
            `OpeningBalance`,
            `CreateDate`,
            `LastModifiedDate`,
            `EntryID`,
            `UpdateId`,
            `Status`
        ) VALUES (
            '".$Name."',
            '".$CustomerCategoryID."',
            '".$CustomerSubCategoryID."',
            '".$MobileNo."',
            '".$Address."',
            '".$CreditLimit."',
            '".$OpeningBalance."',
            '$CurrentDateTime',
            '$CurrentDateTime',
            '$SessionID',
            '$SessionID',
            'Active') ");
    
        if($CustomerInsert){
            print 101;
            exit();
        }else{
            print 400;
            exit();
        }
    
    break;

    //Wallet Insert
    case "Wallet":

        $Name = clean($_POST['Name']);
        $OpeningBalance = clean($_POST['OpeningBalance']);
    
        //Duplicate Check
        $Duplicate = $conn->prepare("SELECT * FROM `Wallet` WHERE `Name` = '$Name' ");
        $Duplicate->execute();
    
        if($Duplicate->rowCount() >= 1){
            print 102;
            exit();
        }
    
        $WalletInsert = $conn->exec("INSERT INTO `Wallet`
        (
            `Name`,  
            `OpeningBalance`,
            `CreateDate`,
            `LastModifiedDate`,
            `EntryID`,
            `UpdateId`,
            `Status`
        ) VALUES (
            '".$Name."',
            '".$OpeningBalance."',
            '$CurrentDateTime',
            '$CurrentDateTime',
            '$SessionID',
            '$SessionID',
            'Active') ");
    
        if($WalletInsert){
            print 101;
            exit();
        }else{
            print 400;
            exit();
        }
    
    break;


    
    //Bank Insert
    case "Bank":

        $BranchName = clean($_POST['BranchName']);
        $BankName = clean($_POST['BankName']);
        $AccountName = clean($_POST['AccountName']);
        $AccountNumber = clean($_POST['AccountNumber']);
        $OpeningBalance = clean($_POST['OpeningBalance']);
    
        //Duplicate Check
        $Duplicate = $conn->prepare("SELECT * FROM `Bank` WHERE `BranchName` = '$BranchName' AND `BankName` = '$BankName' AND `AccountName` = '$AccountName' AND `AccountNumber` = '$AccountNumber' ");
        $Duplicate->execute();
    
        if($Duplicate->rowCount() >= 1){
            print 102;
            exit();
        }
    
        $BankInsert = $conn->exec("INSERT INTO `Bank`
        (
            `BranchName`,  
            `BankName`,
            `AccountName`,
            `AccountNumber`,
            `OpeningBalance`,
            `CreateDate`,
            `LastModifiedDate`,
            `EntryID`,
            `UpdateId`,
            `Status`
        ) VALUES (
            '".$BranchName."',
            '".$BankName."',
            '".$AccountName."',
            '".$AccountNumber."',
            '".$OpeningBalance."',
            '$CurrentDateTime',
            '$CurrentDateTime',
            '$SessionID',
            '$SessionID',
            'Active') ");
    
        if($BankInsert){
            print 101;
            exit();
        }else{
            print 400;
            exit();
        }
    
    break;


    
    //Others Account Insert
    case "OthersAccount":

        $SectorName = clean($_POST['SectorName']);
        $OthersAccountName = clean($_POST['OthersAccountName']);
        $MobileNo = clean($_POST['MobileNo']);
        $CreditLimit = clean($_POST['CreditLimit']);
        $Category = clean($_POST['Category']);
        $OpeningBalance = clean($_POST['OpeningBalance']);
    
        //Duplicate Check
        $Duplicate = $conn->prepare("SELECT * FROM `OthersAccount` WHERE `SectorName` = '$SectorName' AND `OthersAccountName` = '$OthersAccountName' ");
        $Duplicate->execute();
    
        if($Duplicate->rowCount() >= 1){
            print 102;
            exit();
        }
    
        $OthersAccountInsert = $conn->exec("INSERT INTO `OthersAccount`
        (
            `SectorName`,  
            `OthersAccountName`,
            `MobileNo`,
            `CreditLimit`,
            `Category`,
            `OpeningBalance`,
            `CreateDate`,
            `LastModifiedDate`,
            `EntryID`,
            `UpdateId`,
            `Status`
        ) VALUES (
            '".$SectorName."',
            '".$OthersAccountName."',
            '".$MobileNo."',
            '".$CreditLimit."',
            '".$Category."',
            '".$OpeningBalance."',
            '$CurrentDateTime',
            '$CurrentDateTime',
            '$SessionID',
            '$SessionID',
            'Active') ");
    
        if($OthersAccountInsert){
            print 101;
            exit();
        }else{
            print 400;
            exit();
        }
    
    break;


    default:
    print "400";
}


?>