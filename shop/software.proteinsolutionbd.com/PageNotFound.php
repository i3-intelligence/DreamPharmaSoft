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
            <h1 class="m-0"><u><i><?php print $PageLevel= "Not authorized"; ?> </i></u></h1>
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


      <div class="error-page">
<h2 class="headline text-danger">403</h2>
<div class="error-content">
<h3><i class="fas fa-exclamation-triangle text-danger"></i> Oops! You are not authorized to access this Page</h3>
<p>Please Contact With Administaion.
</p>

</div>
</div>


      </div><!--/. container-fluid -->
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
<?php include("footer.php");?>

  <!-- User Access -->
  <?php include("AccessLog.php");?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<?php include("RequiredJS.php");?>

</body>
</html>
