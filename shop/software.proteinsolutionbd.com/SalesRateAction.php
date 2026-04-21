<?php
require_once("auth.php");
include("db.php");
include("clean.php");

// print_r($_POST);

## CHECK
if(!empty($_POST['SupplierID'])  && !empty($_POST['ItemCategoryID'])  && !empty($_POST['CustomerCategoryID'])){

    ## FOREACH
    foreach($_POST['PackageSizeID'] as $PackageSizeID){
    
    $Rate = $_POST["Rate$PackageSizeID"];
    
    ## CHECK VALUE
    if($Rate==''){
    @header("location: SalesRate.php?msg=fields_null&pc=$PackageSizeID&SupplierID=$_POST[SupplierID]&ItemCategoryID=$_POST[ItemCategoryID]&CustomerCategoryID=$_POST[CustomerCategoryID]");
    exit();	}
        
    if(is_numeric($Rate)){
        }else{
    @header("location: SalesRate.php?msg=wint&pc=$PackageSizeID&SupplierID=$_POST[SupplierID]&ItemCategoryID=$_POST[ItemCategoryID]&CustomerCategoryID=$_POST[CustomerCategoryID]");
    exit();}
    
    ## UPDATE DATA
    $QryRate = $conn->prepare("SELECT * FROM `SalesRate` WHERE `SupplierID`='$_POST[SupplierID]' AND `ItemCategoryID`='$_POST[ItemCategoryID]' AND `CustomerCategoryID`= '$_POST[CustomerCategoryID]'   AND `PackageSizeID`='$PackageSizeID'");
    $QryRate->execute();
    if($QryRate->rowCount()==1){
    
    $UpdateData = $conn->prepare("UPDATE `SalesRate` SET 
    `Rate`='$Rate',
    `CreateDate`= '$CurrentDateTime',
    `LastModifiedDate`= '$CurrentDateTime',
    `UpdateId` ='".$SessionID."' 
    WHERE `SupplierID`='$_POST[SupplierID]'  AND `ItemCategoryID`='$_POST[ItemCategoryID]' AND `CustomerCategoryID`='$_POST[CustomerCategoryID]'  AND  `PackageSizeID`='$PackageSizeID'  ");	
    $UpdateData->execute();
    
    ## QUERY :: SUCCESS ::
    if($UpdateData){
    @header("location: SalesRate.php?msg=update&SupplierID=$_POST[SupplierID]&ItemCategoryID=$_POST[ItemCategoryID]&CustomerCategoryID=$_POST[CustomerCategoryID]");	
        } //clsoe qry if brace
    else{
    @header("location: SalesRate.php?msg=error&SupplierID=$_POST[SupplierID]&ItemCategoryID=$_POST[ItemCategoryID]&CustomerCategoryID=$_POST[CustomerCategoryID]");
        }
           
        }else{
        
    ## INSERT DATA
    $query = $conn->exec("INSERT INTO `SalesRate` 
                            (
                                `SalesRateID`,
                                `SupplierID`,
                                `ItemCategoryID`,
                                `CustomerCategoryID`,
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
                                    '$_POST[CustomerCategoryID]',
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
    @header("location: SalesRate.php?msg=success&SupplierID=$_POST[SupplierID]&ItemCategoryID=$_POST[ItemCategoryID]&CustomerCategoryID=$_POST[CustomerCategoryID]");	
        } //clsoe qry if brace
    else{
    @header("location: SalesRate.php?msg=error&SupplierID=$_POST[SupplierID]&ItemCategoryID=$_POST[ItemCategoryID]&CustomerCategoryID=$_POST[CustomerCategoryID]");
        }		
        
        
        
        } //ELSE
        
        
        
            
        } // FOREACH LOOP
        
    ##
        
        } //close upper if brace
    // else{
    // @header("location: SalesRate.php?msg=fields_null&SupplierID=$_POST[SupplierID]&ItemCategoryID=$_POST[ItemCategoryID]&CustomerCategoryID=$_POST[CustomerCategoryID]");
    // 	}
    
        ## CHECK
    if(!empty($_GET['delete']) && ($_GET['delete']=='yes')){
    
    ## DELETE DATA
    $query = $conn->prepare("DELETE FROM `SalesRate` WHERE `SalesRateID`='$_GET[id]'");
    $query->execute();
    if($query){
    @header("location: SalesRate.php?msg=delete_success&SupplierID=$_GET[SupplierID]&ItemCategoryID=$_GET[ItemCategoryID]&CustomerCategoryID=$_GET[CustomerCategoryID]");	
    }
    
    
    }
    