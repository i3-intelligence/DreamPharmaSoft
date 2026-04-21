<?php
require_once("auth.php");
include("db.php");
include("count.php");
?>
<table id="SupplierView" class="table table-bordered table-striped">
  <thead>
    <tr>
        <th>Supplier Id</th>
        <th>Color Code</th>
        <th>Supplier Name</th>
        <th>Supplier Category</th>
        <th>Mobile No</th>
        <th>Address</th>
        <th>Contact Person Details</th>
        <th>Opening Balance</th>
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
        <th>Supplier Id</th>
        <th>Color Code</th>        
        <th>Supplier Name</th>
        <th>Supplier Category</th>
        <th>Mobile No</th>
        <th>Address</th>
        <th>Contact Person Details</th>
        <th>Opening Balance</th>
      <th>Status</th>
      <?php if($EditAccess=='Yes'){ ?>
      <th>Update</th>
        <?php
        }
        ?>
    </tr>
  </tfoot>
</table>
