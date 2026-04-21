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
              <h1 class="m-0"><?php print $PageLevel = "Payment Menu"; ?></h1>
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
            <!-- <div class="card-header">
              <h3 class="card-title"> Transaction Menu</h3>
            </div> -->
            <!-- /.card-header -->
            <div class="card-body">

              <!-- Info boxes -->
              <div class="row">
   <!-- fix for small devices only -->
   <div class="clearfix hidden-md-up"></div>
                <?php if(MenuPermission('15',$conn,$SessionID) == 1){ ?>
                <div class="col-md-3">
                  <a href="CustomerDueReceive.php" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Customer Due </h3>
                      <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      Total Customer Due Invoice <?php Print $ActiveCustomerDueReceiveInvoice; ?>
                    </div>
                    <!-- /.card-body -->
                  </a>

                </div>
                <!-- /.col -->
                <?php } ?>

                
                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>
                <?php if(MenuPermission('16',$conn,$SessionID) == 1){ ?>
                <div class="col-md-3">
                  <a href="SupplierPayment.php" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Supplier Payment</h3>
                      <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      Total Supplier Payment Invoice <?php Print $ActiveSupplierPaymentInvoice; ?>
                    </div>
                    <!-- /.card-body -->
                  </a>

                </div>
                <!-- /.col -->
                <?php } ?>
<!-- fix for small devices only -->
<div class="clearfix hidden-md-up"></div>
                <?php if(MenuPermission(2,$conn,$SessionID) == 1){ ?>
                <!-- <div class="col-md-3">
                  <a href="SupplierDiscount.php" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Supplier Discount</h3>
                 /.card-tools -->
                    <!-- </div> -->
                    <!-- /.card-header -->
                    <!-- <div class="card-body"> -->
                      <!-- Total Supplier Payment Invoice <?php //Print $ActiveSupplierPaymentInvoice; ?> -->
                    <!-- </div> -->
                    <!-- /.card-body -->
                  <!-- </a> -->

                <!-- </div> -->
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