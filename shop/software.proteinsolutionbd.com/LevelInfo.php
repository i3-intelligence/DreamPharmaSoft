<?php
include("auth.php");
include("db.php");
include_once("clean.php");
header('Content-Type: application/json');

if(!empty($_POST['WalletID'])){

    $WalletID = clean($_POST['WalletID']);
    $sql = $conn->prepare("SELECT `Name` AS `WalletPaymentInfo` FROM `Wallet` WHERE `WalletID` = '$WalletID'");
    $sql->execute();
    $fetch = $sql->fetch(PDO::FETCH_ASSOC);
    $WalletInfo = $fetch['WalletPaymentInfo'];

    echo json_encode ($WalletInfo);
}

if(!empty($_POST['BankID'])){
    $BankID = clean($_POST['BankID']);
    $sql = $conn->prepare("SELECT `BankName`,`AccountName`,`AccountNumber` FROM `Bank` WHERE `BankID` = '$BankID'");
    $sql->execute();
    $fetch = $sql->fetch(PDO::FETCH_ASSOC);
    $BankName = $fetch['BankName'];
    $AccountName = $fetch['AccountName'];
    $AccountNumber = $fetch['AccountNumber'];

    echo json_encode (array($BankName,$AccountName,$AccountNumber));
}
?>