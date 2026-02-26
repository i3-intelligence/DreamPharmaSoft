<?php
require_once 'Auth.php'; // Session Starting file
include 'Database.php'; // Database connection file
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'Header.php'; ?>
<body class="hold-transition layout-top-nav">
<div class="wrapper">


  <!-- Navbar -->
  <?php include 'Navbar.php'; ?>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><u><i><?php print $PageLevel= "Dashboard"; ?> - <?php print date("d/M/Y",strtotime($CurrentDate)); ?></i></u></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="Dashboard.php">Home</a></li> -->
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
      <div class="row">
        <div class="col-md-6">
          <div class="box box-default">
            <div class="box-header with-border">
              <i class="fa fa-warning"></i>

              <h3 class="box-title"><?php echo __("Notice"); ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <?php 
    
                $Notice = $conn->prepare("SELECT 
                A.`ShopName`,
                A.`SubscriptionStartDate`,
                A.`SubscriptionEndDate`,
                A.`CreateDate`,
                B.`PackageName`
                FROM `shop` A 
                LEFT JOIN `package` B ON A.`PackageId`=B.`Id`
                WHERE A.`id` = '$ShopId' ");
                $Notice->execute();
                $fetchNotice = $Notice->fetch(PDO::FETCH_ASSOC);
                $PackageName = $fetchNotice['PackageName'] ?? '';
                $endtime = $fetchNotice['SubscriptionEndDate'] ?? '';

                
              ?>
              <?php
              if (strtotime($endtime) < strtotime($CurrentDate)) {
              ?>
              <div class="alert alert-danger alert-dismissible">
                <h4><?php print $PackageName; ?> Package</h4>
                <p><?php echo __("Your subscription has expired on"); ?> <b><?php print date("d/M/Y",strtotime($endtime)); ?></b>. <?php echo __("Please renew your subscription to continue using our services."); ?></p>
               <?php
              } elseif (strtotime($endtime) < strtotime($CurrentDate . ' +7 days')) {
              ?>
              <div class="alert alert-warning alert-dismissible">
                <h4><?php print $PackageName; ?> Package</h4>
                <p><?php echo __("Your subscription will expire soon on"); ?> <b><?php print date("d/M/Y",strtotime($endtime)); ?></b>. <?php echo __("Please consider renewing your subscription to avoid any disruption in service."); ?></p>

              <?php }else{ ?>

               <div class="alert alert-success alert-dismissible">
                <h4><?php print $PackageName; ?> Package | Day Left <?php echo date_diff(date_create($CurrentDate), date_create($endtime))->days; ?> Days</h4>
                <p><?php echo __("Your subscription is active and will expire on"); ?> <b><?php print date("d/M/Y",strtotime($endtime)); ?></b>. <?php echo __("Thank you for being a valued customer!"); ?> </p>
                
              </div>
              <?php } ?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

        <!-- /.col -->
      </div>

      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
      <?php include 'SideBar.php'; ?>
    </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
<?php include 'Footer.php';?>

  <!-- User Access -->
   
  <?php 
  include 'AccessLog.php'; // AccessLog connection file
  ?>

</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<?php include 'RequiredFotterContex.php'; ?>

</body>
</html>
