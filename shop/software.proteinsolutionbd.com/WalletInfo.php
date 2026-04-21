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
?>