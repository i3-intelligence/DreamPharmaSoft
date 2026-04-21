<?php
require_once("auth.php");
include("db.php");
include("count.php");
?>
<table id="ItemCategoryView" class="table table-bordered table-striped">
  <thead>
  <tr>
        <th>Item Category Id</th>
        <th>Item Category Name</th>
        <th>Supplier Info</th>
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
      <th>Item Category Id</th>
      <th>Item Category Name</th>
      <th>Supplier Info</th>
      <th>Status</th>
      <?php if($EditAccess=='Yes'){ ?>
      <th>Update</th>
      <?php
      }
      ?>
    </tr>
  </tfoot>
</table>
