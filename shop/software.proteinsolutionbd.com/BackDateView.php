<?php
require_once("auth.php");
include("db.php");
include("count.php");
//CAll Permission
include("MenuPermission.php");
if(MenuPermission('23',$conn,$SessionID) == 0){ 
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
              <h1 class="m-0"><?php print $PageLevel = "Back Date"; ?></h1>
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
      
      <!-- Error Message -->
        <?php if(!empty($_GET['msg']) && $_GET['msg'] == 1){ ?>
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5><i class="icon fas fa-check"></i> Success!</h5>
          Back Date Updated Successfully.
        </div>
        <?php } elseif(!empty($_GET['msg']) && $_GET['msg'] == 0){ ?>
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5><i class="icon fas fa-ban"></i> Error!</h5>
          Back Date Update Failed.
        </div>
        <?php } ?>
        <div class="container-fluid">
          <!-- Info boxes -->
          <form action="BackDate.php" method="POST">
            <div class="card card-default">
              <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">Current Date <?php print date("d-m-y",strtotime($CurrentDate)); ?></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><span class="material-icons"
                              title="Required Field">error</span>User Info </span>
                        </div>


                        <select class="form-control select2" id="User" name="User">
                                <option value="">Select User</option>
                                <?php
                                $query_User = $conn->prepare("SELECT A.*,B.`Date` FROM `UserInformation` A  
                                LEFT JOIN CustomDate B ON A.`Id` = B.`UserId`
                                ORDER BY A.`UserName` ASC ");
                                $query_User->execute();
                                $fetch_list = $query_User->fetchAll(PDO::FETCH_ASSOC);
                                foreach($fetch_list AS $fetch) { ?>
                                <option value="<?php print $fetch['Id']; ?>"><?php print $fetch['UserName']; ?> || <?php print date("d-m-y",strtotime($fetch['Date'])); ?></option>
                                <?php
                                }
                                ?>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group mb-3">

                        <div class="input-group date" id="backdate" data-target-input="nearest">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><span class="material-icons"
                                title="Required Field">error</span>Change Date </span>
                          </div>
                          <input type="text" required class="form-control datetimepicker-input" name="end_date"
                            value="<?php print date("d-m-Y",strtotime($CurrentDate));?>"  data-target="#backdate"
                            data-toggle="datetimepicker" />

                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                <div class="col-md-12">
                <input type="submit" class="btn btn-success float-right" name="submit" value="Back Date">
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