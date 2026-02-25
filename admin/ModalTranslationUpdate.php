<?php
require_once 'Auth.php'; // Session Starting file
include 'Database.php'; // Database connection file

$id = $_GET['id'];
$query = $conn->prepare("SELECT * FROM `app_translations` WHERE `id` = :id");
$query->execute(['id' => $id]);
$row = $query->fetch(PDO::FETCH_ASSOC);
?>
<div class="row">
  <input type="hidden" id="UpdateId" value="<?php echo $row['id']; ?>">

  <div class="col-md-12">
    <div class="form-group">
      <label><?php echo "Translation Key"; ?></label>
      <input type="text" class="form-control" id="translation_key2" value="<?php echo $row['translation_key']; ?>" <?php echo $AutoComplete; ?>>
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label><?php echo "English Translation"; ?></label>
      <textarea class="form-control" id="en2" rows="3"><?php echo $row['en']; ?></textarea>
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label><?php echo "Bangla Translation"; ?></label>
      <textarea class="form-control" id="bn2" rows="3"><?php echo $row['bn']; ?></textarea>
    </div>
  </div>

</div>

<div class="modal-footer justify-content-between">
  <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo "Close"; ?></button>
  <input type="button" class="btn btn-primary" id="UpdateTranslation" onclick="UpdateTranslation()" value="<?php echo "Update Data"; ?>">
</div>
