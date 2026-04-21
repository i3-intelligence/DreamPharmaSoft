<?php
require_once("auth.php");
include("db.php");
include("count.php");
//CAll Permission
include("MenuPermission.php");
if(MenuPermission('20',$conn,$SessionID) == 0){ 
header("Location: PageNotFound.php");
exit();
}


if(!empty($_POST['CashMemoInvoice'])){

$CashMemoInvoice  = $_POST['CashMemoInvoice'];

}else if(!empty($_GET['CashMemoInvoice'])){

$CashMemoInvoice = $_GET['CashMemoInvoice'];

}else{

$CashMemoInvoice = "";

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
</script>

<body class="hold-transition layout-top-nav">
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
                            <h1 class="m-0"><?php print $PageLevel = "Cash Memo Return"; ?>
                                <?php if((!empty($_GET['msg']) && $_GET['msg']=='success')){ ?>
                                <small class="badge badge-success">Cash Memo Return Added Successful</small>
                                <?php } ?>
                                <?php if((!empty($_GET['msg']) && $_GET['msg']=='error')){ ?>
                                <small class="badge badge-danger">Cash Memo Return Added Failed</small>
                                <?php } ?>
                                <?php if((!empty($_GET['msg']) && $_GET['msg']=='update')){ ?>
                                <small class="badge badge-warning">Cash Memo Return Update Successful</small>
                                <?php } ?>
                                <?php if((!empty($_GET['msg']) && $_GET['msg']=='delete_success')){ ?>
                                <small class="badge badge-danger">Cash Memo Return Delete Successful</small>
                                <?php } ?>
                            </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><button class="btn btn-success" data-toggle="modal"
                                        data-target="#modal-default1" data-backdrop='static' data-keyboard='false'
                                        data-whatever="Package Size">Add New</button></li>
                                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                                <li class="breadcrumb-item"><a href="added.php">Added Menu</a></li>
                                <li class="breadcrumb-item active"><?php print $PageLevel; ?></li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <form action="CashMemoReturn.php" method="Post">
                        <!-- Info boxes -->
                        <div class="card card-default">
                            <div class="card">

                                <!-- /.card-header -->
                                <div class="card-body">

                                <div class="row">
                                        <div class="col-md-6">
                                            <!-- input states -->
                                            <div class="form-group">
                                                <label class="col-form-label" for="inputSuccess">Cash Memo Invoice</label>

                                                <input type="text" class="form-control" id="CashMemoInvoice"  name="CashMemoInvoice" value="<?php print $CashMemoInvoice; ?>" 
                                                <?php print $AutoComplete; ?>
                                                list="CashMemoInvoiceList"
                                                OnKeyUp="CashMemoInvoiceList();">

                                                <datalist id="CashMemoInvoiceList"> </datalist>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="modal-footer">

                                                <input type="submit" id="Search" value="Search" class="btn btn-info">
                                            </div>
                                        </div>
                                        </from>
                                    </div>
                                    <!-- /.card -->
                                        </from>
                                   
                                    <!-- /.card -->

                                </div>
                            </div>
                            <!-- /.card -->

                        </div>
                        <!--/. container-fluid -->
                    </form>

                </div>
             
                <!-- /.content-wrapper -->
                <form action="CashMemoReturnAction.php" method="post">
                    <input type="hidden" name="CashMemoInvoice" value="<?php print $CashMemoInvoice; ?>">




                    <div class="container-fluid">
                        <!-- Info boxes -->
                        <div class="card card-default">

                            <div class="card">

                                <!-- /.card-header -->
                                <div class="card-body" id="LoadCartList">
                                    <table id="example2" class="table table-bordered table-striped">
<?php
if(!empty($CashMemoInvoice)){
$QurryInvoice = $conn->prepare("SELECT * FROM `CashMemo` WHERE `CashMemoInvoice` = '$CashMemoInvoice' ");
$QurryInvoice->execute();
$Fetch = $QurryInvoice->fetch(PDO::FETCH_ASSOC);

$QurryCustomer = $conn->prepare("SELECT CONCAT(`Name`,' - ' , `MobileNo` , ' - ',`Address`) AS `CustomerInfo`,`CustomerID` FROM `Customer` WHERE `CustomerID` = '$Fetch[CustomerID]' ");
$QurryCustomer->execute();
$FetchCustomer = $QurryCustomer->fetch(PDO::FETCH_ASSOC);

if(!empty($Fetch['CustomerID'])){
$CustomerInfo = $FetchCustomer['CustomerInfo'];
$CustomerID = $FetchCustomer['CustomerID'];
}else if(!empty($Fetch['CustomerName'])){
$CustomerInfo = $Fetch['CustomerName']." - ".$Fetch['CustomerAddress'];
$CustomerID = "";
}else{
$CustomerInfo = "";
$CustomerID = "";

}

?>
                                        <thead>
                                            <tr>
                                                <th colspan="6" style="text-align: center;">
                                                    <h5><?php print $CustomerInfo; ?> >> Date : <?php print date("d/m/y",strtotime($Fetch['CashMemoDate'])); ?>>>Cash Memo Return </h5>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th> Product Details & Challan No. </th>
                                                <th> Sales Balance </th>
                                                <th> Sales Rate </th>
                                                <th> Return Qty </th>
                                                <th> Return Rate </th>
                                                <th> Amount </th>
                                            </tr>
                                        </thead>
                                        <tbody>

<?php
$QueryStock = $conn->prepare("SELECT 

A.`CashMemoID`,
A.`PackageSizeID`,
A.`CashMemoInvoice`,
Date_Format(A.`CashMemoDate`,'%d-%m-%Y') AS `CashMemoDate`,
(IFNULL(A.`SalesQuantity`,0)  -  IFNULL(G.`ReturnQuantity`,0)) AS `StockQty`,
A.`SalesRate`,
B.`Thickness`,
B.`Size`,
C.`Name`

FROM `CashMemo` A 
LEFT JOIN `PackageSize` B ON (A.`PackageSizeID` = B.`PackageSizeID`) 
LEFT JOIN `ItemCategory` C ON (A.`ItemCategoryID` = C.`ItemCategoryID`)

LEFT JOIN (SELECT sum(ReturnQuantity) AS `ReturnQuantity`, `CashMemoID` FROM `CashMemoReturn` GROUP BY `CashMemoID`) G ON (A.`CashMemoID` = G.`CashMemoID`)

WHERE  A.`CashMemoInvoice` = '".$CashMemoInvoice."' AND 
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
                                                        name="StockQty<?php echo $FetchStock['CashMemoID']; ?>"
                                                        id="StockQty<?php echo $FetchStock['CashMemoID']; ?>"
                                                        value="<?php echo $FetchStock['StockQty']; ?>">

                                                    <input type="hidden"
                                                        name="Balance<?php echo $FetchStock['CashMemoID']; ?>"
                                                        id="Balance<?php echo $FetchStock['CashMemoID']; ?>"
                                                        value="<?php echo $FetchStock['StockQty']; ?>">
                                                    <input type="hidden"
                                                        name="PackageSizeID<?php echo $FetchStock['CashMemoID']; ?>"
                                                        id="PackageSizeID<?php echo $FetchStock['CashMemoID']; ?>"
                                                        value="<?php echo $FetchStock['PackageSizeID']; ?>">

                                                    <input class="item_info" type="checkbox" name="CashMemoID[]"
                                                        id="p_code<?php echo $FetchStock['CashMemoID']; ?>"
                                                        value="<?php echo $FetchStock['CashMemoID']; ?>" />
                                                    <font color="#2A0000"><?php echo $FetchStock['Name']; ?>
                                                        <?php echo $FetchStock['Thickness']; ?> &times;
                                                        <?php echo $FetchStock['Size']; ?></font> 
                                                    <br>Cash Memo Invoice Date : <?php echo $FetchStock['CashMemoDate']; ?>
                                                </td>

                                                <td align="center"> <?php echo $FetchStock['StockQty']; ?>
                                                </td>


                                                <td><input type="text" <?php print $NumberValidity; ?>
                                                        class="form-control input-sm" readonly
                                                        name="SalesRate<?php echo $FetchStock['CashMemoID']; ?>"
                                                        id="SalesRate<?php echo $FetchStock['CashMemoID']; ?>"
                                                        placeholder="Sales Rate"
                                                        value="<?php echo number_format($FetchStock['SalesRate'],2,'.',''); ?>" /> </td>

                                                <td><input type="text" <?php print $NumberValidity; ?>
                                                        class="form-control input-sm"
                                                        name="ReturnQuantity<?php echo $FetchStock['CashMemoID']; ?>"
                                                        id="ReturnQuantity<?php echo $FetchStock['CashMemoID']; ?>"
                                                        onkeyup="CalculateCartAmount(<?php echo $FetchStock['CashMemoID']; ?>),checkbox('p_code<?php echo $FetchStock['CashMemoID']; ?>');"
                                                        placeholder="ReturnQuantity" value="0" /> </td>

                                                <td><input type="text" <?php print $NumberValidity; ?>
                                                        class="form-control input-sm"
                                                        name="ReturnRate<?php echo $FetchStock['CashMemoID']; ?>"
                                                        onkeyup="CalculateCartAmount(<?php echo $FetchStock['CashMemoID']; ?>),checkbox('p_code<?php echo $FetchStock['CashMemoID']; ?>');"
                                                        id="ReturnRate<?php echo $FetchStock['CashMemoID']; ?>"
                                                        placeholder="Sales SalesRate"
                                                        value="<?php echo $FetchStock['SalesRate']; ?>" /> </td>

                                                <td><input type="text" class="form-control input-sm" readonly
                                                        name="ReturnAmount<?php echo $FetchStock['CashMemoID']; ?>"
                                                        id="ReturnAmount<?php echo $FetchStock['CashMemoID']; ?>"
                                                        value="0" /> </td>

                                            </tr>

                                            <?php 
    } // IF BRACE
                                        } // WHILE BRACE ?>
                                        </tbody>
                                        <tfoot>
                                        </tfoot>
                                    </table>
                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="modal-footer">
                                                <input type="submit" name="submit" value="Submit"
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

                <div class="container-fluid">
                    <!-- Info boxes -->
                    <div class="card card-default">

                        <div class="card">

                            <!-- /.card-header -->
                            <div class="card-body" id="LoadCartList">

                                <?php include("CashMemoReturnList.php"); ?>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    </div>
                    <!--/. container-fluid -->
                </div>
                <!-- /.content-wrapper -->

              <?php
              if($TotalAmount >= '1'){
              ?>  
                <div class="container-fluid">
                    <!-- Info boxes -->
                    <div class="card card-default">

                        <div class="card">

                            <!-- /.card-header -->
                            <div class="card-body" >

                            <div class="row">
                                           
                                           <div class="col-md-3">
                                                   <!-- input states -->
                                                   <div class="form-group">
                                                       <label class="col-form-label" for="inputSuccess">Return Invoice</label>
                                                       <input type="text" class="form-control"
                                                       style=" font-weight: bold; text-align: right;"
                                                           id="CashMemoReturnInvoice" readonly >
                                             
                                                   </div>
               
                                             </div>
               
               

                                            <div class="col-md-3">
                                            <!-- input states -->
                                            <div class="form-group">
                                            <label class="col-form-label" for="inputSuccess">Total Return TK</label>
                                            <input type="text" class="form-control" value="<?php echo number_format($TotalAmount,2,'.',''); ?>"
                                            style=" font-weight: bold; text-align: right;" 
                                            id="TotalAmount" readonly >

                                            </div>

                                            </div>
                                            <div class="col-md-3">
                                   <div class="form-group">
                                <label>Transaction Type</label>
                                    <select class="form-control select2" id="TransactionType"
                                        onchange="ReceiveMode();">
                                        <option value="" selected>Select One</option>
                                        <?php if(!empty($Fetch['CustomerID'])){ ?>
                                        <option value="Due" >Due</option>
                                        <?php } ?>
                                        <?php if(empty($Fetch['CustomerID'])){ ?>
                                        <option value="Wallet">Wallet</option>                                  
                                        <option value="Bank">Bank</option>
                                        <?php } ?>
                                    </select>
                                  </div>
                                </div>
                            
                          

                                <div class="col-md-3">
                                    <!-- input states -->
                                    <div class="form-group">
                                        <label class="col-form-label" for="inputSuccess"> Payment Amount <small class="badge badge-warning" id="pay_mode"> </small></label>
                                            <input type="hidden" id="GetWalletID" value="">
                                            <input type="hidden" id="GetBankID" value="">
                                            <input type="hidden" id="PaymentName" value="Due">
                                            <input type="hidden" id="CustomerID" value="<?php print $CustomerID; ?>">
                                        <input type="text" class="form-control" 
                                            id="PaymentAmount" <?php if(!empty($Fetch['CustomerID'])){ print "readonly"; } ?> <?php print $QtyCheck; ?> value="0" onkeyup="CalculateAmount();"
                                            style="font-weight: bold; text-align: right;"
                                            placeholder="Enter Payment Amount">
                                    </div>

                                </div>
                            </div>  

                            <div class="row">
                            <div class="col-md-3">
                                    <!-- input states -->
                                    <div class="form-group">
                                        <label class="col-form-label" for="inputSuccess">Due</label>
                                        <input type="text" readonly class="form-control"
                                        style=" font-weight: bold; text-align: right; color:red;" Value="<?php print number_format(($TotalAmount),2,'.',''); ?>" id="TotalDue" >
                              
                                    </div>

                              </div>

                            <div class="col-md-3">
                                    <!-- input states -->
                                    <div class="form-group">
                                        <label class="col-form-label" for="inputSuccess">Date</label>
                                        <input type="date" class="form-control"
                                            id="CashMemoReturnDate" value="<?php print $CurrentDate; ?>"
                                           >
                              
                                    </div>

                                </div>
                            <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-form-label" for="inputSuccess">Remarks</label>

                                        <textarea id="Remarks" class="form-control"></textarea>
                                    </div>

                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="submit" value="Create Memo" id="CreateCashMemoReturn" name="CreateCashMemoReturn" onclick="CreateCashMemoReturn();" class="btn btn-success">


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
        } // IF BRACE
        
include("footer.php");
include("AccessLog.php");
?>

   <?php
//All Modals
include("CashMemoReturnModal.php");
?>
  <!-- REQUIRED SCRIPTS -->
  <?php include("RequiredJS.php");?>
</body>
<script src="CashMemoReturn.JS"></script>

</body>

</html>