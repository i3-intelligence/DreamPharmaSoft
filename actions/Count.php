<?php
require_once '../includes/auth.php'; // Session Starting file
include '../config/database.php'; // Database connection file
//GET DATA FROM AJAX


        //Active Package Count
		$QueryPackageCount = $conn->prepare("SELECT COUNT(`Id`) AS `count` FROM `Package` WHERE `Status` = 'Active' "); 
		$QueryPackageCount->execute();
		$FetchPackageCount = $QueryPackageCount->fetch(PDO::FETCH_ASSOC);
		$ActivePackage = $FetchPackageCount['count'];

		//Active Owner Count
		$QueryOwnerCount = $conn->prepare("SELECT COUNT(`id`) AS `count` FROM `user_information` WHERE `Owner` = 'Yes' ");
		$QueryOwnerCount->execute();
		$FetchOwnerCount = $QueryOwnerCount->fetch(PDO::FETCH_ASSOC);
		$ActiveOwner = $FetchOwnerCount['count'];

		//Active Medicine Count
		$QueryMedicineCount = $conn->prepare("SELECT COUNT(`MedicineID`) AS `count` FROM `Medicine` WHERE `Status` = 'Active' ");
		$QueryMedicineCount->execute();
		$FetchMedicineCount = $QueryMedicineCount->fetch(PDO::FETCH_ASSOC);
		$ActiveMedicine = $FetchMedicineCount['count'];

?>