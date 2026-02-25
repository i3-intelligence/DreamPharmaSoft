<?php
require_once '../includes/Auth.php'; // Session Starting file
include '../config/Database.php'; // Database connection file
?>
<div class="row">

  <div class="col-md-12">
    <div class="form-group">
      <label><?php echo "Translation Key"; ?></label>
      <input type="text" class="form-control" id="translation_key" placeholder="<?php echo "e.g. SL, Medicine Name"; ?>" <?php echo $AutoComplete; ?>>
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label><?php echo "English Translation"; ?></label>
      <textarea class="form-control" id="en" rows="3"></textarea>
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label><?php echo "Bangla Translation"; ?></label>
      <textarea class="form-control" id="bn" rows="3"></textarea>
    </div>
  </div>

</div>

<div class="modal-footer justify-content-between">
  <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo "Close"; ?></button>
  <input type="button" class="btn btn-primary" id="AddTranslation" onclick="AddTranslation()" value="<?php echo "Save Data"; ?>">
</div>
