<?php
require_once '../includes/Auth.php'; // Session Starting file
if(!empty($_GET['id'])){
?>
<!-- /.card-header -->
<div class="card-body">
  <div class="row">

    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Medicine Name</label>
        <input type="text" class="form-control" onkeyup="check_input();" id="MedicineName" value=""
          placeholder="Enter Medicine Name">
      </div>

    </div>

    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Purchase Price</label>
        <input type="text" class="form-control" onkeyup="check_input();" id="PurchasePrice" value=""
          placeholder="Enter Purchase Price">
      </div>

    </div>


  </div>

  <div class="row">

    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Unit Quantity</label>
        <input type="text" class="form-control" onkeyup="check_input();" id="PackSize"
          placeholder="Enter Unit Quantity">
      </div>

    </div>

    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Sales Price</label>
        <input type="text" class="form-control" onkeyup="check_input();" id="SalePrice" value=""
          placeholder="Enter Sales Price">
      </div>

    </div>


  </div>


  
  <div class="row">

    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Company Name</label>
        <input type="text"  list="CompanyList" class="form-control" onkeyup="check_input(),CompanyList();" id="Company"
          placeholder="Enter Company Name">
          <datalist id="CompanyList"></datalist>

          
      </div>

    </div>

    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Enter Generic Name</label>
        <input type="text" class="form-control" onkeyup="check_input(),GenericList();" id="Generic" value=""
          placeholder="Enter Generic Name" list="GenericList">
            <datalist id="GenericList"></datalist>
      </div>

    </div>

  </div>

  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

    <input type="button" id="AddMedicine" onclick="AddMedicine();" value="Save Data" class="btn btn-success">
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