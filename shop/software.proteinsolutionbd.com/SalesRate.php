<?php
require_once("auth.php");
include("db.php");
include("count.php");
//CAll Permission
include("MenuPermission.php");
if(MenuPermission('10',$conn,$SessionID) == 0){ 
header("Location: PageNotFound.php");
exit();
}

if(!empty($_POST['SupplierID']) && !empty($_POST['ItemCategoryID'])){

$SupplierID = $_POST['SupplierID'];
$ItemCategoryID = $_POST['ItemCategoryID'];
$CustomerCategoryID = $_POST['CustomerCategoryID'];

}else if(!empty($_GET['SupplierID']) && !empty($_GET['ItemCategoryID'])){

$SupplierID = $_GET['SupplierID'];
$ItemCategoryID = $_GET['ItemCategoryID'];
$CustomerCategoryID = $_GET['CustomerCategoryID'];

}else{

$SupplierID = "";
$ItemCategoryID = "";
$CustomerCategoryID = "";

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
                            <h1 class="m-0"><?php print $PageLevel = "Sales Rate Setup"; ?>
                                <?php if((!empty($_GET['msg']) && $_GET['msg']=='success')){ ?>
                                <small class="badge badge-success">Sales Rate Added Successful</small>
                                <?php } ?>
                                <?php if((!empty($_GET['msg']) && $_GET['msg']=='error')){ ?>
                                <small class="badge badge-danger">Sales Rate Added Failed</small>
                                <?php } ?>
                                <?php if((!empty($_GET['msg']) && $_GET['msg']=='update')){ ?>
                                <small class="badge badge-warning">Sales Rate Update Successful</small>
                                <?php } ?>
                                <?php if((!empty($_GET['msg']) && $_GET['msg']=='delete_success')){ ?>
                                <small class="badge badge-danger">Sales Rate Delete Successful</small>
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
                    <form action="SalesRate.php" method="Post">
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
                                                    </div>

                                                    <select class="form-control select2" id="ItemCategoryID"
                                                        Name="ItemCategoryID">
                                                        <option value="">Select Item Category
</option>

                                                        <?php
$query = $conn->prepare("SELECT * FROM `ItemCategory` WHERE `Status` = 'Active' AND  `SupplierID` = '$SupplierID' ORDER BY `Name` ASC");
$query->execute();
$FetchSupplierData = $query->fetchAll(PDO::FETCH_ASSOC);
foreach($FetchSupplierData AS $Fetch) {
?>
                                                        <option value="<?php print $Fetch['ItemCategoryID']; ?>"
                                                            <?php if($ItemCategoryID==$Fetch['ItemCategoryID']){ print "Selected"; } ?>>
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
                                                        <span class="input-group-text">Customer Category</span>
                                                    </div>
                                                    <select class="form-control select2" id="CustomerCategoryID"
                                                        name="CustomerCategoryID">
                                                        <option value="">Select Customer Category</option>
                                                        <?php
$query = $conn->prepare("SELECT * FROM `CustomerCategory` WHERE `Status` = 'Active'  ORDER BY `Name` ASC");
$query->execute();
$FetchSupplierData = $query->fetchAll(PDO::FETCH_ASSOC);
foreach($FetchSupplierData AS $Fetch) {
?>
                                                        <option value="<?php print $Fetch['CustomerCategoryID']; ?>"
                                                            <?php if($CustomerCategoryID==$Fetch['CustomerCategoryID']){ print "Selected"; } ?>>
                                                            <?php print $Fetch['Name']; ?></option>
                                                        <?php } ?>
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
                <form action="SalesRateAction.php" method="post">
                    <input type="hidden" name="CustomerCategoryID" value="<?php print $CustomerCategoryID; ?>">
                    <input type="hidden" name="SupplierID" value="<?php print $SupplierID; ?>">
                    <input type="hidden" name="ItemCategoryID" value="<?php print $ItemCategoryID; ?>">



                    <div class="container-fluid">
                        <!-- Info boxes -->
                        <div class="card card-default">

                            <div class="card">

                                <!-- /.card-header -->
                                <div class="card-body" id="LoadCartList">
                                    <table id="example" class="table table-bordered table-striped">

                                        <tr>
                                            <th></th>
                                            <th> Pack size </th>
                                            <th> Rate </th>
                                        </tr>

                                        <?php
$QueryProduct = $conn->prepare("SELECT A.*,B.`Rate` FROM `PackageSize` A  
LEFT JOIN SalesRate B ON (A.`PackageSizeID` = B.`PackageSizeID` AND A.`SupplierID` = B.`SupplierID` AND A.`ItemCategoryID` = B.`ItemCategoryID` )
WHERE A.`SupplierID`='$SupplierID' AND A.`ItemCategoryID`='$ItemCategoryID'  
/*AND B.`CustomerCategoryID`='$CustomerCategoryID'*/ 
AND A.`status` = 'Active' GROUP BY A.`PackageSizeID` ORDER BY A.`PackageSizeID` DESC");
$QueryProduct->execute();
$FetchSupplierData = $QueryProduct->fetchAll(PDO::FETCH_ASSOC);
foreach($FetchSupplierData AS $FetchProduct) {

?>

                                        <tr>
                                            <td><input class="item_info" type="checkbox" name="PackageSizeID[]"
                                                    id="p_code<?php echo $FetchProduct['PackageSizeID']; ?>"
                                                    value="<?php echo $FetchProduct['PackageSizeID']; ?>" /></td>

                                            <td align="left">
                                                <font color="#2A0000"> <?php echo $FetchProduct['Thickness']; ?> &times;
                                                    <?php echo $FetchProduct['Size']; ?> </font>
                                            </td>


                                            <td><input type="text" <?php print $NumberValidity; ?> class="form-control"
                                                    maxlength="9"
                                                    title="Rate<?php echo $FetchProduct['PackageSizeID']; ?>"
                                                    name="Rate<?php echo $FetchProduct['PackageSizeID']; ?>"
                                                    id="Rate<?php echo $FetchProduct['PackageSizeID']; ?>"
                                                    onkeyup="checkbox('p_code<?php echo $FetchProduct['PackageSizeID']; ?>');"
                                                    placeholder="Rate" value="<?php echo $FetchProduct['Rate']; ?>" />
                                            </td>

                                        </tr>

                                        <?php } // WHILE BRACE ?>
                                        <tr>
                                            <td colspan="3" align="right"><input type="submit" name="submit"
                                                    value="Submit" class="btn btn-success" /></td>
                                        </tr>
                                    </table>

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

                                <?php include("SalesRateList.php"); ?>

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
        <?php 
include("footer.php");
include("AccessLog.php");
?>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <?php include("RequiredJS.php");?>
</body>
<script>
    // LOAD Sub Item Category
    function SupItemCategory() {
        //get the VALUE
        var SupplierID = $('#SupplierID').val();
        // alert(SupplierID);

        document.getElementById('loadItemCategory').innerHTML = 'Loading...';
        //use ajax to run the check
        $.post("JsonValue.php", {
                SupplierID: SupplierID
            },
            function (result) {
                document.getElementById('loadItemCategory').innerHTML = result['loadItemCategory'];
                $("#ItemCategoryID").select2();
            });
    }
</script>

</html>