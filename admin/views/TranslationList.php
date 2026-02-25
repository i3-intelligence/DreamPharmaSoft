<?php
require_once '../includes/Auth.php'; // Session Starting file
include '../config/Database.php'; // Database connection file
?>
<table id="TranslationView" class="table table-bordered table-striped">
  <thead>
    <tr>
        <th><?php echo "Id"; ?></th>
        <th><?php echo "Key"; ?></th>
        <th><?php echo "English"; ?></th>
        <th><?php echo "Bangla"; ?></th>
        <th><?php echo "Update"; ?></th>
    </tr>
  </thead>
  <tbody>
    
  </tbody>
  <tfoot>
  <tr>
        <th><?php echo "Id"; ?></th>
        <th><?php echo "Key"; ?></th>
        <th><?php echo "English"; ?></th>
        <th><?php echo "Bangla"; ?></th>
        <th><?php echo "Update"; ?></th>
    </tr>
  </tfoot>
</table>
