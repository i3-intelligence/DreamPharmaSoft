<?php
require_once("auth.php");
include("db.php");
include("count.php");
//CAll Permission
include("MenuPermission.php");
if(MenuPermission('22',$conn,$SessionID) == 0){ 
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
              <h1 class="m-0"><?php print $PageLevel = "Sales Report"; ?></h1>
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
        <div class="container-fluid">
          <!-- Info boxes -->
          <form action="SalesReportSummary.php" method="get" target="_blank">
            <div class="card card-default">
              <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                  Sales Supplier Wise Report
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
                              title="Required Field">error</span>Report Type </span>
                        </div>

                        <select class="form-control select2" name="type" required>
                          <option value="Invoice Wise">Invoice Wise</option>
                          <option value="Invoice Details">Invoice Details</option>
                          <option value="Product Wise">Product Wise</option>
                        </select>
                      </div>
                    </div>
                  </div>

                </div>


                <div class="row">

                  <div class="col-md-6">
                    <!-- input states -->
                    <div class="form-group">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Supplier Info</span>
                        </div><select class="form-control select2" id="SupplierID" name="SupplierID" REQUIRED
                          onchange="SupItemCategory();">
                          <option value="All">Select All</option>

                          <?php
$query = $conn->prepare("SELECT * FROM `Supplier` WHERE `Status` = 'Active' ORDER BY `Name` ASC");
$query->execute();
$FetchSupplierData = $query->fetchAll(PDO::FETCH_ASSOC);
foreach($FetchSupplierData AS $Fetch) {
?>
                          <option value="<?php print $Fetch['SupplierID']; ?>">
                            <?php print sprintf("%03d", $Fetch['SupplierID']); ?> |
                            <?php print $Fetch['Name']; ?> |
                            <?php print $Fetch['MobileNo']; ?> |
                            <?php print $Fetch['Address']; ?></option>
                          <?php } ?>
                        </select>
                      </div>

                    </div>

                  </div>


                  <div class="col-md-6">
                    <!-- input states -->
                    <div class="form-group" id="loadItemCategory">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Item Category
                          </span>
                        </div>

                        <select class="form-control select2" id="ItemCategoryID" Name="ItemCategoryID">
                          <option value="All">Select All
                          </option>

                          <?php
$query = $conn->prepare("SELECT * FROM `ItemCategory` WHERE `Status` = 'Active' ORDER BY `Name` ASC");
$query->execute();
$FetchSupplierData = $query->fetchAll(PDO::FETCH_ASSOC);
foreach($FetchSupplierData AS $Fetch) {
?>
                          <option value="<?php print $Fetch['ItemCategoryID']; ?>">
                            <?php print $Fetch['Name']; ?></option>
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
                            value="<?php print date("d-m-Y",strtotime($CurrentDate));?>" data-target="#end_date"
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
          <form action="SalesReportCustomerWise.php" method="get" target="_blank">
            <div class="card card-default">
              <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                  Sales Customer Wise Report
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
                              title="Required Field">error</span>Report Type </span>
                        </div>

                        <select class="form-control select2" name="type" required>
                          <option value="Invoice Wise">Invoice Wise</option>
                          <option value="Invoice Details">Invoice Details</option>
                          <option value="Product Wise">Product Wise</option>
                        </select>
                      </div>
                    </div>
                  </div>

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
                            -<?php Print $fetch['Name']; ?>-<?php Print $fetch['Address']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>



                <div class="row">

                  <div class="col-md-6">
                    <!-- input states -->
                    <div class="form-group">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Supplier Info</span>
                        </div><select class="form-control select2" id="SupplierID2" name="SupplierID2" REQUIRED
                          onchange="SupItemCategory2();">
                          <option value="All">Select All</option>

                          <?php
$query = $conn->prepare("SELECT * FROM `Supplier` WHERE `Status` = 'Active' ORDER BY `Name` ASC");
$query->execute();
$FetchSupplierData = $query->fetchAll(PDO::FETCH_ASSOC);
foreach($FetchSupplierData AS $Fetch) {
?>
                          <option value="<?php print $Fetch['SupplierID']; ?>">
                            <?php print sprintf("%03d", $Fetch['SupplierID']); ?> |
                            <?php print $Fetch['Name']; ?> |
                            <?php print $Fetch['MobileNo']; ?> |
                            <?php print $Fetch['Address']; ?></option>
                          <?php } ?>
                        </select>
                      </div>

                    </div>

                  </div>


                  <div class="col-md-6">
                    <!-- input states -->
                    <div class="form-group" id="loadItemCategory2">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Item Category
                          </span>
                        </div>

                        <select class="form-control select2" id="ItemCategoryID2" Name="ItemCategoryID2">
                          <option value="All">Select All
                          </option>
                          <?php
$query = $conn->prepare("SELECT * FROM `ItemCategory` WHERE `Status` = 'Active' ORDER BY `Name` ASC");
$query->execute();
$FetchSupplierData = $query->fetchAll(PDO::FETCH_ASSOC);
foreach($FetchSupplierData AS $Fetch) {
?>
                          <option value="<?php print $Fetch['ItemCategoryID']; ?>">
                            <?php print $Fetch['Name']; ?></option>
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
                            value="<?php print date("d-m-Y",strtotime($CurrentDate));?>" data-target="#end_date2"
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
          <form action="SalesReportSupplierCategory.php" method="get" target="_blank">
            <div class="card card-default">
              <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                  Sales Report Supplier Category Wise Report
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
                              title="Required Field">error</span>Report Type </span>
                        </div>

                        <select class="form-control select2" name="type" required>
                          <option value="Invoice Wise">Invoice Wise</option>
                          <option value="Invoice Details">Invoice Details</option>
                          <option value="Product Wise">Product Wise</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><span class="material-icons"
                              title="Required Field">error</span>Supplier Category </span>
                        </div>


                        <select class="form-control select2" id="SupplierCategoryID" name="SupplierCategoryID">
                          <option value="All">All Category</option>
                          <?php $query = $conn->prepare("SELECT * FROM `SupplierCategory` WHERE `Status` = 'Active'ORDER BY `Name` ASC "); 
$query->execute();
$fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);
foreach($fetch_list AS $fetch) { ?>
                          <option value="<?php Print $fetch['SupplierCategoryID']; ?>"><?php Print $fetch['SupplierCategoryID']; ?>
                            - <?php Print $fetch['Name']; ?></option>
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
                            value="<?php print date("d-m-Y",strtotime($CurrentDate));?>" data-target="#end_date3"
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
          <form action="SalesReportCustomerSubCategory.php" method="get" target="_blank">
            <div class="card card-default">
              <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                  Sales Report Customer Sub Category Wise Report
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
                              title="Required Field">error</span>Report Type </span>
                        </div>

                        <select class="form-control select2" name="type" required>
                          <option value="Invoice Wise">Invoice Wise</option>
                          <option value="Invoice Details">Invoice Details</option>
                          <option value="Product Wise">Product Wise</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><span class="material-icons"
                              title="Required Field">error</span>Customer Sub Category </span>
                        </div>


                        <select class="form-control select2" id="CustomerSubCategoryID" name="CustomerSubCategoryID">
                          <option value="All">All Sub Category</option>
                          <?php $query = $conn->prepare("SELECT * FROM `CustomerSubCategory` WHERE `Status` = 'Active'ORDER BY `Name` ASC "); 
$query->execute();
$fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);
foreach($fetch_list AS $fetch) { ?>
                          <option value="<?php Print $fetch['CustomerSubCategoryID']; ?>"><?php Print $fetch['CustomerSubCategoryID']; ?>
                            - <?php Print $fetch['Name']; ?></option>
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

                        <div class="input-group date" id="start_date4" data-target-input="nearest">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><span class="material-icons"
                                title="Required Field">error</span>Start Date </span>
                          </div>
                          <input type="text" required class="form-control datetimepicker-input" name="start_date"
                            value="<?php print date("01/m/Y",strtotime($CurrentDate));?>" data-target="#start_date4"
                            data-toggle="datetimepicker" />

                        </div>
                      </div>
                    </div>
                  </div>


                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group mb-3">

                        <div class="input-group date" id="end_date4" data-target-input="nearest">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><span class="material-icons"
                                title="Required Field">error</span>End Date </span>
                          </div>
                          <input type="text" required class="form-control datetimepicker-input" name="end_date"
                            value="<?php print date("d-m-Y",strtotime($CurrentDate));?>" data-target="#end_date4"
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
<script>
  // LOAD Sub Item SupplierCategory
  function SupItemCategory() {
    //get the VALUE
    var SupplierID = $('#SupplierID').val();
    // alert(SupplierID);

    document.getElementById('loadItemCategory').innerHTML = 'Loading...';
    //use ajax to run the check
    $.post("JsonValue.php", {
        SupplierID3: SupplierID
      },
      function (result) {
        document.getElementById('loadItemCategory').innerHTML = result['loadItemCategory'];
        $("#ItemCategoryID").select2();
      });
  }

  // LOAD Sub Item SupplierCategory
  function SupItemCategory2() {
    //get the VALUE
    var SupplierID2 = $('#SupplierID2').val();
    // alert(SupplierID);

    document.getElementById('loadItemCategory2').innerHTML = 'Loading...';
    //use ajax to run the check
    $.post("JsonValue.php", {
        SupplierID2: SupplierID2
      },
      function (result) {
        document.getElementById('loadItemCategory2').innerHTML = result['loadItemCategory'];
        $("#ItemCategoryID2").select2();

      });

  }
</script>

</html>