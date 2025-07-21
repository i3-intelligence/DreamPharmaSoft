<?php
require_once '../includes/auth.php'; // Session Starting file
require_once '../includes/clean.php'; // clean file
include '../config/database.php'; // Database connection file
//GET DATA FROM AJAX
$action = $_POST['action'];

switch($action){
    //Package Update
    case "Package":
        $UpdateId = clean($_POST['UpdateId']);
        $PackageName = clean($_POST['PackageName']);
        $PacakageDuration = clean($_POST['PacakageDuration']);
        $PacakageAmount = clean($_POST['PacakageAmount']);
        $NumberOfUser = clean($_POST['NumberOfUser']);
        $Status = clean($_POST['Status']);

        $duplicate = $conn->prepare("SELECT * FROM `package` WHERE `PackageName` = '$PackageName' AND `Id` != '$UpdateId' ");
        $duplicate->execute();
        if($duplicate->rowCount() >= 1){
            print 102;
            exit();
        }

        $PackageUpdate = $conn->exec("UPDATE `package` SET 
                `PackageName`='".$PackageName."',
                `PacakageDuration`='".$PacakageDuration."',
                `PacakageAmount`='".$PacakageAmount."',
                `NumberOfUser`='".$NumberOfUser."',
                `Status`='".$Status."',
                `LastUpdate`= '$LastUpdate'
                WHERE `Id` = '".$UpdateId."' ");

        if($PackageUpdate){
            print 200;
            exit();
        }else{
            print 400;
            exit();
        }

    break;

    //Owner Update
    case "Owner":
        $UpdateId = clean($_POST['UpdateId']);
        $OwnerName = clean($_POST['OwnerName']);
        $Phone = clean($_POST['Phone']);
        $ShopName = clean($_POST['ShopName']);
        $ShopAddress = clean($_POST['ShopAddress']);
        $PackageId = clean($_POST['PackageId']);
        $SubscriptionStartDate = clean($_POST['SubscriptionStartDate']);
        $SubscriptionEndDate = clean($_POST['SubscriptionEndDate']);
        $Status = clean($_POST['Status']);

        

        $duplicate = $conn->prepare("SELECT * FROM `user_data` WHERE `Phone` = '$Phone' AND `Id` != '$UpdateId' ");
        $duplicate->execute();
        if($duplicate->rowCount() >= 1){
            print 102;
            exit();
        }

        $OwnerUpdate = $conn->prepare("UPDATE `user_data` SET 
                `UserName`='".$OwnerName."',
                `Phone`='".$Phone."'
                WHERE `Id` = '".$UpdateId."' ");
        $OwnerUpdate->execute();

        $ShopUpdate = $conn->prepare("UPDATE `Shop` SET 
                `PackageId`='".$PackageId."',
                `ShopName`='".$ShopName."',
                `ShopAddress`='".$ShopAddress."',
                `SubscriptionStartDate`='".$SubscriptionStartDate."',
                `SubscriptionEndDate`='".$SubscriptionEndDate."',
                `Status`='".$Status."'
                WHERE `OwnerId` = '".$UpdateId."' ");
        $ShopUpdate->execute();

        if($OwnerUpdate && $ShopUpdate){
            print 200;
            exit();
        }else{
            print 400;
            exit();
        }
        
        break;

    //Medicine Update
    case "Medicine":
            $UpdateId = clean($_POST['UpdateId']);
            $MedicineName = clean($_POST['MedicineName']);
            $PurchasePrice = clean($_POST['PurchasePrice']);
            $PackSize = clean($_POST['PackSize']);
            $SalePrice = clean($_POST['SalePrice']);
            $Company = clean($_POST['Company']);
            $Generic = clean($_POST['Generic']);
            $Status = clean($_POST['Status']);

            $duplicate = $conn->prepare("SELECT * FROM `Medicine` WHERE `MedicineName` = '$MedicineName' AND `MedicineID` != '$UpdateId' ");
            $duplicate->execute();

            if($duplicate->rowCount() >= 1){
                print 102;
                exit();
            }

            $MedicineUpdate = $conn->prepare("UPDATE `Medicine` SET 
                    `MedicineName`='".$MedicineName."',
                    `PurchasePrice`='".$PurchasePrice."',
                    `PackSize`='".$PackSize."',
                    `SalePrice`='".$SalePrice."',
                    `Company`='".$Company."',
                    `Generic`='".$Generic."',
                    `LastModifiedDate`='".$CurrentDateTime."',
                    `UpdateId` = '$SessionID',
                    `Status`='".$Status."'
                    WHERE `MedicineID` = '".$UpdateId."' ");
            $MedicineUpdate->execute();

            if($MedicineUpdate){
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
