<?php
require_once("auth.php");
include("db.php");
include("count.php");
?>
<table id="PackageSizeView" class="table table-bordered table-striped">
  <thead>
  <tr>
        <th>Package Size Id</th>
        <th>Package Size</th>
        <th>Mode Of Packet</th>
        <th>Item Category</th>
        <th>Supplier Info</th>
        <th>Low Stock</th>
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
        <th>Package Size Id</th>
        <th>Package Size</th>
        <th>Mode Of Packet</th>
        <th>Item Category</th>
        <th>Supplier Info</th>
        <th>Low Stock</th>
        <th>Status</th>
        <?php if($EditAccess=='Yes'){ ?>
        <th>Update</th>
        <?php
        }
        ?>
    </tr>
  </tfoot>
</table>
