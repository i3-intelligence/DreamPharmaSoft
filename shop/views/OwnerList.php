<?php
require_once '../includes/Auth.php'; // Session Starting file
include '../config/Database.php'; // Database connection file
?>
<table id="OwnerView" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>SL</th>
        <th>Owner Name</th>
        <th>Owner Moblie No.</th>
        <th>Shop Name</th>
        <th>Shop Address </th>
        <th>Package Info. </th>
        <th>Subscription Start Date </th>
        <th>Subscription End Date </th>
      <th>Status</th>
      <th>Create Date</th>
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
        <th>Owner Name</th>
        <th>Owner Moblie No.</th>
        <th>Shop Name</th>
        <th>Shop Address </th>
        <th>Package Info. </th>
        <th>Subscription Start Date </th>
        <th>Subscription End Date </th>
      <th>Status</th>
      <th>Create Date</th>
      <?php if($EditAccess=='Yes'){ ?>
      <th>Update</th>
        <?php
        }
        ?>
    </tr>
  </tfoot>
</table>
