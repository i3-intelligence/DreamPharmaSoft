<?php
require_once("auth.php");
include("db.php");
include("count.php");
//CAll Permission
include("MenuPermission.php");
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
              <h1 class="m-0"><?php print $PageLevel = "Report Menu"; ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
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


          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Challan/Sales Menu</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

              <!-- Info boxes -->
              <div class="row">

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>
                <?php if(MenuPermission('21',$conn,$SessionID) == 1){ ?>
                <div class="col-md-3">
                  <a href="ChallanReport.php" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Challan Report</h3>
                      <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      Total Challan Invoice <?php Print $ActiveChallanInvoice; ?>
                    </div>
                    <!-- /.card-body -->
                  </a>

                </div>
                <!-- /.col -->
                <?php } ?>

          
                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>
                <?php if(MenuPermission('22',$conn,$SessionID) == 1){ ?>
                <div class="col-md-3">
                  <a href="SalesReport.php" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Sales Report</h3>
                      <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      Total Cash Memo Invoice <?php Print $ActiveCashMemoInvoice; ?>
                    </div>
                    <!-- /.card-body -->
                  </a>

                </div>
                <!-- /.col -->
                <?php } ?>

                
                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>
                <?php if(MenuPermission('23',$conn,$SessionID) == 1){ ?>
                <div class="col-md-3">
                  <a href="StockReport.php" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Stock Report</h3>
                      <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      
                    </div>
                    <!-- /.card-body -->
                  </a>

                </div>
                <!-- /.col -->
                <?php } ?>


                
                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>
                <?php if(MenuPermission('24',$conn,$SessionID) == 1){ ?>
                <div class="col-md-3">
                  <a href="ProfitLossReport.php" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Profit/Loss Report</h3>
                      <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      
                    </div>
                    <!-- /.card-body -->
                  </a>

                </div>
                <!-- /.col -->
                <?php } ?>


              </div>
              <!-- /.row -->

            </div>
          </div>


          
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Challan/Sales Return Menu</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

              <!-- Info boxes -->
              <div class="row">

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>
                <?php if(MenuPermission('25',$conn,$SessionID) == 1){ ?>
                <div class="col-md-3">
                  <a href="ChallanReturnReport.php" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Challan Return Report</h3>
                      <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      Total Challan Return Invoice <?php Print $ActiveChallanReturnInvoice; ?>
                    </div>
                    <!-- /.card-body -->
                  </a>

                </div>
                <!-- /.col -->
                <?php } ?>

          
                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>
                <?php if(MenuPermission('26',$conn,$SessionID) == 1){ ?>
                <div class="col-md-3">
                  <a href="SalesReturnReport.php" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Sales Return Report</h3>
                      <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      Total Cash Memo Return Invoice <?php Print $ActiveCashMemoReturnInvoice; ?>
                    </div>
                    <!-- /.card-body -->
                  </a>

                </div>
                <!-- /.col -->
                <?php } ?>
              </div>
              <!-- /.row -->

            </div>
          </div>
          
          
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Ledger Menu</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

              <!-- Info boxes -->
              <div class="row">
              <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>
                <?php if(MenuPermission('27',$conn,$SessionID) == 1){ ?>
                <div class="col-md-3">
                  <a href="SupplierLedger.php" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Supplier Ledger Report</h3>
                      <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    Total Active Supplier <?php Print $ActiveSupplier; ?>
                    </div>
                    <!-- /.card-body -->
                  </a>

                </div>
                <!-- /.col -->
                <?php } ?>

          
                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>
                <?php if(MenuPermission('28',$conn,$SessionID) == 1){ ?>
                <div class="col-md-3">
                  <a href="CustomerLedger.php" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Customer Ledger Report</h3>
                      <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    Total Active Customer <?php Print $ActiveCustomer; ?>
                    </div>
                    <!-- /.card-body -->
                  </a>

                </div>
                <!-- /.col -->
                <?php } ?>


                 <!-- fix for small devices only -->
                 <div class="clearfix hidden-md-up"></div>
                <?php if(MenuPermission('29',$conn,$SessionID) == 1){ ?>
                <div class="col-md-3">
                  <a href="WalletLedger.php" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Wallet Ledger Report</h3>
                      <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    Total Active Wallet <?php Print $ActiveWallet; ?>
                    </div>
                    <!-- /.card-body -->
                  </a>

                </div>
                <!-- /.col -->
                <?php } ?>
                
              </div>
              <!-- /.row -->

            </div>
          </div>
          
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Admin Menu</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <!-- Info boxes -->
              <div class="row">
              
              <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>
                <?php if(MenuPermission('1',$conn,$SessionID) == 1){ ?>
                <div class="col-md-3">
                  <a href="MenuPermissionView.php" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Menu Permission</h3>
                      <!-- /.card-tools -->
                    </div>

                  </a>

                </div>
                <!-- /.col -->
                <?php } ?>

   <!-- fix for small devices only -->
   <div class="clearfix hidden-md-up"></div>
                <?php if(MenuPermission('30',$conn,$SessionID) == 1){ ?>
                <div class="col-md-3">
                  <a href="UserView.php" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> User View</h3>
                      <!-- /.card-tools -->
                    </div>

                  </a>

                </div>
                <!-- /.col -->
                <?php } ?>

              <!-- fix for small devices only -->
              <div class="clearfix hidden-md-up"></div>
                <?php if(MenuPermission('31',$conn,$SessionID) == 1){ ?>
                <div class="col-md-3">
                  <a href="DeleteChallanCashMemo.php" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Delete</h3>
                      <!-- /.card-tools -->
                    </div>

                  </a>

                </div>
                <!-- /.col -->
                <?php } ?>
                
              <!-- fix for small devices only -->
              <div class="clearfix hidden-md-up"></div>
                <?php if(MenuPermission('32',$conn,$SessionID) == 1){ ?>
                <div class="col-md-3">
                  <a href="ChallanEdit.php" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Edit Challan</h3>
                      <!-- /.card-tools -->
                    </div>

                  </a>

                </div>
                <!-- /.col -->
                <?php } ?>
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>
                <?php if(MenuPermission('33',$conn,$SessionID) == 1){ ?>
                <div class="col-md-3">
                  <a href="BalanceSummary.php" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Balance Summary</h3>
                      <!-- /.card-tools -->
                    </div>

                  </a>

                </div>
                <!-- /.col -->
                <?php } ?>

                     <!-- fix for small devices only -->
                     <div class="clearfix hidden-md-up"></div>
                <?php if(MenuPermission('34',$conn,$SessionID) == 1){ ?>
                <div class="col-md-3">
                  <a href="BackDateView.php" target="_blank" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Back Date</h3>
                      <!-- /.card-tools -->
                    </div>

                  </a>

                </div>
                <!-- /.col -->
                <?php } ?>
              </div>
                   <!-- /.row -->
            </div>
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
      <?php include("SideBar.php"); ?>
    </aside>
    <!-- /.control-sidebar -->

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

</html>