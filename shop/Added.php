<?php
require_once 'Auth.php'; // Session Starting file
include 'Database.php'; // Database connection file
include 'Count.php'; // Count Active Data
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'Header.php';?>

<body class="hold-transition layout-top-nav">
  <div class="wrapper">


    <!-- Navbar -->
    <?php include 'Navbar.php';?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0"><?php print $PageLevel = __("Added Menu"); ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="Dashboard.php"><?php echo __("Home"); ?></a></li>
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
              <h3 class="card-title"> <?php echo __("Setup Menu"); ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

              <!-- Info boxes -->
              <div class="row">
       <!-- fix for small devices only -->
    
                <div class="col-md-3">
                  <a href="Medicine.php" class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> <?php echo __("Medicine View"); ?></h3>

                      <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      <?php echo __("Total Active Medicine"); ?> <?php Print $ActiveMedicine; ?>
                    </div>
                    <!-- /.card-body -->
                  </a>

                </div>
                <!-- /.col -->
       
                

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
      <?php include 'SideBar.php';?>
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <?php 
include 'Footer.php';
include 'AccessLog.php';
?>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  <?php include 'RequiredFotterContex.php'; ?>

</body>

</html>