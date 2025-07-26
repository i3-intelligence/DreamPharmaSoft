<?php
require_once '../includes/Auth.php'; // Session Starting file
include '../config/Database.php'; // Database connection file

if(!empty($_GET['id'])){

?>
<!-- /.card-header -->
<div class="card-body">
  <div class="row">

    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Owner Name</label>
        <input type="text" class="form-control" onkeyup="check_input();" id="OwnerName" value=""
          placeholder="Enter Owner Name">
      </div>

    </div>


    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Owner Moblie No.</label>
        <input type="text" class="form-control" onkeyup="check_input();" id="Phone" value="0" <?php print $NumberValidity; ?>
          placeholder="Enter Owner Mobile No.">
      </div>

    </div>


  </div>

  <div class="row">

  <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Shop Name</label>
        <input type="text" class="form-control" onkeyup="check_input();" id="ShopName" value=""
          placeholder="Enter Shop Name">
      </div>

    </div>

    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Shop Address</label>
        <textarea class="form-control" onkeyup="check_input();" id="ShopAddress" value=""  placeholder="Enter Shop Address"></textarea>
      </div>

    </div>

  </div>

  <div class="row">

  <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Package Select</label>
            <select name="" id="PackageId" class="form-control select2">
                <option value="">Select One</option>
            <?php
         $sql_query = $conn->prepare("SELECT * FROM `package` WHERE `Status` = 'Active' ORDER BY `NumberOfUser` ASC");
         $sql_query->execute();
         $FetchData = $sql_query->fetchAll(PDO::FETCH_ASSOC);
            foreach($FetchData AS $fetch){
            ?>
              <option value="<?php print $fetch['Id']; ?>"><?php print $fetch['PackageName']; ?> / <?php print $fetch['PacakageDuration']; ?>  / <?php print $fetch['PacakageAmount']; ?> Tk / <?php print $fetch['NumberOfUser']; ?> Users</option>
              <?php } ?>
            </select>
      </div>

    </div>

    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Subscription Start Date</label>
        <input type="date" class="form-control" onkeyup="check_input();" id="SubscriptionStartDate" value="<?php print $CurrentDate; ?>"
          placeholder="Enter Subscription Start Date">
      </div>

    </div>

  </div>

  <div>
  <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Subscription End Date</label>
        <input type="date" class="form-control" onkeyup="check_input();" id="SubscriptionEndDate" value="<?php print date("Y-m-d", strtotime(date( "Y-m-d", strtotime($CurrentDate)) . "+1 month" ) ); ?>"
          placeholder="Enter Subscription End Date">
      </div>

    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

    <input type="button" id="AddOwner" onclick="AddOwner();" value="Save Data" class="btn btn-success">
  </div>

</div>
  <script>
    function check_input() {
      var OwnerName = $('#OwnerName').val();
      var Phone = $('#Phone').val();

      if (/^[a-zA-Z0-9-  ]*$/.test(OwnerName) == false) {
        toastr.error('Your Text contains illegal characters.');
        playclip_warning();
        $('#OwnerName').val('');
      }

      if (/^[0-9-  ]*$/.test(Phone) == false) {
        toastr.error('Your Text contains illegal characters.');
        playclip_warning();
        $('#Phone').val('');
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