<?php
require_once '../includes/Auth.php'; // Session Starting file
include '../config/Database.php'; // Database connection file
if(!empty($_GET['id'])){
    $UpdateId = $_GET['id'];
    $sql =$conn->prepare("SELECT * FROM `medicine` WHERE `MedicineID`='$UpdateId'");
    $sql->execute();
    $fetch = $sql->fetch(PDO::FETCH_ASSOC);
    $MedicineName = $fetch['MedicineName'];
    $PurchasePrice = $fetch['PurchasePrice'];
    $PackSize = $fetch['PackSize'];
    $SalePrice = $fetch['SalePrice'];
    $Company = $fetch['Company'];
    $Generic = $fetch['Generic'];
    $Status = $fetch['Status'];
?>

<!-- /.card-header -->
<div class="card-body">
  <div class="row">
  <input type="hidden" id="UpdateId" value="<?php print $UpdateId; ?>">
    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Medicine Name</label>
        <input type="text" class="form-control" onkeyup="check_input();" id="MedicineName2"
          placeholder="Enter Medicine Name" value="<?php print $MedicineName; ?>">
      </div>

    </div>

    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Purchase Price</label>
        <input type="text" class="form-control" onkeyup="check_input();" id="PurchasePrice2"
          placeholder="Enter Purchase Price" value="<?php print $PurchasePrice; ?>">
      </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
        <!-- input states -->
        <div class="form-group">
            <label class="col-form-label" for="inputSuccess">Unit Quantity</label>
            <input type="text" class="form-control" onkeyup="check_input();" id="PackSize2"
            placeholder="Enter Unit Quantity" value="<?php print $PackSize; ?>">
        </div>

        </div>


        <div class="col-md-6">
        <!-- input states -->
        <div class="form-group">
            <label class="col-form-label" for="inputSuccess">Sales Price</label>
            <input type="text" class="form-control" onkeyup="check_input();" id="SalePrice2"
            placeholder="Enter Sales Price" value="<?php print $SalePrice; ?>">
        </div>

        </div>
    </div>

<div class="row">
        <div class="col-md-6">
        <!-- input states -->
        <div class="form-group">
            <label class="col-form-label" for="inputSuccess">Company</label>
            <input type="text" class="form-control" onkeyup="check_input();" id="Company2"
            placeholder="Enter Company Name" value="<?php print $Company; ?>">
        </div>

        </div>


        <div class="col-md-6">
        <!-- input states -->

        <div class="form-group">
            <label class="col-form-label" for="inputSuccess">Generic Name</label>
            <input type="text" class="form-control" onkeyup="check_input();" id="Generic2"
            placeholder="Enter Generic Name" value="<?php print $Generic; ?>">
        </div>

        </div>
    </div>
    
   
    <div class="row">
    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Status</label>
        <select id="Status" class="form-control select2">
          <option value="Active" <?php if($Status == "Active"){ print "Selected";} ?>>Active</option>
          <option value="Inactive" <?php if($Status == "Inactive"){ print "Selected";} ?>>Inactive</option>
        </select>
      </div>
    </div>

  </div>


  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

    <input type="button" id="UpdateMedicine" onclick="UpdateMedicine();" value="Update Data" class="btn btn-warning">
  </div>
</div>

<script>
    function check_input() {
      var PurchasePrice = $('#PurchasePrice2').val();
      var PackSize = $('#PackSize2').val();
      var SalePrice = $('#SalePrice2').val();
      var Company = $('#Company2').val();
      var Generic = $('#Generic2').val();

      
      if (/^[0-9-.  ]*$/.test(PurchasePrice) == false) {
        toastr.error('Your Text contains illegal characters.');
        playclip_warning();
        $('#PurchasePrice2').val('');
      }

      if (/^[0-9-  ]*$/.test(PackSize) == false) {
        toastr.error('Your Text contains illegal characters.');
        playclip_warning();
        $('#PackSize2').val('');
      }

      
      if (/^[0-9-.  ]*$/.test(SalePrice) == false) {
        toastr.error('Your Text contains illegal characters.');
        playclip_warning();
        $('#SalePrice2').val('');
      }

    }

    
    //select2 
    $('.select2').select2({
      allowClear: false,
      theme: 'bootstrap4'

    });
  </script>
<?php } ?>    