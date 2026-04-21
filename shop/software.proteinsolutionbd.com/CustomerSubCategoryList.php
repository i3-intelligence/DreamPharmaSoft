<?php
require_once("auth.php");
include("db.php");
include("count.php");
?>
<table id="CustomerSubCategoryView" class="table table-bordered table-striped">
  <thead>
  <tr>
        <th>Customer Sub Category Id</th>
        <th>Customer Sub Category Name</th>
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
      <th>Customer Sub Category Id</th>
      <th>Customer Sub Category Name</th>
      <th>Status</th>
      <?php if($EditAccess=='Yes'){ ?>
      <th>Update</th>
      <?php
      }
      ?>
    </tr>
  </tfoot>
</table>
