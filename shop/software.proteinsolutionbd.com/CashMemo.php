<?php
require_once("auth.php");
include("db.php");
include("count.php");
//CAll Permission
include("MenuPermission.php");
if(MenuPermission('18',$conn,$SessionID) == 0){ 
header("Location: PageNotFound.php");
exit();
}


if(!empty($_POST['SupplierID']) && !empty($_POST['ItemCategoryID'])){

$SupplierID = $_POST['SupplierID'];
$ItemCategoryID = implode(",",$_POST['ItemCategoryID']);
$SalesType = $_POST['SalesType'];

if(isset($_POST['CustomerName']) && !empty($_POST['CustomerName'])){ 
$CustomerName = $_POST['CustomerName'];
}else{
$CustomerName = "";
}
if(isset($_POST['CustomerAddress']) && !empty($_POST['CustomerAddress'])){
$CustomerAddress = $_POST['CustomerAddress'];
}else{
$CustomerAddress = "";
}

if(isset($_POST['CustomerID']) && !empty($_POST['CustomerID'])){
$CustomerID = $_POST['CustomerID'];
}else{
$CustomerID = "";
}

}else if(!empty($_GET['SupplierID']) && !empty($_GET['ItemCategoryID'])){

$SupplierID = $_GET['SupplierID'];
$ItemCategoryID = $_GET['ItemCategoryID'];
$SalesType = $_GET['SalesType'];
if(isset($_GET['CustomerName']) && !empty($_GET['CustomerName'])){
$CustomerName = $_GET['CustomerName'];
}else{
$CustomerName = "";
}
if(isset($_GET['CustomerAddress']) && !empty($_GET['CustomerAddress'])){
$CustomerAddress = $_GET['CustomerAddress'];
}else{
$CustomerAddress = "";
}

if(isset($_GET['CustomerID']) && !empty($_GET['CustomerID'])){
$CustomerID = $_GET['CustomerID'];
}else{
$CustomerID = "";
}

}else{

$SupplierID = "";
$ItemCategoryID = "";
$SalesType = "";
$CustomerName = "";
$CustomerAddress = "";
$CustomerID = "0";

}

?>
<!DOCTYPE html>
<html lang="en">
<?php include("head.php"); ?>

<script type="text/javascript">
    //  Checkbox Check 
    function checkbox(p_code) {
        // alert(p_code);
        document.getElementById(p_code).checked = true;

    }

    // LOAD Customer Balance
    function CustomerBalance() {
        //get the VALUE
        var CustomerID = arguments[0];
        if (CustomerID != 0) {


            document.getElementById('PreviousBalance').value = 'Loading...';
            //use ajax to run the check
            $.post("CustomerBalance.php", {
                    CustomerID: CustomerID
                },
                function (result) {
                    document.getElementById('PreviousBalance').value = result['CustomerBalance'];
                    CalculateAmount();
                });
        } else {
            document.getElementById('PreviousBalance').value = 0;
        }

    }
</script>

