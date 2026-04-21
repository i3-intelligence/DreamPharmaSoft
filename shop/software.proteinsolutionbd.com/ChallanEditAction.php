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
        $EditRate = clean($_POST["EditRate$ChallanID"]);
        $EditQuantity = clean($_POST["EditQuantity$ChallanID"]);
        $EditAmount = clean($_POST["EditAmount$ChallanID"]);


        if(($EditQuantity !='') && ($EditRate !='')){
        
                $Status = 'Active';
                $ChallanUpdate = $conn->prepare("UPDATE `Challan` SET `Status` = '$Status' WHERE `ChallanID` = '$ChallanID' ");
                $ChallanUpdate->execute();
            

        ## Update DATA
        $ChallanEditUpdate = $conn->prepare("UPDATE `Challan` SET 
                                `Rate` = '$EditRate',
                                `Quantity` = '$EditQuantity',
                                `Amount` = '$EditAmount',
                                `ChallanEditDate` = '$CurrentDate',
                                `EditID` = '".$SessionID."'
                                WHERE `ChallanID` = '$ChallanID' ");
       $ChallanEditUpdate->execute();                         

     ## QUERY :: SUCCESS ::
     if($ChallanEditUpdate){
        @header("location: ChallanEdit.php?msg=success&ChallanInvoice=$ChallanInvoice");
            } //clsoe qry if brace
        else{
        @header("location: ChallanEdit.php?msg=error&ChallanInvoice=$ChallanInvoice");
            }		
            
            
            
            }else{
                @header("location: ChallanEdit.php?msg=error&ChallanInvoice=$ChallanInvoice");
            } //ELSE



    }

}
?>