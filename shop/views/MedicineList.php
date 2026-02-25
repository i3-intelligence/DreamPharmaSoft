<?php
require_once '../includes/Auth.php'; // Session Starting file
include '../config/Database.php'; // Database connection file
?>
<table id="MedicineView" class="table table-bordered table-striped">
  <thead>
    <tr>
        <th><?php echo __("SL"); ?></th>
        <th><?php echo __("Medicine Name"); ?></th>
        <th><?php echo __("Purchase Price"); ?></th>
        <th><?php echo __("Unit Quantity"); ?></th>
        <th><?php echo __("Sales Price"); ?></th>
        <th><?php echo __("Company Name"); ?></th>
        <th><?php echo __("Generic Name"); ?></th>
        <th><?php echo __("Status"); ?></th>
      <?php if($EditAccess=='Yes'){ ?>
      <th><?php echo __("Update"); ?></th>
        <?php
        }
        ?>
    </tr>
  </thead>
  <tbody>
    
  </tbody>
  <tfoot>
  <tr>
        <th><?php echo __("SL"); ?></th>
        <th><?php echo __("Medicine Name"); ?></th>
        <th><?php echo __("Purchase Price"); ?></th>
        <th><?php echo __("Unit Quantity"); ?></th>
        <th><?php echo __("Sales Price"); ?></th>
        <th><?php echo __("Company Name"); ?></th>
        <th><?php echo __("Generic Name"); ?></th>
        <th><?php echo __("Status"); ?></th>
      <?php if($EditAccess=='Yes'){ ?>
      <th><?php echo __("Update"); ?></th>
        <?php
        }
        ?>
    </tr>
  </tfoot>
</table>
