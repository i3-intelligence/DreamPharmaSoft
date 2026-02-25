<?php
require_once '../includes/Auth.php'; // Session Starting file
include '../config/Database.php'; // Database connection file
//GET DATA FROM AJAX



		//Active Medicine Count
		$QueryMedicineCount = $conn->prepare("SELECT COUNT(`MedicineID`) AS `count` FROM `user_medicine` WHERE `Status` = 'Active' AND `ShopId` = '$ShopId'");
		$QueryMedicineCount->execute();
		$FetchMedicineCount = $QueryMedicineCount->fetch(PDO::FETCH_ASSOC);
		$ActiveMedicine = $FetchMedicineCount['count'];

?>