<?php
require_once("auth.php");
include("db.php");
include("count.php");
//CAll Permission
include("MenuPermission.php");
if(MenuPermission('17',$conn,$SessionID) == 0){ 
header("Location: PageNotFound.php");
exit();
}


if(!empty($_POST['SupplierID']) && !empty($_POST['ItemCategoryID'])){

$SupplierID = $_POST['SupplierID'];
$ItemCategoryID = implode(",",$_POST['ItemCategoryID']);
$SupplierCategory = $_POST['SupplierCategory'];


}else if(!empty($_GET['SupplierID']) && !empty($_GET['ItemCategoryID'])){

$SupplierID = $_GET['SupplierID'];
$ItemCategoryID = implode(",",$_GET['ItemCategoryID']);
$SupplierCategory = $_GET['SupplierCategory'];

}else{

$SupplierID = "";
$ItemCategoryID = "";
$SupplierCategory = "";

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
                            <h1 class="m-0"><?php print $PageLevel = "Challan"; ?>
                                <?php if((!empty($_GET['msg']) && $_GET['msg']=='success')){ ?>
                                <small class="badge badge-success">Challan Added Successful</small>
                                <?php } ?>
                                <?php if((!empty($_GET['msg']) && $_GET['msg']=='error')){ ?>
                                <small class="badge badge-danger">Challan Added Failed</small>
                                <?php } ?>

                                <?php if((!empty($_GET['msg']) && $_GET['msg']=='SupplierCategoryDuplicate')){ ?>
                                <small class="badge badge-danger">Sorry Duplicate Supplier Category  </small>
                                <?php } ?>

                                <?php if((!empty($_GET['msg']) && $_GET['msg']=='SupplierIDDuplicate')){ ?>
                                <small class="badge badge-danger">Sorry Duplicate Supplier Info  </small>
                                <?php } ?>

                                <?php if((!empty($_GET['msg']) && $_GET['msg']=='update')){ ?>
                                <small class="badge badge-warning">Challan Update Successful</small>
                                <?php } ?>

                                <?php if((!empty($_GET['msg']) && $_GET['msg']=='delete_success')){ ?>
                                <small class="badge badge-danger">Challan Delete Successful</small>
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
            <section class="content">
                <div class="container-fluid">
                    <form action="Challan.php" method="Post">
                        <!-- Info boxes -->
                        <div class="card card-default">
                            <div class="card">

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <!-- input states -->
                                            <div class="form-group">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Supplier Info</span>
                                                    </div><select class="form-control select2" id="SupplierID"
                                                        name="SupplierID" REQUIRED onchange="SupItemCategory();">
                                                        <option value="">Select Supplier</option>

                                                        <?php
$query = $conn->prepare("SELECT * FROM `Supplier` WHERE `Status` = 'Active' ORDER BY `Name` ASC");
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

                                            </div>

                                        </div>


                                        <div class="col-md-6">
                                            <!-- input states -->
                                            <div class="form-group" id="loadItemCategory">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Item Category
</span>
                                                    </div><select class="form-control select2" multiple REQUIRED
                                                        id="ItemCategoryID" Name="ItemCategoryID[]">
                                                        <?php
$ItemCategoryIDSelected = explode(",",$ItemCategoryID);

$query = $conn->prepare("SELECT * FROM `ItemCategory` WHERE `Status` = 'Active' AND  `SupplierID` = '$SupplierID' ORDER BY `Name` ASC");
$query->execute();
$FetchSupplierData = $query->fetchAll(PDO::FETCH_ASSOC);
foreach($FetchSupplierData AS $Fetch) {

?>
                                                        <option value="<?php print $Fetch['ItemCategoryID']; ?>"
                                                            <?php if(in_array($Fetch['ItemCategoryID'], $ItemCategoryIDSelected)){ print "Selected"; } ?>>
                                                            <?php print $Fetch['Name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- input states -->
                                            <div class="form-group">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Supplier
                                                            Supplier Category</span>
                                                    </div><select class="form-control select2" id="SupplierCategory"
                                                        name="SupplierCategory" REQUIRED>
                                                        <option value="">Select Supplier Supplier Category</option>
                                                        <option value="Factory"
                                                            <?php if($SupplierCategory=='Factory'){ print "Selected"; } ?>>
                                                            Factory</option>
                                                        <option value="Depot"
                                                            <?php if($SupplierCategory=='Depot'){ print "Selected"; } ?>>
                                                            Depot</option>
                                                    </select>
                                                </div>



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
if(!empty($SupplierID) && !empty($ItemCategoryID) && !empty($SupplierCategory)){  
?>
                    <form action="ChallanCartAction.php" method="POST" onSubmit="document.getElementById('AddCart').disabled=true;">
                        <input type="hidden" name="SupplierCategory" value="<?php print $SupplierCategory; ?>">
                        <input type="hidden" name="SupplierID" value="<?php print $SupplierID; ?>">

                        <div class="container-fluid">
                            <!-- Info boxes -->
                            <div class="card card-default">


                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table class="table table-bordered table-striped">

                                        <tr>
                                            <th></th>
                                            <th> Pack size </th>
                                            <th> Qty </th>
                                            <th> Rate </th>
                                            <th> Amount </th>
                                            <th> Remarks </th>
                                        </tr>

                                        <?php



$QueryProduct = $conn->prepare("SELECT A.*,B.`Rate`,C.`Name` AS `ItemCategory` FROM `PackageSize` A  
LEFT JOIN PurchaseRate B ON (A.`PackageSizeID` = B.`PackageSizeID` AND A.`SupplierID` = B.`SupplierID` AND A.`ItemCategoryID` = B.`ItemCategoryID` AND B.`SupplierCategory` = '$SupplierCategory')
LEFT JOIN ItemCategory C ON (A.`ItemCategoryID` = C.`ItemCategoryID`)
WHERE A.`SupplierID`='$SupplierID' AND A.`ItemCategoryID` IN ($ItemCategoryID) AND A.`status` = 'Active'  ORDER BY A.`Thickness` ASC");
$QueryProduct->execute();
$FetchSupplierData = $QueryProduct->fetchAll(PDO::FETCH_ASSOC);
foreach($FetchSupplierData AS $FetchProduct) {

?>
                                        <input type="hidden"
                                            name="ItemCategoryID<?php echo $FetchProduct['PackageSizeID']; ?>"
                                            value="<?php echo $FetchProduct['ItemCategoryID']; ?>">

                                        <tr>
                                            <td><input class="item_info" type="checkbox" name="PackageSizeID[]"
                                                    id="p_code<?php echo $FetchProduct['PackageSizeID']; ?>"
                                                    value="<?php echo $FetchProduct['PackageSizeID']; ?>" /></td>

                                            <td align="left">
                                                <font color="#2A0000"> <?php echo $FetchProduct['ItemCategory']; ?>
                                                    &times; <?php echo $FetchProduct['Thickness']; ?> &times;
                                                    <?php echo $FetchProduct['Size']; ?> </font>
                                            </td>

                                            <td><input type="text" <?php print $NumberValidity; ?> class="form-control"
                                                    maxlength="9"
                                                    title="Quantity<?php echo $FetchProduct['PackageSizeID']; ?>"
                                                    name="Quantity<?php echo $FetchProduct['PackageSizeID']; ?>"
                                                    id="Quantity<?php echo $FetchProduct['PackageSizeID']; ?>"
                                                    onkeyup="checkbox('p_code<?php echo $FetchProduct['PackageSizeID']; ?>'),CartCalculate('<?php echo $FetchProduct['PackageSizeID']; ?>');"
                                                    placeholder="Quantity" value="" /> </td>

                                            <td><input type="text" <?php print $NumberValidity; ?> class="form-control"
                                                    maxlength="9"
                                                    title="Rate<?php echo $FetchProduct['PackageSizeID']; ?>"
                                                    name="Rate<?php echo $FetchProduct['PackageSizeID']; ?>"
                                                    id="Rate<?php echo $FetchProduct['PackageSizeID']; ?>"
                                                    onkeyup="checkbox('p_code<?php echo $FetchProduct['PackageSizeID']; ?>'),CartCalculate('<?php echo $FetchProduct['PackageSizeID']; ?>');"
                                                    placeholder="Rate" value="<?php echo $FetchProduct['Rate']; ?>" />
                                            </td>

                                            <td><input type="text" <?php print $NumberValidity; ?> class="form-control"
                                                    Readonly maxlength="9"
                                                    title="Amount<?php echo $FetchProduct['PackageSizeID']; ?>"
                                                    name="Amount<?php echo $FetchProduct['PackageSizeID']; ?>"
                                                    id="Amount<?php echo $FetchProduct['PackageSizeID']; ?>"
                                                    placeholder="Amount" value="0" /> </td>

                                            <td><input type="text" class="form-control" maxlength="9"
                                                    title="Remarks<?php echo $FetchProduct['PackageSizeID']; ?>"
                                                    name="Remarks<?php echo $FetchProduct['PackageSizeID']; ?>"
                                                    id="Remarks<?php echo $FetchProduct['PackageSizeID']; ?>"
                                                    onkeyup="checkbox('p_code<?php echo $FetchProduct['PackageSizeID']; ?>');"
                                                    placeholder="Remarks" value="" />

                                        </tr>

                                        <?php } // WHILE BRACE ?>
                                        <tr>
                                            <td colspan="6" align="right"><input type="submit" name="submit" id="AddCart"
                                                    value="Submit" class="btn btn-success" /></td>
                                        </tr>
                                    </table>

                                    <script>
                                        function CartCalculate(PackageSizeID) {
                                            var Quantity = document.getElementById('Quantity' + PackageSizeID).value;
                                            var Rate = document.getElementById('Rate' + PackageSizeID).value;
                                            var Amount = parseFloat(Quantity * Rate).toFixed(2);
                                            document.getElementById('Amount' + PackageSizeID).value = Amount;
                                        }
                                    </script>

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
                    <!-- Info boxes -->
                    <div class="card card-default">

                        <div class="card">

                            <!-- /.card-header -->
                            <div class="card-body" id="LoadCartList">

                                <?php include("ChallanCartList.php"); ?>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    </div>
                    <!--/. container-fluid -->
                </div>
                <!-- /.content-wrapper -->

                <div class="container-fluid">
                    <!-- Info boxes -->
                    <div class="card card-default">
                        <div class="card">

                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-6">
                                        <!-- input states -->
                                        <div class="form-group">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Challan Invoice</span>
                                                </div><input type="text" value="IU<?php print $SessionID; ?><?php print $InvoiceDate; ?>" class="form-control" id="ChallanInvoice">
                                            </div>


                                        </div>

                                    </div>

                                    <div class="col-md-4">
                                        <!-- input states -->
                                        <div class="form-group">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Challan Date</span>
                                                </div> <input type="date" class="form-control" id="ChallanDate"
                                                    value="<?php print $CurrentDate; ?>">
                                            </div>


                                        </div>

                                    </div>

                                    <div class="col-md-2">
                                        <div class="modal-footer">

                                            <input type="submit" id="ChallanFinal" name="ChallanFinal"
                                                onclick="ChallanFinal();" value="Challan Final" class="btn btn-warning">
                                        </div>
                                    </div>
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
    // LOAD Sub Item SupplierCategory
    function SupItemCategory() {
        //get the VALUE
        var SupplierIDMultiple = $('#SupplierID').val();
        var ChallanInvoice = $('#ChallanInvoice').val();
        // alert(SupplierID);

        document.getElementById('loadItemCategory').innerHTML = 'Loading...';
        //use ajax to run the check
        $.post("JsonValue.php", {
                SupplierIDMultiple: SupplierIDMultiple
            },
            function (result) {
                document.getElementById('loadItemCategory').innerHTML = result['loadItemCategory'];
                $("#ItemCategoryID").select2();
                document.getElementById('ChallanInvoice').value =ChallanInvoice + result['ChallanInvoice'];
                // alert(result);
            });
    }

    function ChallanFinal() {
        var ChallanInvoice = $('#ChallanInvoice').val();
        var ChallanDate = $('#ChallanDate').val();

        if (ChallanDate == '') {
            toastr.error('Please Select Challan Name !!!');
            playclip_warning();
            $('#ChallanDate').focus();
            return false;
        }

        if (ChallanInvoice == '') {
            toastr.error('Please Enter Challan Invoice !!!');
            playclip_warning();
            $('#ChallanInvoice').focus();
            return false;
        }

        // BEFORE RESPONSE
        $('#ChallanFinal').val('Please Wait...');
        $('#ChallanFinal').attr('disabled', true);

        //use ajax to run the check
        $.post("ChallanFinal.php", {
                ChallanInvoice: ChallanInvoice,
                ChallanDate: ChallanDate
            },
            function (result) {

                if (result == '200') {
                    toastr.success('Challan Final Successful');

                    $('#ChallanFinal').val('Challan Final');
                    $('#ChallanFinal').attr('disabled', false);
                    $("#LoadCartList").load("ChallanCartList.php", function () {
                        $('#example2').DataTable();
                    });
                    window.open('ChallanInvoice.php?ChallanInvoice=' + ChallanInvoice, 'Srarch View',
                        'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=1,resizable=yes,copyhistory=no,width=600,height=800'
                        );

                } else if (result == '404') {
                    toastr.error('Challan Cart Not Found !!!');
                    playclip_warning();
                    $('#ChallanFinal').val('Challan Final');
                    $('#ChallanFinal').attr('disabled', false);

                } else if (result == '102') {
                    toastr.error('Challan Invoice Already Exist !!!');
                    playclip_warning();
                    $('#ChallanFinal').val('Challan Final');
                    $('#ChallanFinal').attr('disabled', false);

                } else {
                    toastr.error(result);
                }
            }
        );


    }
</script>

</html>