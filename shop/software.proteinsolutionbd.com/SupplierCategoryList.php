<?php
require_once("auth.php");
include("db.php");
include("count.php");
?>
<table id="SupplierCategoryView" class="table table-bordered table-striped">
  <thead>
  <tr>
        <th>Supplier Category Id</th>
        <th>Supplier Category Name</th>
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
      <th>Supplier Category Id</th>
      <th>Supplier Category Name</th>
      <th>Status</th>
      <?php if($EditAccess=='Yes'){ ?>
      <th>Update</th>
      <?php
      }
      ?>
    </tr>
  </tfoot>
</table>
