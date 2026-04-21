<?php
require_once("auth.php");
include("db.php");
include("count.php");
//CAll Permission
include("MenuPermission.php");
if(MenuPermission('32',$conn,$SessionID) == 0){ 
header("Location: PageNotFound.php");
exit();
}


if(!empty($_POST['ChallanInvoice'])){

    $ChallanInvoice = $_POST['ChallanInvoice'];

    }else if(!empty($_GET['ChallanInvoice'])){

    $ChallanInvoice = $_GET['ChallanInvoice'];

    }else{

    $ChallanInvoice = "";
    
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
                            <h1 class="m-0"><?php print $PageLevel = "Challan Edit"; ?>
                            <?php if((!empty($_GET['msg']) && $_GET['msg']=='success')){ ?>
                            <small class="badge badge-success">Challan Edit Update Successful</small>
                            <?php } ?>
                            <?php if((!empty($_GET['msg']) && $_GET['msg']=='error')){ ?>
                            <small class="badge badge-danger">Challan Edit Update Failed</small>
                            <?php } ?>
                            <?php if((!empty($_GET['msg']) && $_GET['msg']=='update')){ ?>
                            <small class="badge badge-warning">Challan Edit Update Successful</small>
                            <?php } ?>
                            <?php if((!empty($_GET['msg']) && $_GET['msg']=='delete_success')){ ?>
                            <small class="badge badge-danger">Challan Edit Delete Successful</small>
                            <?php } ?>
                        </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><button class="btn btn-success" data-toggle="modal"
                                        data-target="#modal-default1" data-backdrop='static' data-keyboard='false'
                                        data-whatever="Package Size">Add New</button></li>
                                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                                <li class="breadcrumb-item"><a href="Report.php">Report</a></li>
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
                    <form action="ChallanEdit.php" method="Post">
                        <!-- Info boxes -->
                        <div class="card card-default">
                            <div class="card">

                                <!-- /.card-header -->
                                <div class="card-body">
                 
                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- input states -->
                                            <div class="form-group">
                                                <label class="col-form-label" for="inputSuccess">Challan Invoice</label>
                                                <input type="text" class="form-control" id="ChallanInvoice"  name="ChallanInvoice" value="<?php print $ChallanInvoice; ?>" 
                                                <?php print $AutoComplete; ?>
                                                list="ChallanInvoiceList"
                                                OnKeyUp="ChallanInvoiceList();">

                                                <datalist id="ChallanInvoiceList"> </datalist>
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

                                </div>
                            </div>
                            <!-- /.card -->

                        </div>
                        <!--/. container-fluid -->
                    </form>

                </div>
                <!-- /.content-wrapper -->
                <div class="card">
<?php
if(!empty($ChallanInvoice)){  
?>
                <form action="ChallanEditAction.php" method="post">
                    <input type="hidden" name="ChallanInvoice" value="<?php print $ChallanInvoice; ?>">
    
        

                    <div class="container-fluid">
                        <!-- Info boxes -->
                        <div class="card card-default">

                            <div class="card">

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example2" class="table table-bordered table-striped">

                                        <thead>
                                            <tr>
                                                <th> Product Details & Challan No. </th>
                                                <th> Challan Qty</th>
                                                <th> DO Rate </th>
                                                <th> Edit Qty </th>
                                                <th> Rate </th>
                                                <th> Amount </th>
                                            </tr>
                                        </thead>
                                        <tbody>

<?php
$QueryStock = $conn->prepare("SELECT 

A.`ChallanID`,
A.`PackageSizeID`,
A.`ChallanInvoice`,
Date_Format(A.`ChallanDate`,'%d-%m-%Y') AS `ChallanDate`,
IFNULL(A.`Quantity`,0) AS `StockQty`,
A.`Rate`,
B.`Thickness`,
B.`Size`,
C.`Name`

FROM `Challan` A 
LEFT JOIN `PackageSize` B ON (A.`PackageSizeID` = B.`PackageSizeID`) 
LEFT JOIN `ItemCategory` C ON (A.`ItemCategoryID` = C.`ItemCategoryID`)
LEFT JOIN (SELECT sum(SalesQuantity) AS `SalesQuantity`, `ChallanID` FROM `CashMemo` GROUP BY `ChallanID`) D ON (A.`ChallanID` = D.`ChallanID`)

WHERE  A.`ChallanInvoice` = '".$ChallanInvoice."' AND 
`Cart` = 'Yes' AND A.`Status` = 'Active' 
ORDER BY C.`Name`,B.`Thickness`,B.`Size` ASC");
$QueryStock->execute();
$FetchStockData = $QueryStock->fetchAll(PDO::FETCH_ASSOC);
foreach($FetchStockData AS $FetchStock) {

?>

                                            <tr>
                                                <td>
                                                    <input type="hidden"
                                                        name="StockQty<?php echo $FetchStock['ChallanID']; ?>"
                                                        id="StockQty<?php echo $FetchStock['ChallanID']; ?>"
                                                        value="<?php echo $FetchStock['StockQty']; ?>">

                                                    <input type="hidden"
                                                        name="Balance<?php echo $FetchStock['ChallanID']; ?>"
                                                        id="Balance<?php echo $FetchStock['ChallanID']; ?>"
                                                        value="<?php echo $FetchStock['StockQty']; ?>">
                                                    <input type="hidden"
                                                        name="PackageSizeID<?php echo $FetchStock['ChallanID']; ?>"
                                                        id="PackageSizeID<?php echo $FetchStock['ChallanID']; ?>"
                                                        value="<?php echo $FetchStock['PackageSizeID']; ?>">

                                                    <input class="item_info" type="checkbox" name="ChallanID[]"
                                                        id="p_code<?php echo $FetchStock['ChallanID']; ?>"
                                                        value="<?php echo $FetchStock['ChallanID']; ?>" />
                                                    <font color="#2A0000"><?php echo $FetchStock['Name']; ?>
                                                        <?php echo $FetchStock['Thickness']; ?> &times;
                                                        <?php echo $FetchStock['Size']; ?></font> 
                                                    <br>Challan Date : <?php echo $FetchStock['ChallanDate']; ?>
                                                </td>

                                                <td align="center"> <?php echo $FetchStock['StockQty']; ?>
                                                </td>


                                                <td><input type="text" <?php print $NumberValidity; ?>
                                                        class="form-control input-sm" readonly
                                                        name="ChallanRate<?php echo $FetchStock['ChallanID']; ?>"
                                                        id="ChallanRate<?php echo $FetchStock['ChallanID']; ?>"
                                                        placeholder="Challan Rate"
                                                        value="<?php echo number_format($FetchStock['Rate'],2,'.',''); ?>" /> </td>

                                                <td><input type="text" <?php print $NumberValidity; ?>
                                                        class="form-control input-sm"
                                                        name="EditQuantity<?php echo $FetchStock['ChallanID']; ?>"
                                                        id="EditQuantity<?php echo $FetchStock['ChallanID']; ?>"
                                                        onkeyup="CalculateCartAmount(<?php echo $FetchStock['ChallanID']; ?>),checkbox('p_code<?php echo $FetchStock['ChallanID']; ?>');"
                                                        placeholder="EditQuantity" value="0" /> </td>

                                                <td><input type="text" <?php print $NumberValidity; ?>
                                                        class="form-control input-sm"
                                                        name="EditRate<?php echo $FetchStock['ChallanID']; ?>"
                                                        onkeyup="CalculateCartAmount(<?php echo $FetchStock['ChallanID']; ?>),checkbox('p_code<?php echo $FetchStock['ChallanID']; ?>');"
                                                        id="EditRate<?php echo $FetchStock['ChallanID']; ?>"
                                                        placeholder="Edit Rate"
                                                        value="<?php echo number_format($FetchStock['Rate'],2,'.',''); ?>" /> </td>

                                                <td><input type="text" class="form-control input-sm" readonly
                                                        name="EditAmount<?php echo $FetchStock['ChallanID']; ?>"
                                                        id="EditAmount<?php echo $FetchStock['ChallanID']; ?>"
                                                        value="0" /> </td>

                                            </tr>

                                            <?php 
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

                <?php } ?>
                <div class="container-fluid">

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
        <?php 
include("footer.php");
include("AccessLog.php");
?>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <?php include("RequiredJS.php"); ?>
</body>
<script>
function CalculateCartAmount(ChallanID) {

    var EditQuantity = $('#EditQuantity' + ChallanID).val();
    var EditRate = $('#EditRate' + ChallanID).val();

    EditAmount =parseFloat(EditQuantity * EditRate).toFixed(2);	
    parseFloat(document.getElementById("EditAmount" + ChallanID).value = EditAmount);

}
</script>

</html>