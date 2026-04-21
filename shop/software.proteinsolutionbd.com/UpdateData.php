<?php
require_once("auth.php");
include("db.php");
include("clean.php");
//GET DATA FROM AJAX
$action = $_POST['action'];

switch($action){

// Supplier Category Update
case "SupplierCategory":
    $UpdateId = clean($_POST['UpdateId']);
    $Name = clean($_POST['Name']);
    $Status = clean($_POST['Status']);

     //Duplicate Check
    $Duplicate = $conn->prepare("SELECT * FROM `SupplierCategory` WHERE `Name` = '$Name' AND `SupplierCategoryID` != '$UpdateId' ");
    $Duplicate->execute();

    if($Duplicate->rowCount() >= 1){
        print 102;
        exit();
    }


    $SupplierCategoryUpdate = $conn->prepare("UPDATE `SupplierCategory` SET 
            `Name`='".$Name."',
            `LastModifiedDate`='".$CurrentDateTime."',
            `UpdateId`='".$SessionID."',
            `Status`='".$Status."'
            WHERE `SupplierCategoryID` = '".$UpdateId."' ");
    $SupplierCategoryUpdate->execute();

    if($SupplierCategoryUpdate){
        print 200;
        exit();
    }else{
        print 400;
        exit();
    }
      
break;


// Supplier Update
case "Supplier":
    $UpdateId = clean($_POST['UpdateId']);
    $Name = clean($_POST['Name']);
    $ColorCode = clean($_POST['ColorCode']);
    $SupplierCategoryID = clean($_POST['SupplierCategoryID']);
    $MobileNo = clean($_POST['MobileNo']);
    $Address = clean($_POST['Address']);
    $ContactPersonInfo = clean($_POST['ContactPersonInfo']);
    $OpeningBalance = clean($_POST['OpeningBalance']);
    $Status = clean($_POST['Status']);

     //Duplicate Check
    $Duplicate = $conn->prepare("SELECT * FROM `Supplier` WHERE `Name` = '$Name' AND `MobileNo` = '$MobileNo' AND `SupplierID` != '$UpdateId' ");
    $Duplicate->execute();

    if($Duplicate->rowCount() >= 1){
        print 102;
        exit();
    }


    $SupplierUpdate = $conn->prepare("UPDATE `Supplier` SET 
            `Name`='".$Name."',
            `ColorCode`='".$ColorCode."',
            `SupplierCategoryID`='".$SupplierCategoryID."',
            `MobileNo`='".$MobileNo."',
            `Address`='".$Address."',
            `ContactPersonInfo`='".$ContactPersonInfo."',
            `OpeningBalance`='".$OpeningBalance."',
            `LastModifiedDate`='".$CurrentDateTime."',
            `UpdateId`='".$SessionID."',
            `Status`='".$Status."'
            WHERE `SupplierID` = '".$UpdateId."' ");
    $SupplierUpdate->execute();

    if($SupplierUpdate){
        print 200;
        exit();
    }else{
        print 400;
        exit();
    }
      
break;

// Customer Category Update
case "CustomerCategory":
    $UpdateId = clean($_POST['UpdateId']);
    $Name = clean($_POST['Name']);
    $Status = clean($_POST['Status']);

     //Duplicate Check
    $Duplicate = $conn->prepare("SELECT * FROM `CustomerCategory` WHERE `Name` = '$Name' AND `CustomerCategoryID` != '$UpdateId' ");
    $Duplicate->execute();

    if($Duplicate->rowCount() >= 1){
        print 102;
        exit();
    }


    $CustomerCategoryUpdate = $conn->prepare("UPDATE `CustomerCategory` SET 
            `Name`='".$Name."',
            `LastModifiedDate`='".$CurrentDateTime."',
            `UpdateId`='".$SessionID."',
            `Status`='".$Status."'
            WHERE `CustomerCategoryID` = '".$UpdateId."' ");
    $CustomerCategoryUpdate->execute();

    if($CustomerCategoryUpdate){
        print 200;
        exit();
    }else{
        print 400;
        exit();
    }
      
break;


// Customer Sub Category Update
case "CustomerSubCategory":
    $UpdateId = clean($_POST['UpdateId']);
    $Name = clean($_POST['Name']);
    $Status = clean($_POST['Status']);

     //Duplicate Check
    $Duplicate = $conn->prepare("SELECT * FROM `CustomerSubCategory` WHERE `Name` = '$Name' AND `CustomerSubCategoryID` != '$UpdateId' ");
    $Duplicate->execute();

    if($Duplicate->rowCount() >= 1){
        print 102;
        exit();
    }


    $CustomerSubCategoryUpdate = $conn->prepare("UPDATE `CustomerSubCategory` SET 
            `Name`='".$Name."',
            `LastModifiedDate`='".$CurrentDateTime."',
            `UpdateId`='".$SessionID."',
            `Status`='".$Status."'
            WHERE `CustomerSubCategoryID` = '".$UpdateId."' ");
    $CustomerSubCategoryUpdate->execute();

    if($CustomerSubCategoryUpdate){
        print 200;
        exit();
    }else{
        print 400;
        exit();
    }
      
break;



// Item Category Update
case "ItemCategory":
    $UpdateId = clean($_POST['UpdateId']);
    $Name = clean($_POST['Name']);
    $SupplierID = clean($_POST['SupplierID']);
    $Status = clean($_POST['Status']);

     //Duplicate Check
    $Duplicate = $conn->prepare("SELECT * FROM `ItemCategory` WHERE `Name` = '$Name' AND `ItemCategoryID` != '$UpdateId' ");
    $Duplicate->execute();

    if($Duplicate->rowCount() >= 1){
        print 102;
        exit();
    }


    $ItemCategoryUpdate = $conn->prepare("UPDATE `ItemCategory` SET 
            `Name`='".$Name."',
            `SupplierID`='".$SupplierID."',
            `LastModifiedDate`='".$CurrentDateTime."',
            `UpdateId`='".$SessionID."',
            `Status`='".$Status."'
            WHERE `ItemCategoryID` = '".$UpdateId."' ");
    $ItemCategoryUpdate->execute();

    if($ItemCategoryUpdate){
        print 200;
        exit();
    }else{
        print 400;
        exit();
    }
      
break;

// Package Size Update
case "PackageSize":
    $UpdateId = clean($_POST['UpdateId']);
    $Thickness = clean($_POST['Thickness']);
    $Size = clean($_POST['Size']);
    $SupplierID = clean($_POST['SupplierID']);
    $ItemCategoryID = clean($_POST['ItemCategoryID']);
    $LowStock = clean($_POST['LowStock']);
    $Status = clean($_POST['Status']);
    
     //Duplicate Check
     $Duplicate = $conn->prepare("SELECT * FROM `PackageSize` WHERE `Thickness` = '$Thickness' AND  `SupplierID` = '$SupplierID' AND`ItemCategoryID` = '$ItemCategoryID' AND `Size` = '$Size'  AND  `PackageSizeID` != '$UpdateId'  ");
     $Duplicate->execute();

     if($Duplicate->rowCount() >= 1){
         print 102;
         exit();
     }


    $PackageSizeUpdate = $conn->prepare("UPDATE `PackageSize` SET 
            `Thickness`='".$Thickness."',
            `Size`='".$Size."',
            `SupplierID`='".$SupplierID."',
            `ItemCategoryID`='".$ItemCategoryID."',
            `LowStock`='".$LowStock."',
            `LastModifiedDate`='".$CurrentDateTime."',
            `UpdateId`='".$SessionID."',
            `Status`='".$Status."'
            WHERE `PackageSizeID` = '".$UpdateId."' ");
    $PackageSizeUpdate->execute();

    if($PackageSizeUpdate){
        print 200;
        exit();
    }else{
        print 400;
        exit();
    }
      
break;



// Customer Update
case "Customer":
    $UpdateId = clean($_POST['UpdateId']);
    $Name = clean($_POST['Name']);
    $CustomerSubCategoryID = clean($_POST['CustomerSubCategoryID']);
    $CustomerCategoryID = clean($_POST['CustomerCategoryID']);
    $MobileNo = clean($_POST['MobileNo']);
    $Address = clean($_POST['Address']);
    $CreditLimit = clean($_POST['CreditLimit']);
    $OpeningBalance = clean($_POST['OpeningBalance']);
    $Status = clean($_POST['Status']);

     //Duplicate Check
    $Duplicate = $conn->prepare("SELECT * FROM `Customer` WHERE `Name` = '$Name' AND `MobileNo` = '$MobileNo' AND `CustomerID` != '$UpdateId' ");
    $Duplicate->execute();

    if($Duplicate->rowCount() >= 1){
        print 102;
        exit();
    }


    $CustomerUpdate = $conn->prepare("UPDATE `Customer` SET 
            `Name`='".$Name."',
            `CustomerCategoryID`='".$CustomerCategoryID."',
            `CustomerSubCategoryID`='".$CustomerSubCategoryID."',
            `MobileNo`='".$MobileNo."',
            `Address`='".$Address."',
            `CreditLimit`='".$CreditLimit."',
            `OpeningBalance`='".$OpeningBalance."',
            `LastModifiedDate`='".$CurrentDateTime."',
            `UpdateId`='".$SessionID."',
            `Status`='".$Status."'
            WHERE `CustomerID` = '".$UpdateId."' ");
    $CustomerUpdate->execute();

    if($CustomerUpdate){
        print 200;
        exit();
    }else{
        print 400;
        exit();
    }
      
break;

//Wallet Update
case "Wallet":
    $UpdateId = clean($_POST['UpdateId']);
    $Name = clean($_POST['Name']);
    $OpeningBalance  = clean($_POST['OpeningBalance']);
    $Status = clean($_POST['Status']);

     //Duplicate Check
    $Duplicate = $conn->prepare("SELECT * FROM `Wallet` WHERE `Name` = '$Name' AND `WalletID` != '$UpdateId' ");
    $Duplicate->execute();

    if($Duplicate->rowCount() >= 1){
        print 102;
        exit();
    }


    $WalletUpdate = $conn->prepare("UPDATE `Wallet` SET 
            `Name`='".$Name."',
            `OpeningBalance`='".$OpeningBalance."',
            `LastModifiedDate`='".$CurrentDateTime."',
            `UpdateId`='".$SessionID."',
            `Status`='".$Status."'
            WHERE `WalletID` = '".$UpdateId."' ");
            $WalletUpdate->execute();

    if($WalletUpdate){
        print 200;
        exit();
    }else{
        print 400;
        exit();
    }
      
break;


//Bank Update
case "Bank":
    $UpdateId = clean($_POST['UpdateId']);
    $BranchName = clean($_POST['BranchName']);
    $BankName = clean($_POST['BankName']);
    $AccountName = clean($_POST['AccountName']);
    $AccountNumber = clean($_POST['AccountNumber']);
    $OpeningBalance  = clean($_POST['OpeningBalance']);
    $Status = clean($_POST['Status']);

     //Duplicate Check
    $Duplicate = $conn->prepare("SELECT * FROM `Bank` WHERE `BranchName` = '$BranchName' AND `BankName` = '$BankName' AND `AccountName` = '$AccountName' AND `AccountNumber` = '$AccountNumber'  AND `BankID` != '$UpdateId' ");
    $Duplicate->execute();

    if($Duplicate->rowCount() >= 1){
        print 102;
        exit();
    }


    $BankUpdate = $conn->prepare("UPDATE `Bank` SET 
            `BranchName`='".$BranchName."',
            `BankName`='".$BankName."',
            `AccountName`='".$AccountName."',
            `AccountNumber`='".$AccountNumber."',
            `OpeningBalance`='".$OpeningBalance."',
            `LastModifiedDate`='".$CurrentDateTime."',
            `UpdateId`='".$SessionID."',
            `Status`='".$Status."'
            WHERE `BankID` = '".$UpdateId."' ");
            $BankUpdate->execute();

    if($BankUpdate){
        print 200;
        exit();
    }else{
        print 400;
        exit();
    }
      
break;


//Others Account Update
case "OthersAccount":
    $UpdateId = clean($_POST['UpdateId']);
    $SectorName = clean($_POST['SectorName']);
    $OthersAccountName = clean($_POST['OthersAccountName']);
    $MobileNo = clean($_POST['MobileNo']);
    $CreditLimit = clean($_POST['CreditLimit']);
    $Category = clean($_POST['Category']);
    $OpeningBalance = clean($_POST['OpeningBalance']);
    $Status = clean($_POST['Status']);

        //Duplicate Check
        $Duplicate = $conn->prepare("SELECT * FROM `OthersAccount` WHERE `SectorName` = '$SectorName' AND `OthersAccountName` = '$OthersAccountName' AND `OthersAccountID` != '$UpdateId'");
        $Duplicate->execute();

    if($Duplicate->rowCount() >= 1){
        print 102;
        exit();
    }


            $OthersAccountUpdate = $conn->prepare("UPDATE `OthersAccount` SET 
            `SectorName`='".$SectorName."',
            `OthersAccountName`='".$OthersAccountName."',
            `MobileNo`='".$MobileNo."',
            `CreditLimit`='".$CreditLimit."',
            `Category`='".$Category."',
            `OpeningBalance`='".$OpeningBalance."',
            `LastModifiedDate`='".$CurrentDateTime."',
            `UpdateId`='".$SessionID."',
            `Status`='".$Status."'
            WHERE `OthersAccountID` = '".$UpdateId."' ");
            $OthersAccountUpdate->execute();

    if($OthersAccountUpdate){
        print 200;
        exit();
    }else{
        print 400;
        exit();
    }
      
break;


// User Update
case "User":
    $UpdateId = clean($_POST['UpdateId']);
    $User = clean($_POST['User']);
    $UserName = clean($_POST['UserName']);
    $DecryptPassword = clean($_POST['DecryptPassword']);
    $Password = md5($DecryptPassword);
    $Admin = clean($_POST['Admin']);
    $EditAccess = clean($_POST['EditAccess']);
    $DeleteAccess = clean($_POST['DeleteAccess']);
    $Block = clean($_POST['Block']);


     //Duplicate Check
    $Duplicate = $conn->prepare("SELECT * FROM `UserInformation` WHERE `User` = '$User' AND `Id` != '$UpdateId' ");
    $Duplicate->execute();

    if($Duplicate->rowCount() >= 1){
        print 102;
        exit();
    }


    $UserUpdate = $conn->prepare("UPDATE `UserInformation` SET 
            `User`='".$User."',
            `UserName`='".$UserName."',
            `DecryptPassword`='".$DecryptPassword."',
            `Password`='".$Password."',
            `Admin`='".$Admin."',
            `EditAccess`='".$EditAccess."',
            `DeleteAccess`='".$DeleteAccess."',
            `Block`='".$Block."'

            WHERE `Id` = '".$UpdateId."' ");
    $UserUpdate->execute();

    if($UserUpdate){
        print 200;
        exit();
    }else{
        print 400;
        exit();
    }
      
break;

default:
print "400";


}



