<?php
require_once("auth.php");
include("db.php");
include("clean.php");

if(!empty($_POST['ChallanReturnInvoice'] && !empty($_POST['ChallanReturnDate']))){

    $ChallanReturnInvoice = clean($_POST['ChallanReturnInvoice']);
    $ChallanReturnDate = clean($_POST['ChallanReturnDate']);
    

    //Duplicate Check
    $Duplicate = $conn->prepare("SELECT * FROM `ChallanReturn` WHERE `ChallanReturnInvoice` = '$ChallanReturnInvoice' ");
    $Duplicate->execute();

    if($Duplicate->rowCount() >= 1){
        print "102";
        exit();
    }
    //Cart Check
    $CheckCart = $conn->prepare("SELECT * FROM `ChallanReturn` WHERE `EntryID` = '$SessionID' AND `Cart` = '' ");
    $CheckCart->execute();
    $CountCart = $CheckCart->rowCount();

    if($CountCart <='0'){
        print "404";
        exit();
    }

    $UpdateChallanReturn = $conn->prepare("UPDATE `ChallanReturn` SET 
                `ChallanReturnInvoice` =  '$ChallanReturnInvoice', 
                `ChallanReturnDate` = '$ChallanReturnDate', 
                `CreateDate` = '$CurrentDateTime',
                `Cart` = 'Yes' 
                WHERE `EntryID` = '$SessionID' AND `Cart` = '' ");
    $UpdateChallanReturn->execute();
    
    if($UpdateChallanReturn){
        print "200";
        exit();
    } //clsoe qry if brace
    else{
        print "400";
        exit();
    }


}