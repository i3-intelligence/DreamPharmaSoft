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
            <h1 class="m-0"><u><i><?php print $PageLevel= "Dashboard"; ?> - <?php print date("d/M/Y",strtotime($CurrentDate)); ?></i></u></h1>
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


<div class="row">
<div class="col-md-6">
<div class="card">
<div class="card-header">
<h3 class="card-title">Today User Access </h3>
</div>

<div class="card-body p-0">
<table class="table table-sm">
<thead>
  <tr>
    <th>User Name</th>
    <th>Start Access </th>
    <th>Last Access</th>
  </tr>
</thead>
<tbody>
  <?php
  $query = $conn->prepare("SELECT A.`id`,A.`UserName`,`start_access`,B.`last_access` FROM `UserInformation` A 
  LEFT JOIN (SELECT `UserId`,MAX(`time`) AS `last_access`,MIN(`CurrentDateTime`) AS `start_access` FROM `AccessLog` WHERE `date` = '$CurrentDate' GROUP BY `UserId`) B ON (A.`id` = B.`UserId`)
  WHERE A.`block` = 'No' ORDER BY B.`last_access` DESC");
  $query->execute();
  $fetch_data = $query->fetchAll(PDO::FETCH_ASSOC);
  foreach($fetch_data AS $fetch){
  ?>
             <tr>
              <td><?php print $fetch['id']; ?> - <?php print $fetch['UserName']; ?></td>
              <td><?php if(!empty($fetch['start_access'])){ print date("h:i:s a",strtotime($fetch['start_access'])); }else{ print "<span class=\"badge bg-danger\">No Acccess Found</span>"; } ?></td>
              <td><?php if(!empty($fetch['last_access'])){ print date("h:i:s a",strtotime($fetch['last_access'])); } ?></td>
<?php } ?>
</tbody>
</table>
</div>

</div>

</div>

<div class="col-md-6">
<div class="card">
<div class="card-header">
<h3 class="card-title">Pending User Cart List</h3>
</div>

<div class="card-body p-0">
<table class="table table-sm">
<thead>
  <tr>
    <th>Date/Time</th>
    <th>User Name</th>
    <th>Challan </th>
    <th>Cash Memo </th>
    <th>Challan Return</th>
    <th>Cash Memo Return</th>
  </tr>
</thead>
<tbody>
  <?php
  $query = $conn->prepare("SELECT A.*,
  COUNT(A.`ChallanID`)  AS `Cart`,
  B.`UserName` 
   FROM `Challan` A

  LEFT JOIN `UserInformation` B ON (A.`EntryID` = B.`id`)
   WHERE A.`Cart` = '' GROUP BY A.`EntryID`  ");
  $query->execute();
  $fetch_data = $query->fetchAll(PDO::FETCH_ASSOC);
  foreach($fetch_data AS $fetch){
  ?>
             <tr>
             <td><?php if(!empty($fetch['CreateDate'])){ print date("d/m/y - h:i:s a",strtotime($fetch['CreateDate'])); } ?></td>
              <td><?php print $fetch['UserName']; ?></td>
              <td><span class="badge bg-danger"><?php print $fetch['Cart']; ?></span></td>
              <td colspan="3"></td>
          
   
<?php } ?>
<?php
  $query = $conn->prepare("SELECT A.*,
  COUNT(A.`CashMemoID`)  AS `Cart`,
  B.`UserName` 
   FROM `CashMemo` A

  LEFT JOIN `UserInformation` B ON (A.`EntryID` = B.`id`)
   WHERE A.`Cart` = '' GROUP BY A.`EntryID`  ");
  $query->execute();
  $fetch_data2 = $query->fetchAll(PDO::FETCH_ASSOC);
  foreach($fetch_data2 AS $fetch){
  ?>
             <tr>
             <td><?php if(!empty($fetch['CreateDate'])){ print date("d/m/y - h:i:s a",strtotime($fetch['CreateDate'])); } ?></td>
              <td><?php print $fetch['UserName']; ?></td>
              <td></td>
              <td><span class="badge bg-danger"><?php print $fetch['Cart']; ?></span></td>
              <td colspan="2"></td>
<?php } ?>

<?php
  $query = $conn->prepare("SELECT A.*,
  COUNT(A.`ChallanReturnID`)  AS `Cart`,
  B.`UserName` 
   FROM `ChallanReturn` A

  LEFT JOIN `UserInformation` B ON (A.`EntryID` = B.`id`)
   WHERE A.`Cart` = '' GROUP BY A.`EntryID`  ");
  $query->execute();
  $fetch_data2 = $query->fetchAll(PDO::FETCH_ASSOC);
  foreach($fetch_data2 AS $fetch){
  ?>
             <tr>
             <td><?php if(!empty($fetch['CreateDate'])){ print date("d/m/y - h:i:s a",strtotime($fetch['CreateDate'])); } ?></td>
              <td><?php print $fetch['UserName']; ?></td>
              <td colspan="2"></td>
              <td><span class="badge bg-danger"><?php print $fetch['Cart']; ?></span></td>
              <td></td>
<?php } ?>

<?php
  $query = $conn->prepare("SELECT A.*,
  COUNT(A.`CashMemoReturnID`)  AS `Cart`,
  B.`UserName` 
   FROM `CashMemoReturn` A

  LEFT JOIN `UserInformation` B ON (A.`EntryID` = B.`id`)
   WHERE A.`Cart` = '' GROUP BY A.`EntryID`  ");
  $query->execute();
  $fetch_data2 = $query->fetchAll(PDO::FETCH_ASSOC);
  foreach($fetch_data2 AS $fetch){
  ?>
             <tr>
             <td><?php if(!empty($fetch['CreateDate'])){ print date("d/m/y - h:i:s a",strtotime($fetch['CreateDate'])); } ?></td>
              <td><?php print $fetch['UserName']; ?></td>
              <td colspan="3"></td>
              <td><span class="badge bg-danger"><?php print $fetch['Cart']; ?></span></td>
<?php } ?>
</tbody>
</table>
</div>

</div>

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
