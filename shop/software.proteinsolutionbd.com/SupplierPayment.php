<?php
require_once("auth.php");
include("db.php");
include("count.php");
//CAll Permission
include("MenuPermission.php");
if(MenuPermission('16',$conn,$SessionID) == 0){ 
  header("Location: PageNotFound.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include("head.php"); ?>


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
                            <h1 class="m-0"><?php print $PageLevel = "Supplier Payment"; ?></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="Payment.php">Payment Menu</a></li>
                            <li class="breadcrumb-item active"><?php print $PageLevel; ?>
                            </li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Info boxes -->
                    <div class="card card-default">

                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Supplier Info.</label>
                                        <select class="form-control select2" style="width: 100%;" id="SupplierID" onchange="SupplierBalance();">
                                            <option value="">Select One</option>
                                            <?php 
                                            $query = $conn->prepare("SELECT * FROM `Supplier` WHERE `Status` = 'Active' ORDER BY `Name` ASC"); 
                                            $query->execute();
                                            $fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);
                                            foreach($fetch_list AS $fetch) { ?>
                                            <option value="<?php Print $fetch['SupplierID']; ?>">
                                                <?php Print $fetch['SupplierID']; ?> -
                                                <?php Print $fetch['Name']; ?> -
                                                <?php Print $fetch['MobileNo']; ?> -
                                                <?php Print $fetch['Address']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <!-- input states -->
                                    <div class="form-group">
                                        <label class="col-form-label" for="inputSuccess">Supplier Balance</label>
                                        <input type="text" class="form-control" readonly id="SupplierBalance"
                                            <?php print $QtyCheck; ?> value="0">
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                   <div class="form-group">
                                <label>Transaction Type</label>
                                    <select class="form-control select2" id="TransactionType"
                                        onchange="PaymentMode();">
                                        <option value="">Select One</option>
                                        <option value="Wallet">Wallet</option>                                  
                                        <option value="Bank">Bank</option>
                                    </select>
                                  </div>
                                </div>
                            
                                <div class="col-md-6">
                                    <!-- input states -->
                                    <div class="form-group">
                                        <label class="col-form-label" for="inputSuccess"> Payment Amount <small class="badge badge-warning" id="pay_mode"> </small></label>
                                            <input type="hidden" id="GetWalletID" value="">
                                            <input type="hidden" id="GetBankID" value="">
                                            <input type="hidden" id="PaymentName" value="">

                                        <input type="text" class="form-control" 
                                            id="PaymentAmount" <?php print $QtyCheck; ?> value="0"
                                            placeholder="Enter Payment Amount">
                                    </div>

                                </div>

                 
                            </div>

                            
                            <div class="row">
                            <input type="hidden" class="form-control"
                                            id="PaymentDiscount" <?php print $QtyCheck; ?> value="0"
                                            placeholder="Enter Discount Amount">
                            <!-- <div class="col-md-6"> -->
                                    <!-- input states -->
                                    <!-- <div class="form-group">
                                        <label class="col-form-label" for="inputSuccess">Discount Amount</label>
                         
                              
                                    </div> -->

                                <!-- </div> -->

                            <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="inputSuccess">Payment Note</label>
                                        <input type="text" class="form-control" id="PaymentNote" value="" <?php print $AutoComplete; ?> list="SupplierPaymentNoteList" OnKeyUp="SupplierPaymentNoteList();">
                                         <datalist id="SupplierPaymentNoteList"></datalist>
                                    </div>

                                </div>

                            </div> 
                            
                            
                            <div class="row">
                           
                            <div class="col-md-6">
                                    <!-- input states -->
                                    <div class="form-group">
                                        <label class="col-form-label" for="inputSuccess">Supplier Payment Invoice</label>
                                        <input type="text" readonly class="form-control"
                                            id="SupplierPaymentInvoice" >
                              
                                    </div>

                              </div>

                            <div class="col-md-6">
                                    <!-- input states -->
                                    <div class="form-group">
                                        <label class="col-form-label" for="inputSuccess">Date</label>
                                        <input type="date" readonly class="form-control"
                                            id="PaymentDate" value="<?php print $CurrentDate; ?>"
                                           >
                              
                                    </div>

                                </div>
                            </div>   
                            <div class="row">
                            <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="button" class="btn btn-success float-right" onclick="SupplierPayment();" id="SupplierPayment" value="Supplier Payment">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- /.row -->

            <!-- /.card-header -->
            
        <div class="card">
            <div class="card-body">
                <div id="load_cart_list" class="table-responsive">
                    <?php include("SupplierPaymentList.php"); ?>
                </div>
            </div>
        </div>
          <!-- /.card-body -->
                </div>


        </div>
        <!--/. container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <?php 
    include("footer.php");
    include("AccessLog.php");
    ?>
  </div>
  <!-- ./wrapper -->
  <!-- Custom JS -->
<script src="PaymentJS.JS"></script>
<script src="DeleteJS.js"></script>
  <?php 
//All Modals
include("SupplierPaymentModal.php");
?>
  <!-- REQUIRED SCRIPTS -->
  <?php include("RequiredJS.php");?>
</body>
<script src="SupplierPayment.JS"></script>

</html>
