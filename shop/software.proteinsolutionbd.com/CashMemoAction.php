<?php
require_once("auth.php");
include("db.php");
include("clean.php");

// echo "<pre>".print_r($_POST,true)."</pre>";

## CHECK

if(!empty($_POST['ChallanID'])){
    $SupplierID = clean($_POST['SupplierID']);
    $SalesType = clean($_POST['SalesType']);
    $CustomerName = clean($_POST['CustomerName']);
    $CustomerAddress = clean($_POST['CustomerAddress']);
    $CustomerID = clean($_POST['CustomerID']);

    # FOREACH
    foreach($_POST['ChallanID'] as $ChallanID){
        $PackageSizeID = clean($_POST["PackageSizeID$ChallanID"]);
        $ItemCategoryID = clean($_POST["ItemCategoryID$ChallanID"]);
        $ChallanDate = clean($_POST["ChallanDate$ChallanID"]);
        $ChallanRate = clean($_POST["ChallanRate$ChallanID"]);
        $SalesRate = clean($_POST["SalesRate$ChallanID"]);
        $SalesQuantity = clean($_POST["SalesQuantity$ChallanID"]);
        $SalesAmount = number_format($SalesRate * $SalesQuantity,2,'.','');
        $Balance = clean($_POST["Balance$ChallanID"]);
        $PerProductProfit = number_format($SalesRate - $ChallanRate,2,'.','');
        $TotalProfit = number_format($PerProductProfit * $SalesQuantity,2,'.','');

        ## CHECK
        // print $CurrentDate."--".$ChallanDate."<br>";

        if(".$ChallanDate." > ".$CurrentDate."){
            @header("location: CashMemo.php?msg=ChallanDateEmpty");   
            echo "Yes";
            exit();
        }


        if($SalesAmount == '0'){
      
            @header("location: CashMemo.php?msg=AmountZero");   
            exit();
        }


        if(($SalesQuantity !='') && ($SalesRate !='')){
            if($Balance <= 0){
       
                $Status = 'Complete';
                $ChallanUpdate = $conn->prepare("UPDATE `Challan` SET `Status` = '$Status' WHERE `ChallanID` = '$ChallanID' ");
                $ChallanUpdate->execute();
    
            }
        
        ## INSERT DATA
        $CashMemoInsart = $conn->exec("INSERT INTO `CashMemo` 
                                (
                                    `SupplierID`,
                                    `ItemCategoryID`,
                                    `PackageSizeID`,
                                    `ChallanID`,
                                    `ChallanRate`,
                                    `SalesRate`,
                                    `SalesQuantity`,
                                    `SalesAmount`,
                                    `PerProductProfit`,
                                    `TotalProfit`,
                                    `CreateDate`,
                                    `CashMemoDate`,
                                    `EntryID`
                                ) 
                                    VALUES
                                    (
                                        '$SupplierID',
                                        '$ItemCategoryID',
                                        '$PackageSizeID',
                                        '$ChallanID',
                                        '$ChallanRate',
                                        '$SalesRate',
                                        '$SalesQuantity',
                                        '$SalesAmount',
                                        '$PerProductProfit',
                                        '$TotalProfit',
                                        '$CurrentDateTime',
                                        '$CurrentDate',
                                        '".$SessionID."'
                                    ) 
                                ");


     ## QUERY :: SUCCESS ::
     if($CashMemoInsart){
        @header("location: CashMemo.php?msg=success&SalesType=$SalesType&CustomerName=$CustomerName&CustomerAddress=$CustomerAddress&CustomerID=$CustomerID&SupplierID=$SupplierID&ItemCategoryID=$ItemCategoryID");
            } //clsoe qry if brace
        else{
        @header("location: CashMemo.php?msg=error&SalesType=$SalesType&CustomerName=$CustomerName&CustomerAddress=$CustomerAddress&CustomerID=$CustomerID&SupplierID=$SupplierID&ItemCategoryID=$ItemCategoryID");
            }		
            
            
            
            }else{
                @header("location: CashMemo.php?msg=error&SalesType=$SalesType&CustomerName=$CustomerName&CustomerAddress=$CustomerAddress&CustomerID=$CustomerID&SupplierID=$SupplierID&ItemCategoryID=$ItemCategoryID");
            } //ELSE



    }

}

//Delete Cart
if(!empty($_GET['DeleteID'])){

    $DeleteID = clean($_GET['DeleteID']);
    $ChallanID = clean($_GET['ChallanID']);
    $SalesType = clean($_GET['SalesType']);
    $CustomerName = clean($_GET['CustomerName']);
    $CustomerAddress = clean($_GET['CustomerAddress']);
    $CustomerID = clean($_GET['CustomerID']);
    $SupplierID = clean($_GET['SupplierID']);
    $ItemCategoryID = clean($_GET['ItemCategoryID']);

    $Status = 'Active';
    $ChallanUpdate = $conn->prepare("UPDATE `Challan` SET `Status` = '$Status' WHERE `ChallanID` = '$ChallanID' ");
    $ChallanUpdate->execute();

    $query = $conn->prepare("DELETE FROM `CashMemo` WHERE `CashMemoID` = '$DeleteID' AND `EntryID` = '$SessionID' ");
    $query->execute();

    if($query){
        @header("location: CashMemo.php?msg=delete_success&SalesType=$SalesType&CustomerName=$CustomerName&CustomerAddress=$CustomerAddress&CustomerID=$CustomerID&SupplierID=$SupplierID&ItemCategoryID=$ItemCategoryID");
    }else{
        @header("location: CashMemo.php?msg=error&SalesType=$SalesType&CustomerName=$CustomerName&CustomerAddress=$CustomerAddress&CustomerID=$CustomerID&SupplierID=$SupplierID&ItemCategoryID=$ItemCategoryID");
    }
}
?>