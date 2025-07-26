<?php
require_once '../includes/Auth.php'; // Session Starting file
require_once '../includes/Clean.php'; // clean file
include '../config/Database.php'; // Database connection file
//GET DATA FROM AJAX
$action = $_POST['action'];

switch($action){
    //Package Insert
    case "Package":
        $PackageName = clean($_POST['PackageName']);
        $PacakageDuration = clean($_POST['PacakageDuration']); 
        $PacakageAmount = clean($_POST['PacakageAmount']);
        $NumberOfUser = clean($_POST['NumberOfUser']);

        $duplicate = $conn->prepare("SELECT * FROM `package` WHERE `PackageName` = '$PackageName'");
        $duplicate->execute();
        if($duplicate->rowCount() >= 1){
            print 102;
            exit();
        }

        $PackageInsert = $conn->exec("INSERT INTO `package`
                (
                    `PackageName`, 
                    `PacakageDuration`, 
                    `PacakageAmount`, 
                    `NumberOfUser`,
                    `CreateDate`,
                    `EntryId`,
                    `LastUpdate`
                ) VALUES (
                    '".$PackageName."',
                    '".$PacakageDuration."',
                    '".$PacakageAmount."',
                    '".$NumberOfUser."',
                    '$CurrentDateTime',
                    '$SessionID', 
                    '$LastUpdate') ");


        if($PacakageAmount){
            print 101;
            exit();
        }else{
            print 400;
            exit();
        }
        

    break;

    //Owner Insert
    case "Owner":
        $OwnerName = clean($_POST['OwnerName']);
        $Phone = clean($_POST['Phone']);
        $ShopName = clean($_POST['ShopName']);
        $ShopAddress = clean($_POST['ShopAddress']);
        $PackageId = clean($_POST['PackageId']);
        $SubscriptionStartDate = clean($_POST['SubscriptionStartDate']);
        $SubscriptionEndDate = clean($_POST['SubscriptionEndDate']);
        $DecryptPassword = rand(10,100000);
        $Password = md5($DecryptPassword);

        $duplicate = $conn->prepare("SELECT * FROM `user_information` WHERE `Phone` = '$Phone'");
        $duplicate->execute();
        if($duplicate->rowCount() >= 1){
            print 102;
            exit();
        }
    //Select Package Data 
    $PackageSql = $conn->prepare("SELECT * FROM `package` WHERE `Id` = '$PackageId'");
    $PackageSql->execute();
    $PackageData = $PackageSql->fetch(PDO::FETCH_ASSOC);
    $NumberOfUser = $PackageData['NumberOfUser'];


    // SEND BY SMS LINK
        $apikey = '$2y$10$iFiaZwMCfz9XBipKs7HNbevYtVyYvLdEIpHYS/JvpAuJn2IWH/ppy';
        $toUser = "+88".$Phone;
        $messageContent = urlencode("Dear ".$OwnerName.", Your Shop ".$ShopName.",Package is ".$PackageData['PackageName'].", Package End Date is ".date("d/m/Y",strtotime($SubscriptionEndDate))." Shop User is ".$Phone." and Password is ".$DecryptPassword.". Please login to your account and change your password. Welcone To I3 Pharmacy.");

        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL,"https://server.jadusms.com/smsapi/non-masking?api_key=$apikey&smsType=text&mobileNo=$toUser&smsContent=$messageContent");
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $resp = curl_exec($ch);
        // curl_close($ch);



    //Insert Shop Data 
    $ShopInsert = $conn->exec("INSERT INTO `shop`
    (
        `ShopName`, 
        `ShopAddress`, 
        `PackageId`, 
        `NumberOfUser`, 
        `SubscriptionStartDate`,
        `SubscriptionEndDate`,
        `CreateDate`
    ) VALUES (
        '".$ShopName."',
        '".$ShopAddress."',
        '".$PackageId."',
        '".$NumberOfUser."',
        '".$SubscriptionStartDate."',
        '".$SubscriptionEndDate."',
        '$CurrentDateTime'
        ) ");

    $ShopId = $conn->lastInsertId();

        //Insert Owner Data
        $OwnerInsert = $conn->exec("INSERT INTO `user_information`
                (
                    `UserName`, 
                    `Phone`, 
                    `ShopId`, 
                    `Password`, 
                    `DecryptPassword`, 
                    `CreateDate`,
                    `Owner`,
                    `EditAccess`,
                    `DeleteAccess`
                ) VALUES (
                    '".$OwnerName."',
                    '".$Phone."',
                    '".$ShopId."',
                    '".$Password."',
                    '".$DecryptPassword."',
                    '$CurrentDateTime',
                    'Yes', 
                    'Yes', 
                    'Yes') ");

    $OwnerId = $conn->lastInsertId();
if($OwnerInsert){

//Shop Database Add On Shop Table
$AddToShop = $conn->prepare("UPDATE `shop` SET `OwnerId` = '$OwnerId'  WHERE `Id` = '$ShopId'");
$AddToShop->execute();


//Shop Database Add On Medicine Table Data
$AddToMedicineData = $conn->exec("INSERT INTO `user_medicine` SELECT '',`MedicineID`, `MedicineName`, `PurchasePrice`, `WoleSalePrice`, `PackSize`, `PriceBox`, `SalePrice`, `Company`, `Generic`, `OpeningStock`, `CreateDate`, `LastModifiedDate`, `EntryId`, `UpdateId`, $ShopId, `Status` FROM `medicine` WHERE `Status` = 'Active'");

if($AddToMedicineData){
    print 101;
    exit();
        }else{
        print 400;
        exit();
        }
    }


    
    break;

//Medicine Insert
    case "Medicine":
        $MedicineName = clean($_POST['MedicineName']);
        $PurchasePrice = clean($_POST['PurchasePrice']);
        $PackSize = clean($_POST['PackSize']);
        $SalePrice = clean($_POST['SalePrice']);
        $Company = clean($_POST['Company']);
        $Generic = clean($_POST['Generic']);

        $duplicate = $conn->prepare("SELECT * FROM `medicine` WHERE `MedicineName` = '$MedicineName'");
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