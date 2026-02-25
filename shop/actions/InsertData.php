<?php
require_once '../includes/Auth.php'; // Session Starting file
require_once '../includes/Clean.php'; // clean file
include '../config/Database.php'; // Database connection file
//GET DATA FROM AJAX
$action = $_POST['action'];

switch($action){
   
//Medicine Insert
    case "Medicine":
        $MedicineName = clean($_POST['MedicineName']);
        $PurchasePrice = clean($_POST['PurchasePrice']);
        $PackSize = clean($_POST['PackSize']);
        $SalePrice = clean($_POST['SalePrice']);
        $Company = clean($_POST['Company']);
        $Generic = clean($_POST['Generic']);

        $duplicate = $conn->prepare("SELECT * FROM `user_medicine` WHERE `MedicineName` = '$MedicineName' AND `ShopId` = '$ShopId' ");
        $duplicate->execute();
        if($duplicate->rowCount() >= 1){
            print 102;
            exit();
        }


        $MedicineInsert = $conn->exec("INSERT INTO `medicine`
                (
                    `MedicineName`, 
                    `PurchasePrice`, 
                    `PackSize`, 
                    `SalePrice`, 
                    `Company`, 
                    `Generic`, 
                    `CreateDate`,
                    `LastModifiedDate`,
                    `EntryId`,
                    `UpdateId`,
                    `ShopId`,
                    `Status`
                ) VALUES (
                    '".$MedicineName."',
                    '".$PurchasePrice."',
                    '".$PackSize."',
                    '".$SalePrice."',
                    '".$Company."',
                    '".$Generic."',
                    '$CurrentDateTime',
                    '$CurrentDateTime',
                    '$SessionID',
                    '$SessionID',
                    '$ShopId',
                    'Active') ");

                    
            $MedicineID = $conn->lastInsertId();

                $user_medicine_Insert = $conn->exec("INSERT INTO `user_medicine`
                (
                    `MedicineID`,
                    `MedicineName`, 
                    `PurchasePrice`, 
                    `PackSize`, 
                    `SalePrice`, 
                    `Company`, 
                    `Generic`, 
                    `CreateDate`,
                    `LastModifiedDate`,
                    `EntryId`,
                    `UpdateId`,
                    `ShopId`,
                    `Status`
                ) VALUES (
                    '$MedicineID',
                    '".$MedicineName."',
                    '".$PurchasePrice."',
                    '".$PackSize."',
                    '".$SalePrice."',
                    '".$Company."',
                    '".$Generic."',
                    '$CurrentDateTime',
                    '$CurrentDateTime',
                    '$SessionID',
                    '$SessionID',
                    '$ShopId',
                    'Active') ");


               
        if($MedicineInsert){
  
            print 101;
            exit();
        }else{
            print 400;
            exit();
        }

    default:
    print "400";
}


?>