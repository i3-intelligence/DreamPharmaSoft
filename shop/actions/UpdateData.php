<?php
require_once '../includes/Auth.php'; // Session Starting file
require_once '../includes/Clean.php'; // clean file
include '../config/Database.php'; // Database connection file
//GET DATA FROM AJAX
$action = $_POST['action'];

switch($action){
   
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

            $duplicate = $conn->prepare("SELECT * FROM `Medicine` WHERE `MedicineName` = '$MedicineName' AND `$ShopId` = '$ShopId'  AND `MedicineID` != '$UpdateId' ");
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
