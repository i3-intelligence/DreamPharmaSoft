<?php

// Database Configuration Local
$prefix = "nuralam_"; // For online/offline prefixing (optional)
$servername = "localhost";
$username = $prefix . "pms"; //Pharmacy Management System
$password = "f[bL8Wu1VA7yPK1]"; // lowercase for consistency
$database = $prefix . "pharma";


try {
    $conn = new PDO(
        "mysql:host=$servername;dbname=$database;charset=utf8",
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    // echo "Connected successfully"; // Optional debug
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// If session is set, fetch user data
if (!empty($_SESSION['DPS_ADMIN_SSN_ID'])) {
    $query1 = $conn->prepare("SELECT * FROM `controller_information` WHERE `id` = :id");
    $query1->execute(['id' => $_SESSION['DPS_ADMIN_SSN_ID']]);
    $FetchUserInfo = $query1->fetch(PDO::FETCH_ASSOC);

    if ($FetchUserInfo) {
        $SessionID = $_SESSION['DPS_ADMIN_SSN_ID'];
        $OperatorName = $FetchUserInfo['UserName'] ?? '';
        $OperatorDesignation = $FetchUserInfo['Designation'] ?? '';
        $operator_address = $FetchUserInfo['Address'] ?? '';
        $operator_phone = $FetchUserInfo['Phone'] ?? '';
        $OperatorPicture = $FetchUserInfo['Picture'] ?? '';
        $EditAccess = $FetchUserInfo['EditAccess'] ?? '';
        $DeleteAccess = $FetchUserInfo['DeleteAccess'] ?? '';

        $LastUpdate = "$OperatorName Date: " . date("d-M-Y") . " Time: " . date("h:i:s a") . " IP " . $_SERVER['REMOTE_ADDR'];
        $ActivePage = basename($_SERVER['PHP_SELF'], ".php");
    }
}

// General variables
$CurrentDate = date("Y-m-d");
$InvoiceDate = date("dmy", strtotime($CurrentDate));
$InvoicePrefix = $InvoiceDate . "UM";

$currency = "BDT";
$currency_sym = "Tk";
$NumberValidity = 'onfocus="if(this.value == \'0\') { this.value = \'\'; }" onblur="if(this.value == \'\') { this.value = \'0\'; }" oninput="this.value = this.value.replace(/[^-0-9.]/g, \'\').replace(/(\..*?)\..*/g, \'$1\');"';
$c_logo = "dist/img/logo.png";
$CreateDate = "2023-01-01";
$maintenance = "01883008651";
$quantity = "Quantity";
$AutoComplete = 'autocomplete="off"';
$CurrentTime = date("H:i:s");
$CurrentDateTime = date("Y-m-d H:i:s");

$Development = "Dream Pharma Soft";
$DevelopmentLink = "https://www.facebook.com/shafayetnuralam";
$PHPVersion = phpversion();
?>
