<?php
require_once("auth.php");
include("db.php");
include("count.php");
//CAll Permission
include("MenuPermission.php");
if(MenuPermission('19',$conn,$SessionID) == 0){ 
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
                            <h1 class="m-0"><?php print $PageLevel = "Challan Return"; ?>
                            <?php if((!empty($_GET['msg']) && $_GET['msg']=='success')){ ?>
                            <small class="badge badge-success">Challan Return Added Successful</small>
                            <?php } ?>
                            <?php if((!empty($_GET['msg']) && $_GET['msg']=='error')){ ?>
                            <small class="badge badge-danger">Challan Return Added Failed</small>
                            <?php } ?>
                            <?php if((!empty($_GET['msg']) && $_GET['msg']=='update')){ ?>
                            <small class="badge badge-warning">Challan Return Update Successful</small>
                            <?php } ?>
                            <?php if((!empty($_GET['msg']) && $_GET['msg']=='delete_success')){ ?>
                            <small class="badge badge-danger">Challan Return Delete Successful</small>
                            <?php } ?>
                        </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><button class="btn btn-success" data-toggle="modal"
                                        data-target="#modal-default1" data-backdrop='static' data-keyboard='false'
                                        data-whatever="Package Size">Add New</button></li>
                                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                                <li class="breadcrumb-item"><a href="ChallanSales.php">Challan Return/Sales Menu</a></li>
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
                    <form action="ChallanReturn.php" method="Post">
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
                <form action="ChallanReturnAction.php" method="post">
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
                                                <th> Stock </th>
                                                <th> DO Rate </th>
                                                <th> Return Qty </th>
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
((IFNULL(A.`Quantity`,0) + IFNULL(G.`ReturnQuantity`,0)) - (IFNULL(D.`SalesQuantity`,0) + IFNULL(F.`ChallanReturnQty`,0))) AS `StockQty`,
A.`Rate`,
B.`Thickness`,
B.`Size`,
C.`Name`

FROM `Challan` A 
LEFT JOIN `PackageSize` B ON (A.`PackageSizeID` = B.`PackageSizeID`) 
LEFT JOIN `ItemCategory` C ON (A.`ItemCategoryID` = C.`ItemCategoryID`)
LEFT JOIN (SELECT sum(SalesQuantity) AS `SalesQuantity`, `ChallanID` FROM `CashMemo` GROUP BY `ChallanID`) D ON (A.`ChallanID` = D.`ChallanID`)

LEFT JOIN (SELECT sum(ReturnQuantity) AS `ChallanReturnQty`, `ChallanID` FROM `ChallanReturn` GROUP BY `ChallanID`) F ON (A.`ChallanID` = F.`ChallanID`)

LEFT JOIN (SELECT sum(ReturnQuantity) AS `ReturnQuantity`, `ChallanID` FROM `CashMemoReturn` GROUP BY `ChallanID`) G ON (A.`ChallanID` = G.`ChallanID`)

WHERE  A.`ChallanInvoice` = '".$ChallanInvoice."' AND 
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
                                                        name="ReturnQuantity<?php echo $FetchStock['ChallanID']; ?>"
                                                        id="ReturnQuantity<?php echo $FetchStock['ChallanID']; ?>"
                                                        onkeyup="CalculateCartAmount(<?php echo $FetchStock['ChallanID']; ?>),checkbox('p_code<?php echo $FetchStock['ChallanID']; ?>');"
                                                        placeholder="ReturnQuantity" value="0" /> </td>

                                                <td><input type="text" <?php print $NumberValidity; ?>
                                                        class="form-control input-sm"
                                                        name="ReturnRate<?php echo $FetchStock['ChallanID']; ?>"
                                                        onkeyup="CalculateCartAmount(<?php echo $FetchStock['ChallanID']; ?>),checkbox('p_code<?php echo $FetchStock['ChallanID']; ?>');"
                                                        id="ReturnRate<?php echo $FetchStock['ChallanID']; ?>"
                                                        placeholder="Return Rate"
                                                        value="<?php echo number_format($FetchStock['Rate'],2,'.',''); ?>" /> </td>

                                                <td><input type="text" class="form-control input-sm" readonly
                                                        name="ReturnAmount<?php echo $FetchStock['ChallanID']; ?>"
                                                        id="ReturnAmount<?php echo $FetchStock['ChallanID']; ?>"
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

                <?php } ?>
                <div class="container-fluid">
          <!-- Info boxes -->
          <div class="card card-default">

            <div class="card">
    
              <!-- /.card-header -->
              <div class="card-body" id="LoadCartList">
            
                <?php include("ChallanReturnCartList.php"); ?>
               
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
                                        <label class="col-form-label" for="inputSuccess">Challan Return Invoice</label>
                                        <input type="text" readonly class="form-control"
                                            id="ChallanReturnInvoice" >
                              
                                    </div>

                              </div>

                            <div class="col-md-4">
                                    <!-- input states -->
                                    <div class="form-group">
                                        <label class="col-form-label" for="inputSuccess">Challan Return Date</label>
                                        <input type="date" class="form-control"
                                            id="ChallanReturnDate" value="<?php print $CurrentDate; ?>"
                                           >
                              
                                    </div>

                                </div>

                                <div class="col-md-2">
                                            <div class="modal-footer">

                                                <input type="submit" id="ChallanReturnFinal" name="ChallanReturnFinal" onclick="ChallanReturnFinal();" value="Challan Return Final" class="btn btn-warning">
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
//auto Customer Due Receive Invoice load      
if(typeof(EventSource) !== "undefined") {
    var source = new EventSource("ChallanReturnInvoiceGenerate.php",{ withCredentials: true });
    source.onmessage = function(event) {
        var arr = event.data.split("~");
        document.getElementById("ChallanReturnInvoice").value = arr[0];
        // transfer_calculate();

    };

    } else {
    document.getElementById("ChallanReturnInvoice").value = "";
    }

