<?php
require_once("auth.php");
include("db.php");
include("count.php");
?>
<table id="WalletView" class="table table-bordered table-striped">
  <thead>
  <tr>
        <th>Wallet Id</th>
        <th>Wallet Name</th>
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
      <th>Wallet Id</th>
      <th>Wallet Name</th>
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
