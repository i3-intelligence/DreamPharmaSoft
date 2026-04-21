<?php
require_once("auth.php");
include("db.php");
include("clean.php");

// echo "<pre>".print_r($_POST,true)."</pre>";
// exit();

## CHECK

if(!empty($_POST['ChallanID'])){
    $ChallanInvoice = clean($_POST['ChallanInvoice']);


    # FOREACH
    foreach($_POST['ChallanID'] as $ChallanID){
        $ReturnRate = clean($_POST["ReturnRate$ChallanID"]);
        $ReturnQuantity = clean($_POST["ReturnQuantity$ChallanID"]);
        $ReturnAmount = clean($_POST["ReturnAmount$ChallanID"]);
        $Balance = clean($_POST["Balance$ChallanID"]);


        if(($ReturnQuantity !='') && ($ReturnRate !='')){
        
                $Status = 'Active';
                $ChallanUpdate = $conn->prepare("UPDATE `Challan` SET `Status` = '$Status' WHERE `ChallanID` = '$ChallanID' ");
                $ChallanUpdate->execute();
    
        
            $QurryChallan = $conn->prepare("SELECT * FROM `Challan` WHERE `ChallanID` = '$ChallanID' ");
            $QurryChallan->execute();
            $ChallanFetch = $QurryChallan->fetch(PDO::FETCH_ASSOC);
            $SupplierID = $ChallanFetch['SupplierID'];
            $ItemCategoryID = $ChallanFetch['ItemCategoryID'];
            $PackageSizeID = $ChallanFetch['PackageSizeID'];
            $ChallanID = $ChallanFetch['ChallanID'];
            

        ## INSERT DATA
        $ChallanReturnInsart = $conn->exec("INSERT INTO `ChallanReturn` 
                                (
                                    `ChallanInvoice`,
                                    `SupplierID`,
                                    `ItemCategoryID`,
                                    `PackageSizeID`,
                                    `ChallanID`,
                                    `ReturnRate`,
                                    `ReturnQuantity`,
                                    `ReturnAmount`,
                                    `CreateDate`,
                                    `ChallanReturnDate`,
                                    `EntryID`
                                ) 
                                    VALUES
                                    (
                                        '$ChallanInvoice',
                                        '$SupplierID',
                                        '$ItemCategoryID',
                                        '$PackageSizeID',
                                        '$ChallanID',
                                        '$ReturnRate',
                                        '$ReturnQuantity',
                                        '$ReturnAmount',
                                        '$CurrentDateTime',
                                        '$CurrentDate',
                                        '".$SessionID."'
                                    ) 
                                ");


     ## QUERY :: SUCCESS ::
     if($ChallanReturnInsart){
        @header("location: ChallanReturn.php?msg=success&ChallanInvoice=$ChallanInvoice");
            } //clsoe qry if brace
        else{
        @header("location: ChallanReturn.php?msg=error&ChallanInvoice=$ChallanInvoice");
            }		
            
            
            
            }else{
                @header("location: ChallanReturn.php?msg=error&ChallanInvoice=$ChallanInvoice");
            } //ELSE



    }

}

//Delete Cart
if(!empty($_GET['DeleteID'])){

    $DeleteID = clean($_GET['DeleteID']);
    $ChallanInvoice = clean($_GET['ChallanInvoice']);
    $query = $conn->prepare("DELETE FROM `ChallanReturn` WHERE `ChallanReturnID` = '$DeleteID' AND `EntryID` = '$SessionID' ");
    $query->execute();

    if($query){
        @header("location: ChallanReturn.php?msg=delete_success&ChallanInvoice=$ChallanInvoice");
    }else{
        @header("location: ChallanReturn.php?msg=error&ChallanInvoice=$ChallanInvoice");
    }
}
?>