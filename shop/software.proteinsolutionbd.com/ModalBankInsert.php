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
        <label class="col-form-label" for="inputSuccess">Branch Name</label>
        <input type="text" class="form-control" id="BranchName" value="" <?php print $AutoComplete; ?> list="BranchList" OnKeyUp="BranchList();">
        <datalist id="BranchList">
          
        </datalist>
      </div>

    </div>
    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Bank Name</label>
        <input type="text" class="form-control" id="BankName" value="" <?php print $AutoComplete; ?> list="BankNameList" OnKeyUp="BankNameList();">
      <datalist id="BankNameList"></datalist>
      </div>

    </div>
    </div>

    <div class="row">

<div class="col-md-6">
  <!-- input states -->
  <div class="form-group">
    <label class="col-form-label" for="inputSuccess">Account Name</label>
    <input type="text" class="form-control" id="AccountName" value=""<?php print $AutoComplete; ?> list="AccountNameList" OnKeyUp="AccountNameList();">
      <datalist id="AccountNameList"></datalist>
  </div>

</div>
<div class="col-md-6">
  <!-- input states -->
  <div class="form-group">
    <label class="col-form-label" for="inputSuccess">Account Number</label>
    <input type="text" class="form-control" id="AccountNumber" value="">
  </div>

</div>
</div>

<div class="row">
    
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
    <input type="button" id="AddBank" onclick="AddBank();" value="Save Data" class="btn btn-success">
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
