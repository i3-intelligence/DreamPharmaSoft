<?php
require_once '../includes/Auth.php'; // Session Starting file
include '../config/Database.php'; // Database connection file
?>
<table id="MedicineView" class="table table-bordered table-striped">
  <thead>
    <tr>
        <th>SL</th>
        <th>Medicine Name</th>
        <th>Purchase Price</th>
        <th>Unit Quantity</th>
        <th>Sales Price</th>
        <th>Company</th>
        <th>Generic Name</th>
      <th>Status</th>
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
        <th>Medicine Name</th>
        <th>Purchase Price</th>
        <th>Unit Quantity</th>
        <th>Sales Price</th>
        <th>Company</th>
        <th>Generic Name</th>
      <th>Status</th>
      <?php if($EditAccess=='Yes'){ ?>
      <th>Update</th>
        <?php
        }
        ?>
    </tr>
  </tfoot>
</table>
