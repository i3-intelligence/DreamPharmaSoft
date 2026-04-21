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
        <label class="col-form-label" for="inputSuccess">Supplier Name</label>
        <input type="text" class="form-control" id="Name" value="">
      </div>

    </div>

    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Color Code</label>
        <select class="form-control" id="ColorCode" style="width: 100%;">

      <option value="Black" style="color:Black;font-weight:bold;">Black</option>
			<option value="Red" style="color:Red; font-weight:bold;">Red</option>
			<option value="Blue" style="color:Blue; font-weight:bold;">Blue</option>
			<option value="Green" style="color:Green; font-weight:bold;">Green</option>
			<option value="DarkKhaki" style="color:DarkKhaki; font-weight:bold;">DarkKhaki</option>
			<option value="Orange" style="color:Orange; font-weight:bold;">Orange</option>
			<option value="Pink" style="color:Pink; font-weight:bold;">Pink</option>
			<option value="Purple" style="color:Purple; font-weight:bold;">Purple</option>
			<option value="Brown" style="color:Brown; font-weight:bold;">Brown</option>
			<option value="Gold" style="color:Gold; font-weight:bold;">Gold</option>
			<option value="Olive" style="color:Olive; font-weight:bold;">Olive</option>
			<option value="DarkCyan" style="color:DarkCyan; font-weight:bold;">DarkCyan</option>
			<option value="Aqua" style="color:Aqua; font-weight:bold;">Aqua</option>
			<option value="Aquamarine" style="color:Aquamarine; font-weight:bold;">Aquamarine</option>
			<option value="Maroon" style="color:Maroon; font-weight:bold;">Maroon</option>
			<option value="Indigo" style="color:Indigo; font-weight:bold;">Indigo</option>
        </select>
      </div>

    </div>


  </div>

  <div class="row">

  <div class="col-md-6">
            <!-- input states -->
            <div class="form-group">
                <label class="col-form-label" for="inputSuccess">Supplier Category</label>
                <select class="form-control select2" id="SupplierCategoryID" style="width: 100%;">
                    <option value="">Select Supplier Category</option>

                    <?php
$query = $conn->prepare("SELECT * FROM `SupplierCategory` WHERE `Status` = 'Active' ORDER BY `Name` ASC");
$query->execute();
$FetchSupplierData = $query->fetchAll(PDO::FETCH_ASSOC);
foreach($FetchSupplierData AS $Fetch) {
?>
                    <option value="<?php print $Fetch['SupplierCategoryID']; ?>"><?php print sprintf("%03d", $Fetch['SupplierCategoryID']); ?> |
                        <?php print $Fetch['Name']; ?> </option>
                    <?php } ?>
                </select>
            </div>

        </div>

    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Mobile No</label>
        <input type="text" class="form-control" OnKeyUp="check_input();" id="MobileNo" value="0" <?php print $NumberValidity; ?>
          placeholder="">
      </div>

    </div>


    </div>


    <div class="row">

  
<div class="col-md-6">
    <!-- input states -->
    <div class="form-group">
      <label class="col-form-label" for="inputSuccess">Address</label>
          <textarea id="Address" class="form-control"></textarea>
    </div>
            
</div>  
  <div class="col-md-6">
    <!-- input states -->
    <div class="form-group">
      <label class="col-form-label" for="inputSuccess">Contact Person Details</label>
      <textarea id="ContactPersonInfo" class="form-control" ></textarea>

        
    </div>

  </div>


</div>

<div class="row">
<div class="col-md-6">
    <!-- input states -->
    <div class="form-group">
      <label class="col-form-label" for="inputSuccess">Opening Balance</label>
      <input type="text" class="form-control" OnKeyUp="check_input();" id="OpeningBalance" value="0" <?php print $QtyCheck; ?>>
    </div>

  </div>
</div>
  </div>


  

  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

    <input type="button" id="AddSupplier" onclick="AddSupplier();" value="Save Data" class="btn btn-success">
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