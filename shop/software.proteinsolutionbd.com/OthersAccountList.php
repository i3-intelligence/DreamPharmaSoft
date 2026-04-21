<?php
require_once("auth.php");
include("db.php");
include("count.php");
?>
<table id="OthersAccountView" class="table table-bordered table-striped">
  <thead>
  <tr>
        <th>Others Account Id</th>
        <th>Sector Name</th>
        <th>Account Name</th>
        <th>Mobile No</th>
        <th>Credit Limit</th>
        <th>Category</th>
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
        <th>Others Account Id</th>
        <th>Sector Name</th>
        <th>Account Name</th>
        <th>Mobile No</th>
        <th>Credit Limit</th>
        <th>Category</th>
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
