<?php
require_once("auth.php");
include("db.php");
include("count.php");
?>
<table id="CustomerView" class="table table-bordered table-striped">
  <thead>
    <tr>
        <th>Customer Id</th>
        <th>Customer Name</th>
        <th>Customer Category</th>
        <th>Customer Sub Category</th>
        <th>Mobile No</th>
        <th>Address</th>
        <th>Credit Limit</th>
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
  <th>Customer Id</th>
        <th>Customer Name</th>
        <th>Customer Category</th>
        <th>Customer Sub Category</th>
        <th>Mobile No</th>
        <th>Address</th>
        <th>Credit Limit</th>
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
