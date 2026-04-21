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
        <label class="col-form-label" for="inputSuccess">Sector Name</label>
        <input type="text" class="form-control" id="SectorName" value="" <?php print $AutoComplete; ?> list="SectorNameList" OnKeyUp="SectorNameList();">
        <datalist id="SectorNameList"></datalist>
      </div>

    </div>
    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Others Account Name</label>
        <input type="text" class="form-control" id="OthersAccountName" value="" <?php print $AutoComplete; ?> >
      </div>

    </div>
    </div>

    <div class="row">

<div class="col-md-6">
  <!-- input states -->
  <div class="form-group">
    <label class="col-form-label" for="inputSuccess">Mobile No</label>
    <input type="text" class="form-control" id="MobileNo" value="0" <?php print $NumberValidity; ?> <?php print $AutoComplete; ?>>
  </div>

</div>
<div class="col-md-6">
  <!-- input states -->
  <div class="form-group">
    <label class="col-form-label" for="inputSuccess">Credit Limit</label>
    <input type="text" class="form-control" id="CreditLimit" <?php print $QtyCheck; ?> value="0">
  </div>

</div>
</div>

<div class="row">
    
<div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Category</label>
        <select class="form-control select2" id="Category">
          <option value="All">All Category</option>
          <option value="Receivale">Receivale</option>
          <option value="Payable">Payable</option>
        </select>
      </div>

    </div>

<div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Opening Balance</label>
        <input type="text" class="form-control" id="OpeningBalance" <?php print $QtyCheck; ?> value="0">
      </div>

    </div>
</div>
  </div>


    </div>


  </div>
  
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <input type="button" id="AddOthersAccount" onclick="AddOthersAccount();" value="Save Data" class="btn btn-success">
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
