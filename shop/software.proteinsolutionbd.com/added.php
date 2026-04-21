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
              <h1 class="m-0"><?php print $PageLevel = "Added Menu"; ?></h1>
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
              <h3 class="card-title"> Setup Menu</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

              <!-- Info boxes -->
              <div class="row">

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>
                <?php if (MenuPermission('2', $conn, $SessionID) == 1) { ?>
                <div class="col-md-3">
                  <a href="SupplierCategory.php" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Supplier Category View</h3>

                      <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      Total Active Supplier Category <?php Print $ActiveSupplierCategory; ?>
                    </div>
                    <!-- /.card-body -->
                  </a>

                </div>
                <!-- /.col -->
                <?php } ?>

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>
                <?php if (MenuPermission('3', $conn, $SessionID) == 1) { ?>
                <div class="col-md-3">
                  <a href="Supplier.php" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Supplier View</h3>

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
                <?php /*if (MenuPermission('4', $conn, $SessionID) == 1) { ?>

                <div class="col-md-3">
                  <a href="Brand.php" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Customer Category View</h3>

                      <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      Total Active Customer Category<?php Print $ActiveBrand; ?>
                    </div>
                    <!-- /.card-body -->
                  </a>

                </div>
                <!-- /.col -->
                <?php } */ ?>

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>
                <?php if (MenuPermission('4', $conn, $SessionID) == 1) { ?>

                <div class="col-md-3">
                  <a href="ItemCategory.php" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Item Category View</h3>

                      <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      Total Active Item Category <?php Print $ActiveItemCategory; ?>
                    </div>
                    <!-- /.card-body -->
                  </a>

                </div>
                <!-- /.col -->
                <?php } ?>


                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>
                <?php if (MenuPermission('5', $conn, $SessionID) == 1) { ?>

                <div class="col-md-3">
                  <a href="PackageSize.php" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Package Size View</h3>

                      <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      Total Active Package Size <?php Print $ActivePackageSize; ?>
                    </div>
                    <!-- /.card-body -->
                  </a>

                </div>
                <!-- /.col -->
                <?php } ?>


              </div>
              <!-- /.row -->

              <div class="row">


                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>
                <?php if (MenuPermission('6', $conn, $SessionID) == 1) { ?>

                <div class="col-md-3">
                  <a href="CustomerCategory.php" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Customer Category View</h3>

                      <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      Total Active Customer Category <?php Print $ActiveCustomerCategory; ?>
                    </div>
                    <!-- /.card-body -->
                  </a>

                </div>
                <!-- /.col -->
                <?php } ?>


                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>
                <?php if (MenuPermission('7', $conn, $SessionID) == 1) { ?>

                <div class="col-md-3">
                  <a href="CustomerSubCategory.php" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Customer Sub Category View</h3>

                      <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      Total Active Customer Sub Category <?php Print $ActiveSubCustomerCategory; ?>
                    </div>
                    <!-- /.card-body -->
                  </a>

                </div>
                <!-- /.col -->
                <?php } ?>

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>
                <?php if (MenuPermission('8', $conn, $SessionID) == 1) { ?>

                <div class="col-md-3">
                  <a href="Customer.php" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Customer View</h3>

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
                <?php if (MenuPermission('9', $conn, $SessionID) == 1) { ?>

                <div class="col-md-3">
                  <a href="PurchaseRate.php" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Purchase Rate Setup</h3>

                      <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      Total Active Purchase Rate <?php Print $ActivePurchaseRate; ?>
                    </div>
                    <!-- /.card-body -->
                  </a>

                </div>
                <!-- /.col -->
                <?php } ?>

              </div>

              <!-- Info boxes -->
              <div class="row">

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>
                <?php if(MenuPermission('10',$conn,$SessionID) == 1){ ?>
                  
                <div class="col-md-3">
                  <a href="SalesRate.php" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Sales Rate Setup</h3>

                      <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      Total Active Sales Rate <?php Print $ActiveSalesRate; ?>
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
              <h3 class="card-title"> Transaction Menu</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

              <!-- Info boxes -->
              <div class="row">

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>
                <?php if(MenuPermission('11',$conn,$SessionID) == 1){ ?>
                <div class="col-md-3">
                  <a href="Wallet.php" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Wallet View</h3>
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

                
                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>
                <?php if(MenuPermission('12',$conn,$SessionID) == 1){ ?>
                <div class="col-md-3">
                  <a href="Bank.php" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Bank View</h3>
                      <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      Total Active Bank <?php Print $ActiveBank; ?>
                    </div>
                    <!-- /.card-body -->
                  </a>

                </div>
                <!-- /.col -->
                <?php } ?>

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>
                <?php if(MenuPermission('13',$conn,$SessionID) == 1){ ?>
                <div class="col-md-3">
                  <a href="OthersAccount.php" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Others Account View</h3>
                      <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      Total Active Others Account <?php Print $ActiveOthersAccount; ?>
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