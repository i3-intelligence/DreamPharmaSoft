<?php
require_once("auth.php");
include("db.php");
include("count.php");
?>
<table id="BankView" class="table table-bordered table-striped">
  <thead>
  <tr>
        <th>Bank Id</th>
        <th>Branch Name</th>
        <th>Branch Name</th>
        <th>Account Name</th>
        <th>Account Number</th>
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
        <th>Bank Id</th>
        <th>Branch Name</th>
        <th>Branch Name</th>
        <th>Account Name</th>
        <th>Account Number</th>
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
