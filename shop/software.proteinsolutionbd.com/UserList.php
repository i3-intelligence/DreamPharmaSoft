<?php
require_once("auth.php");
include("db.php");
include("count.php");
?>
<table id="UserView" class="table table-bordered table-striped">
  <thead>
  <tr>
        <th>User Name</th>
        <th>User ID</th>
        <th>User Password</th>
        <th>Admin</th>
        <th>Edit Access</th>
        <th>Delete Access</th>
        <th>Block</th>
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
  <th>User Name</th>
        <th>User ID</th>
        <th>User Password</th>
        <th>Admin</th>
        <th>Edit Access</th>
        <th>Delete Access</th>
        <th>Block</th>
        <?php if($EditAccess=='Yes'){ ?>
        <th>Update</th>
        <?php
        }
        ?>
    </tr>
  </tfoot>
</table>
