<?php
require_once("auth.php");
include("db.php");
include("clean.php");

if(!empty($_POST['ChallanInvoice'] && !empty($_POST['ChallanDate']))){

    $ChallanInvoice = clean($_POST['ChallanInvoice']);
    $ChallanDate = clean($_POST['ChallanDate']);
    

    //Duplicate Check
    $Duplicate = $conn->prepare("SELECT * FROM `Challan` WHERE `ChallanInvoice` = '$ChallanInvoice' ");
    $Duplicate->execute();

    if($Duplicate->rowCount() >= 1){
        print "102";
        exit();
    }
    //Cart Check
    $CheckCart = $conn->prepare("SELECT * FROM `Challan` WHERE `EntryID` = '$SessionID' AND `Cart` = '' ");
    $CheckCart->execute();
    $CountCart = $CheckCart->rowCount();

    if($CountCart <='0'){
        print "404";
        exit();
    }

    $UpdateChallan = $conn->prepare("UPDATE `Challan` SET 
                `ChallanInvoice` =  '$ChallanInvoice', 
                `ChallanDate` = '$ChallanDate', 
                `CreateDate` = '$CurrentDateTime',
                `Cart` = 'Yes' 
                WHERE `EntryID` = '$SessionID' AND `Cart` = '' ");
    $UpdateChallan->execute();
    
    if($UpdateChallan){
        print "200";
        exit();
    } //clsoe qry if brace
    else{
        print "400";
        exit();
    }


}