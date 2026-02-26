<?php
require_once 'Auth.php'; // Session Starting file
include 'Database.php'; // Database connection file
if(!empty($_GET['id'])){
?>
<!-- /.card-header -->
<div class="card-body">
  <div class="row">

    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess"><?php echo __("Medicine Name"); ?></label>
        <input type="text" class="form-control" onkeyup="check_input();" id="MedicineName" value=""
          placeholder="<?php echo __("Enter Medicine Name"); ?>">
      </div>

    </div>

    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess"> <?php echo __("Purchase Price"); ?></label>
        <input type="text" class="form-control" onkeyup="check_input();" id="PurchasePrice" value=""
          placeholder="<?php echo __("Enter Purchase Price"); ?>  ">
      </div>

    </div>


  </div>

  <div class="row">

    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess"><?php echo __("Unit Quantity"); ?></label>
        <input type="text" class="form-control" onkeyup="check_input();" id="PackSize"
          placeholder="<?php echo __("Enter Unit Quantity"); ?>">
      </div>

    </div>

    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess"><?php echo __("Sales Price"); ?></label>
        <input type="text" class="form-control" onkeyup="check_input();" id="SalePrice" value=""
          placeholder="<?php echo __("Enter Sales Price"); ?>">
      </div>

    </div>


  </div>


  
  <div class="row">

    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess"><?php echo __("Company Name"); ?></label>
        <input type="text"  list="CompanyList" class="form-control" onkeyup="check_input(),CompanyList();" id="Company"
          placeholder="<?php echo __("Enter Company Name"); ?>">
          <datalist id="CompanyList"></datalist>

          
      </div>

    </div>

    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess"><?php echo __("Generic Name"); ?></label>
        <input type="text" class="form-control" onkeyup="check_input(),GenericList();" id="Generic" value=""
          placeholder="<?php echo __("Enter Generic Name"); ?>" list="GenericList">
            <datalist id="GenericList"></datalist>
      </div>

    </div>

  </div>

  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __("Close"); ?></button>

    <input type="button" id="AddMedicine" onclick="AddMedicine();" value="<?php echo __("Save Data"); ?>" class="btn btn-success">
  </div>

</div>
  <script>
    function check_input() {
      var MedicineName = $('#MedicineName').val();
      var PurchasePrice = $('#PurchasePrice').val();
      var PackSize = $('#PackSize').val();
      var SalePrice = $('#SalePrice').val();


      if (/^[0-9-.  ]*$/.test(PurchasePrice) == false) {
        toastr.error('Your Text contains illegal characters.');
        playclip_warning();
        $('#PurchasePrice').val('');
      }

      if (/^[0-9-  ]*$/.test(PackSize) == false) {
        toastr.error('Your Text contains illegal characters.');
        playclip_warning();
        $('#PackSize').val('');
      }

      
      if (/^[0-9-.  ]*$/.test(SalePrice) == false) {
        toastr.error('Your Text contains illegal characters.');
        playclip_warning();
        $('#SalePrice').val('');
      }

    }
    //select2 
    $('.select2').select2({
      allowClear: false,
      theme: 'bootstrap4'
    });

    
  </script>

  <?php
}
?>