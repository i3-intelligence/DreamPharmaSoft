<?php
require_once("auth.php");
include("db.php");
include("count.php");
?>
<table id="CustomerCategoryView" class="table table-bordered table-striped">
  <thead>
  <tr>
        <th>Customer Category Id</th>
        <th>Customer Category Name</th>
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
      <th>Customer Category Id</th>
      <th>Customer Category Name</th>
      <th>Status</th>
      <?php if($EditAccess=='Yes'){ ?>
      <th>Update</th>
      <?php
      }
      ?>
    </tr>
  </tfoot>
</table>
