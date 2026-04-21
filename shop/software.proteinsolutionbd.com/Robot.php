<?php
require_once("auth.php");
include("db.php");
include("clean.php");

        //Cart Check
        $Challan = $conn->prepare("SELECT * FROM `Challan`  
        WHERE `Robot` = 'No'
        ORDER BY `Challan`.`ChallanID` ASC ");
        $Challan->execute();
        $FetchChallan = $Challan->FetchAll(PDO::FETCH_ASSOC);
        foreach($FetchChallan AS $Fetch) {
                $SupplierID = $Fetch['SupplierID'];

            $CashMemoReturnUpdate = $conn->prepare("UPDATE `CashMemoReturn` SET `SupplierID` = '$SupplierID' WHERE `ChallanID` = '$Fetch[ChallanID]' ");
            $CashMemoReturnUpdate->execute();

            
            $CashMemoUpdate = $conn->prepare("UPDATE `CashMemo` SET `SupplierID` = '$SupplierID' WHERE `ChallanID` = '$Fetch[ChallanID]' ");
            $CashMemoUpdate->execute();

            $ChallanUpdate = $conn->prepare("UPDATE `Challan` SET `Robot` = 'Yes' WHERE `ChallanID` = '$Fetch[ChallanID]' ");
            $ChallanUpdate->execute();
            

            
        }

?>