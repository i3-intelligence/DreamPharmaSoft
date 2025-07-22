<?php
require_once '../includes/Auth.php'; // Session Starting file
include '../config/Database.php'; // Database connection file
?>
<table id="PackageView" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>SL</th>
        <th>Package Name</th>
        <th>Package Duration</th>
        <th>Package Price</th>
        <th>Number Of Users</th>
      <th>Status</th>
      <th>Create Date/Last Update</th>
      <?php if($EditAccess=='Yes'){ ?>
      <th>Update</th>
        <?php
        }
        ?>
    </tr>
  </thead>
  <tbody>
    
  </tbody>
  <tfoot>
  <tr>
      <th>SL</th>
        <th>Package Name</th>
        <th>Package Duration</th>
        <th>Package Price</th>
        <th>Number Of Users</th>
      <th>Status</th>
      <th>Create Date/Last Update</th>
      <?php if($EditAccess=='Yes'){ ?>
      <th>Update</th>
        <?php
        }
        ?>
    </tr>
  </tfoot>
</table>
