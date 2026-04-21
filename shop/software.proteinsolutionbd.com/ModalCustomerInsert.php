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
        <label class="col-form-label" for="inputSuccess">Customer Name</label>
        <input type="text" class="form-control" id="Name" value="">
      </div>

    </div>
    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Mobile No</label>
        <input type="text" class="form-control"  id="MobileNo" value="0" <?php print $NumberValidity; ?>
          placeholder="">
      </div>

    </div>

  </div>

  <div class="row">

  <div class="col-md-6">
            <!-- input states -->
            <div class="form-group">
                <label class="col-form-label" for="inputSuccess">Customer Category</label>
                <select class="form-control select2" id="CustomerCategoryID" style="width: 100%;">
                    <option value="">Select Customer Category</option>

                    <?php
$query = $conn->prepare("SELECT * FROM `CustomerCategory` WHERE `Status` = 'Active' ORDER BY `Name` ASC");
$query->execute();
$FetchCustomerData = $query->fetchAll(PDO::FETCH_ASSOC);
foreach($FetchCustomerData AS $Fetch) {
?>
                    <option value="<?php print $Fetch['CustomerCategoryID']; ?>"><?php print sprintf("%03d", $Fetch['CustomerCategoryID']); ?> |
                        <?php print $Fetch['Name']; ?> </option>
                    <?php } ?>
                </select>
            </div>

        </div>



  <div class="col-md-6">
            <!-- input states -->
            <div class="form-group">
                <label class="col-form-label" for="inputSuccess">Customer Sub Category</label>
                <select class="form-control select2" id="CustomerSubCategoryID" style="width: 100%;">
                    <option value="">Select Customer Sub Category</option>

                    <?php
$query = $conn->prepare("SELECT * FROM `CustomerSubCategory` WHERE `Status` = 'Active' ORDER BY `Name` ASC");
$query->execute();
$FetchCustomerData = $query->fetchAll(PDO::FETCH_ASSOC);
foreach($FetchCustomerData AS $Fetch) {
?>
                    <option value="<?php print $Fetch['CustomerSubCategoryID']; ?>"><?php print sprintf("%03d", $Fetch['CustomerSubCategoryID']); ?> |
                        <?php print $Fetch['Name']; ?> </option>
                    <?php } ?>
                </select>
            </div>

        </div>

    </div>


    <div class="row">

  
<div class="col-md-6">
    <!-- input states -->
    <div class="form-group">
      <label class="col-form-label" for="inputSuccess">Address</label>
          <input type="text" class="form-control" id="Address" value="" <?php print $AutoComplete; ?> list="CustomerAddressList" OnKeyUp="CustomerAddressList();">
        <datalist id="CustomerAddressList"></datalist>
    </div>
            
</div>  
  <div class="col-md-6">
    <!-- input states -->
    <div class="form-group">
      <label class="col-form-label" for="inputSuccess">Credit Limit</label>
      <input type="text" class="form-control" OnKeyUp="check_input();" id="CreditLimit" value="0" <?php print $QtyCheck; ?>>
    </div>

  </div>


</div>

<div class="row">
<div class="col-md-6">
    <!-- input states -->
    <div class="form-group">
      <label class="col-form-label" for="inputSuccess">Opening Balance</label>
      <input type="Text" readonly class="form-control" OnKeyUp="check_input();" id="OpeningBalance" value="0" <?php print $QtyCheck; ?>>
    </div>

  </div>
</div>
  </div>


  

  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

    <input type="button" id="AddCustomer" onclick="AddCustomer();" value="Save Data" class="btn btn-success">
  </div>

</div>
  <script>
    function check_input() {
      var MobileNo = $('#MobileNo').val();
      var OpeningBalance = $('#OpeningBalance').val();


      // if (/^[0-9-.  ]*$/.test(MobileNo) == false) {
      //   toastr.error('Your Text contains illegal characters.');
      //   playclip_warning();
      //   $('#MobileNo').val('');
      // }

      // if (/^[0-9-.  ]*$/.test(OpeningBalance) == false) {
      //   toastr.error('Your Text contains illegal characters.');
      //   playclip_warning();
      //   $('#OpeningBalance').val('');
      // }
      

    }
    //select2 
    $('.select2').select2({
      theme: 'bootstrap4'
    });

    
  </script>

  <?php
}
?>