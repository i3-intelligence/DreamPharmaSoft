<?php
require_once("auth.php");
include("db.php");
include("clean.php");
// print_r($_POST);
## CHECK
if(!empty($_POST['SupplierID'])  && !empty($_POST['ItemCategoryID'])&& !empty($_POST['SupplierCategory'])){

    ## FOREACH
    foreach($_POST['PackageSizeID'] as $PackageSizeID){
        
    $Rate = $_POST["Rate$PackageSizeID"];
    
    ## CHECK VALUE
    if($Rate==''){
    @header("location: PurchaseRate.php?msg=fields_null&pc=$PackageSizeID&SupplierID=$_POST[SupplierID]&ItemCategoryID=$_POST[ItemCategoryID]&SupplierCategory=$_POST[SupplierCategory]");
    exit();	}
        
    if(is_numeric($Rate)){

    }else{

    @header("location: PurchaseRate.php?msg=wint&pc=$PackageSizeID&SupplierID=$_POST[SupplierID]&ItemCategoryID=$_POST[ItemCategoryID]&SupplierCategory=$_POST[SupplierCategory]");
    exit();
  }
    ## UPDATE DATA
    $select_Rate = $conn->prepare("SELECT * FROM `PurchaseRate` WHERE `SupplierID`='$_POST[SupplierID]' AND `ItemCategoryID`='$_POST[ItemCategoryID]' AND `SupplierCategory`= '$_POST[SupplierCategory]' AND `PackageSizeID`='$PackageSizeID'");
    $select_Rate->execute();
    
    if($select_Rate->rowCount() ==1){
        
        $update = $conn->prepare("UPDATE `PurchaseRate` SET 
        `Rate`='$Rate',
        `CreateDate`= '$CurrentDateTime',
        `LastModifiedDate`= '$CurrentDateTime',
        `UpdateId`='".$SessionID."' 
        WHERE `SupplierID`='$_POST[SupplierID]'  AND `ItemCategoryID`='$_POST[ItemCategoryID]' AND `SupplierCategory`='$_POST[SupplierCategory]' AND  `PackageSizeID`='$PackageSizeID'  ");
        $update->execute();	
    
    ## QUERY :: SUCCESS ::
    if($update){
    @header("location: PurchaseRate.php?msg=success&SupplierID=$_POST[SupplierID]&ItemCategoryID=$_POST[ItemCategoryID]&SupplierCategory=$_POST[SupplierCategory]");	
        } //clsoe qry if brace
    else{
    @header("location: PurchaseRate.php?msg=error&SupplierID=$_POST[SupplierID]&ItemCategoryID=$_POST[ItemCategoryID]&SupplierCategory=$_POST[SupplierCategory]");
        }
        
        }else{
        
        
    ## INSERT DATA
    $query = $conn->exec("INSERT INTO `PurchaseRate` 
                            (
                                `PurchaseRateID`,
                                `SupplierID`,
                                `ItemCategoryID`,
                                `SupplierCategory`,
                                `PackageSizeID`,
                                `Rate`,
                                `CreateDate`,
                                `LastModifiedDate`,
                                `EntryID`,
                                `UpdateId`
                            ) 
                                VALUES
                                (
                                    '0',
                                    '$_POST[SupplierID]',
                                    '$_POST[ItemCategoryID]',
                                    '$_POST[SupplierCategory]',
                                    '$PackageSizeID',
                                    '$Rate',
                                    '$CurrentDateTime',
                                    '$CurrentDateTime',
                                    '".$SessionID."',
                                    '".$SessionID."'
                                ) 
                            ");
    
    ## QUERY :: SUCCESS ::
    if($query){
    @header("location: PurchaseRate.php?msg=success&SupplierID=$_POST[SupplierID]&ItemCategoryID=$_POST[ItemCategoryID]&SupplierCategory=$_POST[SupplierCategory]");	
        } //clsoe qry if brace
    else{
    @header("location: PurchaseRate.php?msg=error&SupplierID=$_POST[SupplierID]&ItemCategoryID=$_POST[ItemCategoryID]&SupplierCategory=$_POST[SupplierCategory]");
        }		
        
        
        
        } //ELSE
        
        
        
            
        } // FOREACH LOOP
        
    ##
        
        } //close upper if brace
    // else{
    // @header("location: PurchaseRate.php?msg=fields_null&SupplierID=$_POST[SupplierID]&ItemCategoryID=$_POST[ItemCategoryID]&SupplierCategory=$_POST[SupplierCategory]");
    // 	}
    
        ## CHECK
    if(!empty($_GET['delete']) && ($_GET['delete']=='yes')){
    
    ## DELETE DATA
    $query = $conn->prepare("DELETE FROM `PurchaseRate` WHERE `PurchaseRateID`='$_GET[id]'");
    $query->execute();
    
    if($query){
    @header("location: PurchaseRate.php?msg=delete_success&SupplierID=$_GET[SupplierID]&ItemCategoryID=$_GET[ItemCategoryID]&SupplierCategory=$_GET[SupplierCategory]");	
    }
    
    
    }
    