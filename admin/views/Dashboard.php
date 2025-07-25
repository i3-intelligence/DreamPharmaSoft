<?php
require_once '../includes/Auth.php'; // Session Starting file
include '../config/Database.php'; // Database connection file
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
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<?php include '../views/RequiredFotterContex.php'; ?>

</body>
</html>
