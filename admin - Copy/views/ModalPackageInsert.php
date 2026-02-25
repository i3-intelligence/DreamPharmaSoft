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
        <label class="col-form-label" for="inputSuccess">Package Name</label>
        <input type="text" class="form-control" onkeyup="check_input();" id="PackageName" value=""
          placeholder="Enter Package Name">
      </div>

    </div>


    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" class="form-control" for="inputSuccess">Pacakage Duration</label>
        <select id="PacakageDuration" class="form-control select2">
          <option value="1 Month">1 Month</option>
          <!-- <option value="2 Month">2 Month</option>
          <option value="3 Month">3 Month</option>
          <option value="4 Month">4 Month</option>
          <option value="5 Month">5 Month</option>
          <option value="6 Month">6 Month</option>
          <option value="7 Month">7 Month</option>
          <option value="8 Month">8 Month</option>
          <option value="9 Month">9 Month</option>
          <option value="10 Month">10 Month</option>
          <option value="11 Month">11 Month</option>
          <option value="12 Month">12 Month</option>
          <option value="1 Year">1 Year</option>
          <option value="2 Year">2 Year</option>
          <option value="3 Year">3 Year</option>
          <option value="4 Year">4 Year</option>
          <option value="5 Year">5 Year</option> -->
        </select>

      </div>

    </div>

  </div>

  <div class="row">

    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Package Price</label>
        <input type="text" class="form-control" onkeyup="check_input();" id="PacakageAmount" value=""
          placeholder="Enter Package Price">
      </div>

    </div>

    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Number Of Users</label>
        <input type="text" class="form-control" onkeyup="check_input();" id="NumberOfUser"
          placeholder="Enter Number Of Users">
      </div>

    </div>

  </div>


  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

    <input type="button" id="AddPackage" onclick="AddPackage();" value="Save Data" class="btn btn-success">
  </div>

</div>

  <script>
    function check_input() {
      var PackageName = $('#PackageName').val();
      var PacakageAmount = $('#PacakageAmount').val();
      var NumberOfUser = $('#NumberOfUser').val();
      if (/^[a-zA-Z0-9-  ]*$/.test(PackageName) == false) {
        toastr.error('Your Text contains illegal characters.');
        playclip_warning();
        $('#PackageName').val('');
      }

      if (/^[0-9-  ]*$/.test(PacakageAmount) == false) {
        toastr.error('Your Text contains illegal characters.');
        playclip_warning();
        $('#PacakageAmount').val('');
      }

      
      if (/^[0-9-  ]*$/.test(NumberOfUser) == false) {
        toastr.error('Your Text contains illegal characters.');
        playclip_warning();
        $('#NumberOfUser').val('');
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