<body class="hold-transition layout-top-nav" onload="CustomerBalance('<?php print $CustomerID; ?>')">
    <div class="wrapper">

        <!-- Preloader -->
        <?php include("preloader.php"); ?>

        <!-- Navbar -->
        <?php include("navbar.php"); ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><?php print $PageLevel = "Cash Memo"; ?>
                                <?php if((!empty($_GET['msg']) && $_GET['msg']=='success')){ ?>
                                <small class="badge badge-success">Cash Memo Added Successful</small>
                                <?php } ?>
                                <?php if((!empty($_GET['msg']) && $_GET['msg']=='error')){ ?>
                                <small class="badge badge-danger">Cash Memo Added Failed</small>
                                <?php } ?>
                                <?php if((!empty($_GET['msg']) && $_GET['msg']=='update')){ ?>
                                <small class="badge badge-warning">Cash Memo Update Successful</small>
                                <?php } ?>
                                <?php if((!empty($_GET['msg']) && $_GET['msg']=='delete_success')){ ?>
                                <small class="badge badge-danger">Cash Memo Delete Successful</small>
                                <?php } ?>
                                <?php if((!empty($_GET['msg']) && $_GET['msg']=='AmountZero')){ ?>
                                <small class="badge badge-danger">Sorry Amount Zero Not Allowed</small>
                                <?php } ?>
                                <?php if((!empty($_GET['msg']) && $_GET['msg']=='ChallanDateEmpty')){ ?>
                                <small class="badge badge-danger">Sorry Challan Date Before Cash Memo Date Not Allowed !!! </small>
                                <?php } ?>
                            </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">

                                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                                <li class="breadcrumb-item"><a href="ChallanSales.php">Challan Sales Menu</a></li>
                                <li class="breadcrumb-item active"><?php print $PageLevel; ?></li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <script>
        function submitForm() {
            document.getElementById("clk").disabled = true;
        }
    </script>
            <section class="content">
                <div class="container-fluid">
                    <form action="CashMemo.php" method="Post">
                        <!-- Info boxes -->
                        <div class="card card-default">
                            <div class="card">

                                <!-- /.card-header -->
                                <div class="card-body">

                                    <!-- form start -->
                                    <div class="row">

                                        <div class="col-md-6">
                                            <!-- input states -->
                                            <div class="form-group">
                                                <b>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Customer Type</span>
                                                        </div><select class="form-control select2" id="SalesType"
                                                            name="SalesType" onchange="SalesCategory();" required>
                                                            <option value="">Select One</option>
                                                            <option value="Cash"
                                                                <?php if($SalesType=='Cash'){ print "Selected"; } ?>>
                                                                Cash
                                                            </option>
                                                            <option value="Due"
                                                                <?php if($SalesType=='Due'){ print "Selected"; } ?>>Due
                                                            </option>
                                                        </select>
                                                    </div>
                                            </div>
                                            </b>
                                        </div>
                                       
                                    </div>

                                    <!-- form start -->
                                    <div class="row" id="SalesCategoryLoad">
                                        <?php if($SalesType =='Cash'){ ?>

                                        <input type="hidden" id="CustomerId">

                                        <div class="col-md-6">
                                            <!-- input states -->
                                            <div class="form-group">
                                                <b>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Customer Name</span>
                                                        </div>
                                                        <input type="text" class="form-control" required  pattern="\S(.*\S)?"
                                                            name="CustomerName" id="CustomerName"
                                                            Value="<?php print $CustomerName; ?>">
                                                    </div>
                                                </b>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <!-- input states -->
                                            <div class="form-group">
                                                <b>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Customer Customer</span>
                                                        </div>
                                                        <input type="text" class="form-control" required
                                                            name="CustomerAddress" id="CustomerAddress"
                                                            Value="<?php print $CustomerAddress; ?>">
                                                    </div>
                                                </b>
                                            </div>
                                        </div>

                                        <?php } ?>

                                        <?php if($SalesType =='Due'){ ?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <b>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Customer Info.</span>
                                                        </div>
                                                        <select class="form-control select2" id="CustomerID"
                                                            name="CustomerID" required>
                                                            <option value="">Select One</option>
                                                            <?php 
$query = $conn->prepare("SELECT * FROM `Customer` WHERE `Status` = 'Active' ORDER BY `Name` ASC"); 
$query->execute();
$FetchListCust = $query->fetchAll(PDO::FETCH_ASSOC);
foreach($FetchListCust AS $Fetch) { ?>
                                                            <option value="<?php Print $Fetch['CustomerID']; ?>"
                                                                <?php if($CustomerID==$Fetch['CustomerID']){ print "Selected"; } ?>>
                                                                <?php Print $Fetch['CustomerID']; ?> -
                                                                <?php Print $Fetch['Name']; ?> -
                                                                <?php Print $Fetch['MobileNo']; ?> -
                                                                <?php Print $Fetch['Address']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>

                                                </b>
                                            </div>

                                        </div>
                                        <?php } ?>
                                    </div>
                                    <!-- form start -->
                                    <div class="row">

                                        <div class="col-md-6">
                                            <!-- input states -->
                                            <div class="form-group">
                                                <b>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Supplier Info</span>
                                                        </div><select class="form-control select2" id="SupplierID"
                                                            name="SupplierID" onchange="SupItemCategory();" required>
                                                            <option value="">Select Supplier</option>

                                                            <?php
$query = $conn->prepare("SELECT A.* FROM `Supplier` A 
JOIN (SELECT * FROM `Challan` WHERE `Status` = 'Active' AND `Cart` = 'Yes' AND `Quantity` != '0' GROUP BY `SupplierID` ) B ON (A.`SupplierID` = B.`SupplierID`) 
WHERE A.`Status` = 'Active' ORDER BY A.`Name` ASC");
$query->execute();
$FetchSupplierData = $query->fetchAll(PDO::FETCH_ASSOC);
foreach($FetchSupplierData AS $Fetch) {
?>
                                                            <option value="<?php print $Fetch['SupplierID']; ?>"
                                                                <?php if($SupplierID==$Fetch['SupplierID']){ print "Selected"; } ?>>
                                                                <?php print sprintf("%03d", $Fetch['SupplierID']); ?> |
                                                                <?php print $Fetch['Name']; ?> |
                                                                <?php print $Fetch['MobileNo']; ?> |
                                                                <?php print $Fetch['Address']; ?></option>
                                                            <?php } ?>
                                                        </select>

                                                    </div>

                                                </b>
                                            </div>

                                        </div>


                                        <div class="col-md-4">
                                        <div class="form-group" id="loadItemCategory">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Item Category</span>
                                                    </div><select class="form-control select2" multiple REQUIRED
                                                        id="ItemCategoryID" Name="ItemCategoryID[]">
                                                        <?php
$ItemCategoryIDSelected = explode(",",$ItemCategoryID);

$query = $conn->prepare("SELECT A.* FROM `ItemCategory` A
JOIN (SELECT * FROM `Challan` WHERE `Status` = 'Active' AND `Cart` = 'Yes' AND `Quantity` != '0' GROUP BY `ItemCategoryID` ) B ON (A.`ItemCategoryID` = B.`ItemCategoryID`) 
 WHERE A.`Status` = 'Active' AND  A.`SupplierID` = '$SupplierID' ORDER BY A.`Name` ASC");
$query->execute();
$FetchSupplierData = $query->fetchAll(PDO::FETCH_ASSOC);
foreach($FetchSupplierData AS $Fetch) {

?>
                                                        <option value="<?php print $Fetch['ItemCategoryID']; ?>"
                                                            <?php if(in_array($Fetch['ItemCategoryID'], $ItemCategoryIDSelected)){ print "Selected"; } ?>><?php print $Fetch['Name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="col-md-2">
                                            <input type="submit" id="Search" value="Search" style="text-align: center;"
                                                class="btn btn-info">
                                        </div>
                                    </div>


                                    </from>
                                    <!-- /.card -->

                                </div>
                            </div>
                            <!-- /.card -->

                        </div>
                        <!--/. container-fluid -->
                    </form>

                </div>
                <?php
if(!empty($SupplierID) && !empty($ItemCategoryID)){
if($SalesType =='Due'){
$QueryCustomerCategory = $conn->prepare("SELECT * FROM `Customer` WHERE `CustomerID` = '$CustomerID' AND `Status` = 'Active' ");
$QueryCustomerCategory->execute();
$FetchCustomerCategory = $QueryCustomerCategory->fetch(PDO::FETCH_ASSOC);
$CustomerCategoryID = $FetchCustomerCategory['CustomerCategoryID'];
}else{
$CustomerCategoryID = "1";
}
?>
                <!-- /.content-wrapper -->
                <form action="CashMemoAction.php" method="post" onSubmit="document.getElementById('AddCart').disabled=true;">
                    <input type="hidden" name="SupplierID" value="<?php print $SupplierID; ?>">
          
                    <input type="hidden" name="SalesType" value="<?php print $SalesType; ?>">
                    <input type="hidden" name="CustomerName" value="<?php print $CustomerName; ?>">
                    <input type="hidden" name="CustomerAddress" value="<?php print $CustomerAddress; ?>">
                    <input type="hidden" name="CustomerID" value="<?php print $CustomerID; ?>">
                    <input type="hidden" name="CustomerCategoryID" id="CustomerCategoryID"
                        value="<?php print $CustomerCategoryID; ?>">




                    <div class="container-fluid">
                        <!-- Info boxes -->
                        <div class="card card-default">

                            <div class="card">

                                <!-- /.card-header -->
                                <div class="card-body" id="LoadCartList">
                                    <table class="table table-bordered table-striped">

                                        <thead>
                                            <tr>
                                                <th> Product Details & Challan No. </th>
                                                <th> Stock </th>
                                                <th> DO Rate </th>
                                                <th> Sales Qty </th>
                                                <th> Rate </th>
                                                <th> Amount </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
$QueryStock = $conn->prepare("SELECT 

A.`ChallanID`,
A.`PackageSizeID`,
A.`ItemCategoryID`,
A.`ChallanInvoice`,
A.`ChallanDate`,
((IFNULL(A.`Quantity`,0) + IFNULL(G.`ReturnQuantity`,0)) - (IFNULL(D.`SalesQuantity`,0) + IFNULL(F.`ChallanReturnQty`,0))) AS `StockQty`,
A.`Rate`,
B.`Thickness`,
B.`Size`,
C.`Name`,
IFNULL(E.`SalesRate`,'0') AS `SalesRate`,
E.`CustomerCategoryID`

FROM `Challan` A 
LEFT JOIN `PackageSize` B ON (A.`PackageSizeID` = B.`PackageSizeID`) 
LEFT JOIN `ItemCategory` C ON (A.`ItemCategoryID` = C.`ItemCategoryID`)
LEFT JOIN (SELECT sum(SalesQuantity) AS `SalesQuantity`, `ChallanID` FROM `CashMemo` GROUP BY `ChallanID`) D ON (A.`ChallanID` = D.`ChallanID`)
LEFT JOIN (SELECT `Rate` AS `SalesRate`, `PackageSizeID`,`CustomerCategoryID` FROM `SalesRate` WHERE `CustomerCategoryID` = '$CustomerCategoryID' ) E ON (A.`PackageSizeID` = E.`PackageSizeID`)

LEFT JOIN (SELECT sum(ReturnQuantity) AS `ChallanReturnQty`, `ChallanID` FROM `ChallanReturn` GROUP BY `ChallanID`) F ON (A.`ChallanID` = F.`ChallanID`)

LEFT JOIN (SELECT sum(ReturnQuantity) AS `ReturnQuantity`, `ChallanID` FROM `CashMemoReturn` GROUP BY `ChallanID`) G ON (A.`ChallanID` = G.`ChallanID`)

WHERE A.`SupplierID` = '".$SupplierID."' AND A.`ItemCategoryID` IN ($ItemCategoryID) AND 
`Cart` = 'Yes' AND A.`Status` = 'Active' 
ORDER BY C.`Name`,B.`Thickness`,B.`Size` ASC");
$QueryStock->execute();
$FetchStockData = $QueryStock->fetchAll(PDO::FETCH_ASSOC);
foreach($FetchStockData AS $FetchStock) {

if ($FetchStock['StockQty'] =='0') {  
}else{
?>

                                            <tr>
                                                <td>
                                                    <input type="hidden"
                                                        name="StockQty<?php echo $FetchStock['ChallanID']; ?>"
                                                        id="StockQty<?php echo $FetchStock['ChallanID']; ?>"
                                                        value="<?php echo $FetchStock['StockQty']; ?>">

                                                        <input type="hidden"
                                                        name="ItemCategoryID<?php echo $FetchStock['ChallanID']; ?>"
                                                        id="ItemCategoryID<?php echo $FetchStock['ChallanID']; ?>"
                                                        value="<?php echo $FetchStock['ItemCategoryID']; ?>">

                                                        <input type="hidden"
                                                        name="ItemCategoryID<?php echo $FetchStock['ChallanID']; ?>"
                                                        id="ItemCategoryID<?php echo $FetchStock['ChallanID']; ?>"
                                                        value="<?php echo $FetchStock['ItemCategoryID']; ?>">
                                                    <input type="hidden"
                                                        name="ChallanDate<?php echo $FetchStock['ChallanID']; ?>"
                                                        id="ChallanDate<?php echo $FetchStock['ChallanID']; ?>"
                                                        value="<?php echo $FetchStock['ChallanDate']; ?>">
                                                    <input type="hidden"
                                                        name="PackageSizeID<?php echo $FetchStock['ChallanID']; ?>"
                                                        id="PackageSizeID<?php echo $FetchStock['ChallanID']; ?>"
                                                        value="<?php echo $FetchStock['PackageSizeID']; ?>">

                                                        <input type="hidden"
                                                        name="Balance<?php echo $FetchStock['ChallanID']; ?>"
                                                        id="Balance<?php echo $FetchStock['ChallanID']; ?>"
                                                        value="">

                                                    <input class="item_info" type="checkbox" name="ChallanID[]"
                                                        id="p_code<?php echo $FetchStock['ChallanID']; ?>"
                                                        value="<?php echo $FetchStock['ChallanID']; ?>" />
                                                    <font color="#2A0000"><?php echo $FetchStock['Name']; ?>
                                                        <?php echo $FetchStock['Thickness']; ?> &times;
                                                        <?php echo $FetchStock['Size']; ?></font> @ <font
                                                        color="#FF33FF" title="Challan Invoice">
                                                        <?php echo $FetchStock['ChallanInvoice']; ?> </font>
                                                    <br>Challan Date : <?php Print date("d-m-Y",strtotime($FetchStock['ChallanDate'])); ?>
                                                </td>

                                                <td align="center"> <?php echo $FetchStock['StockQty']; ?>
                                                </td>


                                                <td><input type="text" <?php print $NumberValidity; ?>
                                                        class="form-control input-sm" readonly
                                                        name="ChallanRate<?php echo $FetchStock['ChallanID']; ?>"
                                                        id="Rate<?php echo $FetchStock['ChallanID']; ?>"
                                                        placeholder="Challan Rate"
                                                        value="<?php echo number_format($FetchStock['Rate'],2,'.',''); ?>" />
                                                </td>

                                                <td><input type="text" <?php print $NumberValidity; ?>
                                                        class="form-control input-sm"
                                                        name="SalesQuantity<?php echo $FetchStock['ChallanID']; ?>"
                                                        id="SalesQuantity<?php echo $FetchStock['ChallanID']; ?>"
                                                        onkeyup="CalculateCartAmount(<?php echo $FetchStock['ChallanID']; ?>),checkbox('p_code<?php echo $FetchStock['ChallanID']; ?>');"
                                                        placeholder="SalesQuantity" value="0" /> </td>

                                                <td><input type="text" <?php print $NumberValidity; ?>
                                                        class="form-control input-sm"
                                                        name="SalesRate<?php echo $FetchStock['ChallanID']; ?>"
                                                        onkeyup="CalculateCartAmount(<?php echo $FetchStock['ChallanID']; ?>),checkbox('p_code<?php echo $FetchStock['ChallanID']; ?>');"
                                                        id="SalesRate<?php echo $FetchStock['ChallanID']; ?>"
                                                        placeholder="Sales Rate"
                                                        value="<?php echo $FetchStock['SalesRate']; ?>" /> </td>

                                                <td><input type="text" class="form-control input-sm" readonly
                                                        name="SalesAmount<?php echo $FetchStock['ChallanID']; ?>"
                                                        id="SalesAmount<?php echo $FetchStock['ChallanID']; ?>"
                                                        value="0" /> </td>

                                            </tr>

                                            <?php 
} // IF BRACE
} // WHILE BRACE 
?>
                                        </tbody>
                                        <tfoot>
                                        </tfoot>
                                    </table>
                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="modal-footer">
                                                <input type="submit" name="submit" id="AddCart" value="Submit"
                                                    class="btn btn-success" />
                                            </div>
                                        </div>
                                        </from>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->

                        </div>
                        <!--/. container-fluid -->
                        <!-- /.content -->
                    </div>
                    <!-- /.content-wrapper -->
                </form>
<?php } // IF BRACE
?>
                <div class="container-fluid">
                    <!-- Info boxes -->
                    <div class="card card-default">

                        <div class="card">

                            <!-- /.card-header -->
                            <div class="card-body" id="LoadCartList">

                                <?php include("CashMemoList.php"); ?>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    </div>
                    <!--/. container-fluid -->
                </div>
                <!-- /.content-wrapper -->

                <?php

if($TotalAmount != '0'){
?>
                <div class="container-fluid">
                    <!-- Info boxes -->
                    <div class="card card-default">

                        <div class="card">

                            <!-- /.card-header -->
                            <div class="card-body">
                            <small
                                                    class="badge badge-warning" id="pay_mode"> </small>
                                <div class="row">

                                    <div class="col-md-3">
                                        <!-- input states -->
                                        <div class="form-group">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Sales Invoice</span>
                                                </div>
                                                <input type="text" class="form-control"
                                                    style=" font-weight: bold; text-align: right;" id="CashMemoInvoice"
                                                    readonly>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-3">
                                        <!-- input states -->
                                        <div class="form-group">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Previous Balance</span>
                                                </div>
                                                <input type="text" class="form-control" id="PreviousBalance" readonly
                                                    value="0" style=" font-weight: bold; text-align: right; color:red;">
                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-3">
                                        <!-- input states -->
                                        <div class="form-group">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Total Invoice TK</span>
                                                </div>
                                                <input type="text" class="form-control"
                                                    value="<?php echo number_format($TotalAmount,2,'.',''); ?>"
                                                    style=" font-weight: bold; text-align: right;" id="TotalAmount"
                                                    readonly>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Transaction Type</span>
                                                </div><select class="form-control select2" id="TransactionType"
                                                    onchange="ReceiveMode();">
                                                    <option value="">Select One</option>
                                                    <?php if(!empty($CustomerID)){ ?>
                                                    <option value="Due" >Due</option>
                                                    <?php } ?>
                                                    <?php if(empty($CustomerID)){ ?>
                                                    <option value="Wallet">Wallet</option>
                                                    <option value="Bank">Bank</option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                        </div>
                                    </div>




                                    <input type="hidden" class="form-control" <?php print $QtyCheck; ?>
                                                    value="0" onkeyup="CalculateDiscountPercentage();"
                                                    style=" font-weight: bold; text-align: right;" Value="0"
                                                    id="DiscountPercentage">

                                    <input type="hidden" class="form-control" <?php print $QtyCheck; ?>
                                    value="0" onkeyup="CalculateAmount();"
                                    style=" font-weight: bold; text-align: right;" Value="0"
                                    id="Discount">
                                    <!-- <div class="col-md-3"> -->
                                        <!-- input states -->
                                        <!-- <div class="form-group">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Discount %</span>
                                                </div>
                                            </div>


                                        </div>

                                    </div> -->

                                    <!-- <div class="col-md-3"> -->
                                        <!-- input states -->
                                        <!-- <div class="form-group">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Discount Amount</span>
                                                </div>
                                            </div>

                                        </div>

                                    </div> -->

                                    <div class="col-md-6">
                                        <!-- input states -->
                                        <div class="form-group">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Receive Amount</span>
                                                </div> <input type="hidden" id="GetWalletID" value="">
                                                <input type="hidden" id="GetBankID" value="">
                                                <input type="hidden" id="ReceiveName" value="Due">

                                                <input type="text" class="form-control" id="ReceiveAmount"  <?php if(!empty($CustomerID)){ print "readonly"; } ?>
                                                    <?php print $QtyCheck; ?> value="0" onkeyup="CalculateAmount();"
                                                    style="font-weight: bold; text-align: right;"
                                                    placeholder="Enter Receive Amount">
                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-3">
                                        <!-- input states -->
                                        <div class="form-group">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Due</span>
                                                </div><input type="text" readonly class="form-control"
                                                    style=" font-weight: bold; text-align: right; color:red;" Value="<?php echo number_format($TotalAmount,2,'.',''); ?>"
                                                    id="TotalDue">
                                            </div>


                                        </div>

                                    </div>

                                    <div class="col-md-3">
                                        <!-- input states -->
                                        <div class="form-group">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Date</span>
                                                </div> <input type="date" class="form-control" id="CashMemoDate"
                                                    readonly value="<?php print $CurrentDate; ?>">
                                            </div>

                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                  

                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Remarks</span>
                                                </div> <input type="text" style="border-color: #dd4b39;" id="Remarks" class="form-control input-lg">
                                            </div>

                                        </div>

                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">

                                            <input type="submit" value="&nbsp; &nbsp; &nbsp;View Memo&nbsp; &nbsp; &nbsp;" id="ViewMemo" name="ViewMemo"
                                                onclick="InvoiceView();" class="btn btn-warning">
                                            <input type="submit" value="&nbsp; &nbsp; &nbsp; Create Memo&nbsp; &nbsp; &nbsp; " id="CreateMemo" name="CreateMemo"
                                                onclick="CreateMemo();" class="btn btn-success">


                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->

                            </div>
                            <!--/. container-fluid -->
                        </div>
                        <!-- /.content-wrapper -->
                       
            </section>
            <!-- /.content -->

            <!-- Custom JS -->
            <script src="InsertJS.js"></script>
            <script src="UpdateJS.js"></script>


            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
        <!-- Main Footer -->
    </div>
    <!-- ./wrapper -->

    <?php 
} // IF BRACE

include("footer.php");
include("AccessLog.php");
?>

    <?php
//All Modals
include("CashMemoModal.php");
?>
    <!-- REQUIRED SCRIPTS -->
    <?php include("RequiredJS.php");?>
</body>
<script src="CashMemo.JS"></script>

</body>

</html>