function CalculateCartAmount(ChallanID) {

    var StockQty = $('#StockQty' + ChallanID).val();
    var ReturnQuantity = $('#ReturnQuantity' + ChallanID).val();
    var ReturnRate = $('#ReturnRate' + ChallanID).val();

    if (ReturnQuantity == '') {
        ReturnQuantity = 0;
    }

    if (ReturnRate == '') {
        ReturnRate = 0;
    }

    if (parseInt(ReturnQuantity) > parseInt(StockQty)) {
        toastr.error('Return Quantity is Greater Than Stock Quantity !!!');
        playclip_warning();
        $('#ReturnQuantity' + ChallanID).val(0);
        $('#ReturnAmount' + ChallanID).val(0);
        $('#Balance' + ChallanID).val(StockQty);
        return false;
    }

    var ReturnAmount = parseFloat(ReturnQuantity) * parseFloat(ReturnRate);
    $('#ReturnAmount' + ChallanID).val(parseFloat(ReturnAmount).toFixed(2));
    $('#Balance' + ChallanID).val(StockQty - ReturnQuantity);

    var ReturnAmount = 0;
    var ReturnQuantity = 0;
    var TotalBalance = 0;
    var TotalStockQty = 0;
    var TotalChallanRate = 0;

    $('.item_info:checked').each(function () {
        var id = $(this).attr('id');
        id = id.replace('p_code', '');
        ReturnAmount = parseFloat(ReturnAmount) + parseFloat($('#ReturnAmount' + id).val());
        ReturnQuantity = parseFloat(ReturnQuantity) + parseFloat($('#ReturnQuantity' + id).val());
        TotalBalance = parseFloat(TotalBalance) + parseFloat($('#Balance' + id).val());
        TotalStockQty = parseFloat(TotalStockQty) + parseFloat($('#StockQty' + id).val());
        ReturnAmount = parseFloat(ReturnAmount) + parseFloat($('#ReturnRate' + id).val());
    });

    $('#ReturnAmount').val(parseFloat(ReturnAmount).toFixed(2));	
    $('#ReturnQuantity').val(parseFloat(ReturnQuantity).toFixed(2));
    $('#TotalBalance').val(parseFloat(TotalBalance).toFixed(2));
    $('#TotalStockQty').val(parseFloat(TotalStockQty).toFixed(2));

}
function ChallanReturnFinal(){
    var ChallanReturnInvoice = $('#ChallanReturnInvoice').val();
    var ChallanReturnDate = $('#ChallanReturnDate').val();

    if (ChallanReturnDate == '') {
        toastr.error('Please Select Challan Return Name !!!');
        playclip_warning();
        $('#ChallanReturnDate').focus();
        return false;
    }

    if (ChallanReturnInvoice == '') {
        toastr.error('Please Enter Challan Return Invoice !!!');
        playclip_warning();
        $('#ChallanReturnInvoice').focus();
        return false;
    }

     // BEFORE RESPONSE
     $('#ChallanReturnFinal').val('Please Wait...');
     $('#ChallanReturnFinal').attr('disabled', true);

    //use ajax to run the check
    $.post("ChallanReturnFinal.php", {
        ChallanReturnInvoice: ChallanReturnInvoice,
            ChallanReturnDate: ChallanReturnDate
        },
        function (result) {
         
            if (result == '200') {
                toastr.success('Challan Return Final Successful');
                $('#ChallanReturnInvoice').val('');
                $('#ChallanReturnFinal').val('Challan Return Final');
                $('#ChallanReturnFinal').attr('disabled', false);

                window.open('ChallanReturnInvoice.php?ChallanReturnInvoice=' + ChallanReturnInvoice, 'Srarch View',
                        'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=1,resizable=yes,copyhistory=no,width=600,height=800'
                        );

                $("#LoadCartList").load("ChallanReturnCartList.php", function () {
                    $('#example2').DataTable();
                });

            }else if (result == '404') {
                toastr.error('Challan Return Cart Not Found !!!');
                playclip_warning();
                $('#ChallanReturnFinal').val('Challan Return Final');
                $('#ChallanReturnFinal').attr('disabled', false);

            }else if (result == '102'){
                toastr.error('Challan Return Invoice Already Exist !!!');
                playclip_warning();
                $('#ChallanReturnFinal').val('Challan Return Final');
                $('#ChallanReturnFinal').attr('disabled', false);
          
            } else {
                toastr.error(result);
            }
        }
        );

}
</script>

</html>