<?php
require_once("auth.php");
include("db.php");
include("clean.php");
// print_r($_POST);
## CHECK
if(!empty($_POST['SupplierID'])&& !empty($_POST['SupplierCategory'])){
  ## FOREACH
  $SupplierID = clean($_POST['SupplierID']);
  $SupplierCategory = clean($_POST['SupplierCategory']);
  
        // Duplicate Check
        $Duplicate = $conn->prepare("SELECT * FROM `Challan` WHERE `SupplierCategory` != '$SupplierCategory' AND `EntryID` = '$SessionID' AND Cart = '' ");
        $Duplicate->execute();
    
        if($Duplicate->rowCount() >= '1'){
            @header("location: Challan.php?msg=SupplierCategoryDuplicate");
            exit();
        }

        $duplicate2 = $conn->prepare("SELECT * FROM `Challan` WHERE `SupplierID` != '$SupplierID' AND `EntryID` = '$SessionID' AND Cart = '' ");
        $duplicate2->execute();
    
        if($duplicate2->rowCount() >= '1'){
            @header("location: Challan.php?msg=SupplierIDDuplicate");
            exit();
        }



    foreach($_POST['PackageSizeID'] as $PackageSizeID){
     
    $ItemCategoryID =clean($_POST["ItemCategoryID$PackageSizeID"]);
    $Rate = clean($_POST["Rate$PackageSizeID"]);
    $Quantity = clean($_POST["Quantity$PackageSizeID"]);

    $Amount = number_format($Rate * $Quantity,2,'.','');
    $Remarks = clean($_POST["Remarks$PackageSizeID"]);


    if(($Quantity !='') && ($Rate !='')){
        
    ## INSERT DATA
    $query = $conn->exec("INSERT INTO `Challan` 
                            (
                                `ChallanID`,
                                `SupplierID`,
                                `ItemCategoryID`,
                                `SupplierCategory`,
                                `PackageSizeID`,
                                `Rate`,
                                `Quantity`,
                                `Amount`,
                                `Remarks`,
                                `CreateDate`,
                                `EntryID`
                            ) 
                                VALUES
                                (
                                    '0',
                                    '$SupplierID',
                                    '$ItemCategoryID',
                                    '$SupplierCategory',
                                    '$PackageSizeID',
                                    '$Rate',
                                    '$Quantity',
                                    '$Amount',
                                    '$Remarks',
                                    '$CurrentDateTime',
                                    '".$SessionID."'
                                ) 
                            ");
    
    ## QUERY :: SUCCESS ::
    if($query){
    @header("location: Challan.php?msg=success");	
        } //clsoe qry if brace
    else{
    @header("location: Challan.php?msg=error");
        }		
        
        
        
        }else{
            @header("location: Challan.php?msg=error");
        } //ELSE
        
        
    } //close upper if brace
            
        } // FOREACH LOOP
        
    ##
        

    // else{
    // @header("location: Challan.php?msg=fields_null&SupplierID=$_POST[SupplierID]&ItemCategoryID=$_POST[ItemCategoryID]&SupplierCategory=$_POST[SupplierCategory]");
    // 	}
    
        ## CHECK
    if(!empty($_GET['delete']) && ($_GET['delete']=='yes')){
    
    ## DELETE DATA
    $query = $conn->prepare("DELETE FROM `Challan` WHERE `ChallanID`='$_GET[id]'");
    $query->execute();
    
    if($query){
    @header("location: Challan.php?msg=delete_success");	
    }
    
    
    }
    