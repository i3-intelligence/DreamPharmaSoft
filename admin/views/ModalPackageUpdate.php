<?php
require_once '../includes/auth.php'; // Session Starting file
include '../config/database.php'; // Database connection file

if(!empty($_GET['id'])){

$UpdateId = $_GET['id'];
$sql =$conn->prepare("SELECT * FROM `Package` WHERE `Id`='$UpdateId'");
$sql->execute();
$fetch = $sql->fetch(PDO::FETCH_ASSOC);

$PackageName = $fetch['PackageName']; 
$PacakageDuration = $fetch['PacakageDuration'];
$PacakageAmount = $fetch['PacakageAmount'];
$NumberOfUser = $fetch['NumberOfUser'];
$Status = $fetch['Status'];


?>
<!-- /.card-header -->
<div class="card-body">
  <div class="row">
  <input type="hidden" id="UpdateId" value="<?php print $UpdateId; ?>">
    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Package Name</label>
        <input type="text" class="form-control" onkeyup="check_input();" id="PackageName2"
          placeholder="Enter Package Name" value="<?php print $PackageName; ?>">
      </div>

    </div>


    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" class="form-control" for="inputSuccess">Pacakage Duration</label>
        <select id="PacakageDuration2" class="form-control select2">
          <option value="1 Month" <?php if($PacakageDuration == "1 Month"){ print "Selected";}?>>1 Month</option>
          <!-- <option value="2 Month" <?php //if($PacakageDuration == "2 Month"){ print "Selected";}?>>2 Month</option>
          <option value="3 Month" <?php //if($PacakageDuration == "3 Month"){ print "Selected";}?>>3 Month</option>
          <option value="4 Month" <?php //if($PacakageDuration == "4 Month"){ print "Selected";}?>>4 Month</option>
          <option value="5 Month" <?php //if($PacakageDuration == "5 Month"){ print "Selected";}?>>5 Month</option>
          <option value="6 Month" <?php //if($PacakageDuration == "6 Month"){ print "Selected";}?>>6 Month</option>
          <option value="7 Month" <?php //if($PacakageDuration == "7 Month"){ print "Selected";}?>>7 Month</option>
          <option value="8 Month" <?php //if($PacakageDuration == "8 Month"){ print "Selected";}?>>8 Month</option>
          <option value="9 Month" <?php //if($PacakageDuration == "9 Month"){ print "Selected";}?>>9 Month</option>
          <option value="10 Month" <?php //if($PacakageDuration == "10 Month"){ print "Selected";}?>>10 Month</option>
          <option value="11 Month" <?php //if($PacakageDuration == "11 Month"){ print "Selected";}?>>11 Month</option>
          <option value="12 Month" <?php //if($PacakageDuration == "12 Month"){ print "Selected";}?>>12 Month</option>
          <option value="1 Year" <?php //if($PacakageDuration == "1 Year"){ print "Selected";}?>>1 Year</option>
          <option value="2 Year" <?php //if($PacakageDuration == "2 Year"){ print "Selected";}?>>2 Year</option>
          <option value="3 Year" <?php //if($PacakageDuration == "3 Year"){ print "Selected";}?>>3 Year</option>
          <option value="4 Year" <?php //if($PacakageDuration == "4 Year"){ print "Selected";}?>>4 Year</option>
          <option value="5 Year" <?php //if($PacakageDuration == "5 Year"){ print "Selected";}?>>5 Year</option> -->

        </select>

      </div>

    </div>

  </div>

  <div class="row">

    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Package Price</label>
        <input type="text" class="form-control" onkeyup="check_input();" id="PacakageAmount2"
          value="<?php print $PacakageAmount; ?>" placeholder="Enter Package Price">
      </div>

    </div>
    

    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Number Of Users</label>
        <input type="text" class="form-control" onkeyup="check_input();" id="NumberOfUser2"
          value="<?php print $NumberOfUser; ?>" placeholder="Enter Package Price">
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

    <input type="button" id="UpdatePackage" onclick="UpdatePackage();" value="Update Data" class="btn btn-warning">
  </div>
</div>
  <script>
    function check_input() {
      var PackageName = $('#PackageName2').val();
      var PacakageAmount = $('#PacakageAmount2').val();
      if (/^[a-zA-Z0-9-  ]*$/.test(PackageName) == false) {
        toastr.error('Your Text contains illegal characters.');
        playclip_warning();
        $('#PackageName2').val('');
      }

      if (/^[0-9-  ]*$/.test(PacakageAmount) == false) {
        toastr.error('Your Text contains illegal characters.');
        playclip_warning();
        $('#PacakageAmount2').val('');
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