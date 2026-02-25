<?php
require_once 'Auth.php'; // Session Starting file
include 'Database.php'; // Database connection file
?>
<table id="PackageView" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>SL</th>
        <th>Package Name</th>
        <th>Package Duration</th>
        <th>Package Price</th>
        <th>Number Of Users</th>
        <th>Description</th>
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
        <th>Description</th>
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
