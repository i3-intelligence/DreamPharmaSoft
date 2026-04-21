<?php
require_once("auth.php");
include("db.php");
if(!empty($_GET['id'])){
?>

<!-- /.card-header -->
<div class="card-body">
  <div class="row">

    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Item Category Name</label>
        <input type="text" class="form-control" id="Name" value="">
      </div>

    </div>

    
  <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Supplier Info</label>
        <select class="form-control select2" id="SupplierID" style="width: 100%;">
                        <option value="">Select Supplier</option>

                        <?php
                    $query = $conn->prepare("SELECT * FROM `Supplier` WHERE `Status` = 'Active' ORDER BY `Name` ASC");
                    $query->execute();
                    $FetchSupplierData = $query->fetchAll(PDO::FETCH_ASSOC);
                    foreach($FetchSupplierData AS $Fetch) {
                    ?>
                        <option value="<?php print $Fetch['SupplierID']; ?>"><?php print sprintf("%03d", $Fetch['SupplierID']); ?> | <?php print $Fetch['Name']; ?> | <?php print $Fetch['MobileNo']; ?> | <?php print $Fetch['Address']; ?></option>
                        <?php } ?>
                        </select>
      </div>

    </div>

    </div>


  </div>


    </div>


  </div>
  
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

    <input type="button" id="AddItemCategory" onclick="AddItemCategory();" value="Save Data" class="btn btn-success">
  </div>

</div>
<script>
//select2 
$('.select2').select2({
  allowClear: false,
  theme: 'bootstrap4',
  templateResult: formatOutput,
});
function formatOutput (optionElement) {
  if (!optionElement.id) { return optionElement.text; }
  var $state = $('<span><strong>' + optionElement.element.text + '</strong>');
  return $state;
};
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
      
    });


</script>
  <?php
}
?>
