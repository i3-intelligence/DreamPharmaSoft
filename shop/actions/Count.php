<?php
require_once '../includes/Auth.php'; // Session Starting file
include '../config/Database.php'; // Database connection file
//GET DATA FROM AJAX


        //Active Package Count
		$QueryPackageCount = $conn->prepare("SELECT COUNT(`Id`) AS `count` FROM `package` WHERE `Status` = 'Active' "); 
		$QueryPackageCount->execute();
		$FetchPackageCount = $QueryPackageCount->fetch(PDO::FETCH_ASSOC);
		$ActivePackage = $FetchPackageCount['count'];

		//Active Owner Count
		$QueryOwnerCount = $conn->prepare("SELECT COUNT(`id`) AS `count` FROM `user_information` WHERE `Owner` = 'Yes' ");
		$QueryOwnerCount->execute();
		$FetchOwnerCount = $QueryOwnerCount->fetch(PDO::FETCH_ASSOC);
		$ActiveOwner = $FetchOwnerCount['count'];

		//Active Shop Count
		$QueryShopCount = $conn->prepare("SELECT COUNT(`id`) AS `count` FROM `shop` WHERE `Status` = 'Active' ");
		$QueryShopCount->execute();
		$FetchShopCount = $QueryShopCount->fetch(PDO::FETCH_ASSOC);
		$ActiveShop = $FetchShopCount['count'];

		//Active Medicine Count
		$QueryMedicineCount = $conn->prepare("SELECT COUNT(`MedicineID`) AS `count` FROM `medicine` WHERE `Status` = 'Active' ");
		$QueryMedicineCount->execute();
		$FetchMedicineCount = $QueryMedicineCount->fetch(PDO::FETCH_ASSOC);
		$ActiveMedicine = $FetchMedicineCount['count'];

?>