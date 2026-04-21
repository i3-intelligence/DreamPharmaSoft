<?php
require_once("auth.php");
include("db.php");
include("clean.php");

// echo "<pre>".print_r($_POST,true)."</pre>";
// exit();

## CHECK

if(!empty($_POST['CashMemoInvoice'])){
    $CashMemoInvoice = clean($_POST['CashMemoInvoice']);


    # FOREACH
    foreach($_POST['CashMemoID'] as $CashMemoID){
        $PackageSizeID = clean($_POST["PackageSizeID$CashMemoID"]);
        $ReturnRate = clean($_POST["ReturnRate$CashMemoID"]);
        $ReturnQuantity = clean($_POST["ReturnQuantity$CashMemoID"]);
        $ReturnAmount = clean($_POST["ReturnAmount$CashMemoID"]);
        $Balance = clean($_POST["Balance$CashMemoID"]);


        if(($ReturnQuantity !='') && ($ReturnRate !='')){
  

        $QurryCashMemo = $conn->prepare("SELECT * FROM `CashMemo` WHERE `CashMemoID` = '$CashMemoID' ");
        $QurryCashMemo->execute();
        $CashMemoFetch = $QurryCashMemo->fetch(PDO::FETCH_ASSOC);
        $SupplierID = $CashMemoFetch['SupplierID'];
        $ItemCategoryID = $CashMemoFetch['ItemCategoryID'];
        $PackageSizeID = $CashMemoFetch['PackageSizeID'];
        $ChallanID = $CashMemoFetch['ChallanID'];
        $SalesRate = $CashMemoFetch['SalesRate'];
        $CustomerName = $CashMemoFetch['CustomerName'];
        $CustomerAddress = $CashMemoFetch['CustomerAddress'];
        $CustomerID = $CashMemoFetch['CustomerID'];
        $SalesType = $CashMemoFetch['SalesType'];
        $ChallanID = $CashMemoFetch['ChallanID'];
        $CustomerCategoryID = $CashMemoFetch['CustomerCategoryID'];

        $Status = 'Active';
        $ChallanUpdate = $conn->prepare("UPDATE `Challan` SET `Status` = '$Status' WHERE `ChallanID` = '$ChallanID' ");
        $ChallanUpdate->execute();
        
        ## INSERT DATA
        $CashMemoReturnInsart = $conn->exec("INSERT INTO `CashMemoReturn` 
                                (
                                    `SupplierID`,
                                    `ItemCategoryID`,
                                    `PackageSizeID`,
                                    `SalesType`,
                                    `ChallanID`,
                                    `CashMemoID`,
                                    `CashMemoInvoice`,
                                    `SalesRate`,
                                    `ReturnRate`,
                                    `ReturnQuantity`,
                                    `ReturnAmount`,
                                    `CustomerName`,
                                    `CustomerAddress`,
                                    `CustomerID`,
                                    `CustomerCategoryID`,
                                    `CreateDate`,
                                    `CashMemoReturnDate`,
                                    `EntryID`
                                ) 
                                    VALUES
                                    (
                                        '$SupplierID',
                                        '$ItemCategoryID',
                                        '$PackageSizeID',
                                        '$SalesType',
                                        '$ChallanID',
                                        '$CashMemoID',
                                        '$CashMemoInvoice',
                                        '$SalesRate',
                                        '$ReturnRate',
                                        '$ReturnQuantity',
                                        '$ReturnAmount',
                                        '$CustomerName',
                                        '$CustomerAddress',
                                        '$CustomerID',
                                        '$CustomerCategoryID',
                                        '$CurrentDateTime',
                                        '$CurrentDate',
                                        '".$SessionID."'
                                    ) 
                                ");


     ## QUERY :: SUCCESS ::
     if($CashMemoReturnInsart){
        @header("location: CashMemoReturn.php?msg=success&CashMemoInvoice=$CashMemoInvoice");
            } //clsoe qry if brace
        else{
        @header("location: CashMemoReturn.php?msg=error&CashMemoInvoice=$CashMemoInvoice");
            }		
            
            
            
            }else{
                @header("location: CashMemoReturn.php?msg=error&CashMemoInvoice=$CashMemoInvoice");
            } //ELSE



    }

}

//Delete Cart
if(!empty($_GET['DeleteID'])){

    $DeleteID = clean($_GET['DeleteID']);
    $CashMemoInvoice = clean($_GET['CashMemoInvoice']);

    $query = $conn->prepare("DELETE FROM `CashMemoReturn` WHERE `CashMemoReturnID` = '$DeleteID' AND `EntryID` = '$SessionID' ");
    $query->execute();

    if($query){
        @header("location: CashMemoReturn.php?msg=delete_success&CashMemoInvoice=$CashMemoInvoice");
    }else{
        @header("location: CashMemoReturn.php?msg=error&CashMemoInvoice=$CashMemoInvoice");
    }
}
?>