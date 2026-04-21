<?php
require_once("auth.php");
include("db.php");
include("count.php");
//CAll Permission
include("MenuPermission.php");

if(MenuPermission('28',$conn,$SessionID) == 0){ 
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
              <h1 class="m-0"><?php print $PageLevel = "Customer Ledger"; ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="Report.php">Report</a></li>
                <li class="breadcrumb-item active"><?php print $PageLevel; ?></li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->
      <!-- Main content -->
      <section class="content">
    

<section class="content">
        <div class="container-fluid">
          <!-- Info boxes -->
          <form action="CustomerLedgerViewDetalisView.php" method="get" target="_blank">
            <div class="card card-default">
              <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                Invoice Wise Detalis
                </h3>
             
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><span class="material-icons"
                              title="Required Field">error</span>Customer </span>
                        </div>


                        <select class="form-control select2" id="CustomerID" name="CustomerID">
                          <option value="">Select Customer</option>
                          <?php $query = $conn->prepare("SELECT * FROM `Customer` WHERE `Status` = 'Active'ORDER BY `Name` ASC "); 
$query->execute();
$fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);
foreach($fetch_list AS $fetch) { ?>
                          <option value="<?php Print $fetch['CustomerID']; ?>"><?php Print $fetch['CustomerID']; ?>
                            -<?php Print $fetch['Name']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">

                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group mb-3">

                        <div class="input-group date" id="start_date2" data-target-input="nearest">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><span class="material-icons"
                                title="Required Field">error</span>Start Date </span>
                          </div>
                          <input type="text" required class="form-control datetimepicker-input" name="start_date"
                            value="<?php print date("01/m/Y",strtotime($CurrentDate));?>" data-target="#start_date2"
                            data-toggle="datetimepicker" />

                        </div>
                      </div>
                    </div>
                  </div>


                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group mb-3">

                        <div class="input-group date" id="end_date2" data-target-input="nearest">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><span class="material-icons"
                                title="Required Field">error</span>End Date </span>
                          </div>
                          <input type="text" required class="form-control datetimepicker-input" name="end_date"
                            value="<?php print date("d-m-Y",strtotime($CurrentDate));?>"  data-target="#end_date2"
                            data-toggle="datetimepicker" />

                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                <div class="col-md-12">
                <input type="submit" class="btn btn-success float-right" name="submit" value="Search Data">
                </div>
                </div>

              </div>

            </div>
            <!-- /.row -->
            </form>

        </div>

        <div class="container-fluid">
          <!-- Info boxes -->
          <form action="CustomerLedgerView.php" method="get" target="_blank">
            <div class="card card-default">
              <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                Customer Wise Summary
                </h3>
             
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><span class="material-icons"
                              title="Required Field">error</span>Customer </span>
                        </div>


                        <select class="form-control select2" id="CustomerID" name="CustomerID">
                          <option value="All">All Customer</option>
                          <?php $query = $conn->prepare("SELECT * FROM `Customer` WHERE `Status` = 'Active'ORDER BY `Name` ASC "); 
$query->execute();
$fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);
foreach($fetch_list AS $fetch) { ?>
                          <option value="<?php Print $fetch['CustomerID']; ?>"><?php Print $fetch['CustomerID']; ?>
                            -<?php Print $fetch['Name']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">

                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group mb-3">

                        <div class="input-group date" id="start_date" data-target-input="nearest">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><span class="material-icons"
                                title="Required Field">error</span>Start Date </span>
                          </div>
                          <input type="text" required class="form-control datetimepicker-input" name="start_date"
                            value="<?php print date("01/m/Y",strtotime($CurrentDate));?>" data-target="#start_date"
                            data-toggle="datetimepicker" />

                        </div>
                      </div>
                    </div>
                  </div>


                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group mb-3">

                        <div class="input-group date" id="end_date" data-target-input="nearest">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><span class="material-icons"
                                title="Required Field">error</span>End Date </span>
                          </div>
                          <input type="text" required class="form-control datetimepicker-input" name="end_date"
                            value="<?php print date("d-m-Y",strtotime($CurrentDate));?>"  data-target="#end_date"
                            data-toggle="datetimepicker" />

                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                <div class="col-md-12">
                <input type="submit" class="btn btn-success float-right" name="submit" value="Search Data">
                </div>
                </div>

              </div>

            </div>
            <!-- /.row -->
            </form>

        </div>

        <div class="container-fluid">
          <!-- Info boxes -->
          <form action="CustomerCategoryWiseDueView.php" method="get" target="_blank">
            <div class="card card-default">
              <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                Customer Sub Category Wise Due List
                </h3>
             
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><span class="material-icons"
                              title="Required Field">error</span>Customer Sub Category </span>
                        </div>


                        <select class="form-control select2" id="CustomerSubCategoryID" name="CustomerSubCategoryID">
                          <option value="All">All Customer Sub Category</option>
                          <?php $query = $conn->prepare("SELECT * FROM `CustomerSubCategory` WHERE `Status` = 'Active'ORDER BY `Name` ASC "); 
$query->execute();
$fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);
foreach($fetch_list AS $fetch) { ?>
                          <option value="<?php Print $fetch['CustomerSubCategoryID']; ?>"><?php Print $fetch['CustomerSubCategoryID']; ?>
                            -<?php Print $fetch['Name']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">

                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group mb-3">

                        <div class="input-group date" id="start_date3" data-target-input="nearest">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><span class="material-icons"
                                title="Required Field">error</span>Start Date </span>
                          </div>
                          <input type="text" required class="form-control datetimepicker-input" name="start_date"
                            value="<?php print date("01/m/Y",strtotime($CurrentDate));?>" data-target="#start_date3"
                            data-toggle="datetimepicker" />

                        </div>
                      </div>
                    </div>
                  </div>


                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group mb-3">

                        <div class="input-group date" id="end_date3" data-target-input="nearest">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><span class="material-icons"
                                title="Required Field">error</span>End Date </span>
                          </div>
                          <input type="text" required class="form-control datetimepicker-input" name="end_date"
                            value="<?php print date("d-m-Y",strtotime($CurrentDate));?>"  data-target="#end_date3"
                            data-toggle="datetimepicker"/>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                <div class="col-md-12">
                <input type="submit" class="btn btn-success float-right" name="submit" value="Search Data">
                </div>
                </div>

              </div>

            </div>
            <!-- /.row -->
            </form>

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