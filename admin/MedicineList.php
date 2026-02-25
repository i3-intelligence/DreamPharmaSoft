<?php
require_once 'Auth.php'; // Session Starting file
include 'Database.php'; // Database connection file
?>
<table id="MedicineView" class="table table-bordered table-striped">
  <thead>
    <tr>
        <th><?php echo "SL"; ?></th>
        <th><?php echo "Medicine Name"; ?></th>
        <th><?php echo "Purchase Price"; ?></th>
        <th><?php echo "Unit Quantity"; ?></th>
        <th><?php echo "Sales Price"; ?></th>
        <th><?php echo "Company"; ?></th>
        <th><?php echo "Generic Name"; ?></th>
      <th><?php echo "Status"; ?></th>
      <?php if($EditAccess=='Yes'){ ?>
      <th><?php echo "Update"; ?></th>
        <?php
        }
        ?>
    </tr>
  </thead>
  <tbody>
    
  </tbody>
  <tfoot>
  <tr>
        <th><?php echo "SL"; ?></th>
        <th><?php echo "Medicine Name"; ?></th>
        <th><?php echo "Purchase Price"; ?></th>
        <th><?php echo "Unit Quantity"; ?></th>
        <th><?php echo "Sales Price"; ?></th>
        <th><?php echo "Company"; ?></th>
        <th><?php echo "Generic Name"; ?></th>
      <th><?php echo "Status"; ?></th>
      <?php if($EditAccess=='Yes'){ ?>
      <th><?php echo "Update"; ?></th>
        <?php
        }
        ?>
    </tr>
  </tfoot>
</table>
