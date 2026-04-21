<?php
require_once("auth.php");
include("db.php");
if(!empty($_GET['id'])){
    $UpdateId = $_GET['id'];
    $sql =$conn->prepare("SELECT 
                                A.`Name`,
                                A.`ColorCode`,
                                A.`SupplierCategoryID`,
                                A.`MobileNo`,
                                A.`Address`,
                                A.`ContactPersonInfo`,
                                A.`OpeningBalance`,
                                A.`Status`,
                                A.`CreateDate`,
                                A.`LastModifiedDate`,
                                CONCAT(B.`UserName`,' - ', B.`Designation`,' - ', B.`Phone`) AS `EntryInfo`,
                                CONCAT(C.`UserName`,' - ', C.`Designation`,' - ', C.`Phone`) AS `UpdateInfo`
                          FROM `Supplier` A 
                          LEFT JOIN `UserInformation` B ON (A.`EntryID` = B.`Id`)
                          LEFT JOIN `UserInformation` C ON (A.`UpdateId` = C.`Id`)
                          WHERE A.`SupplierID`='$UpdateId'");
    $sql->execute();
    $fetch = $sql->fetch(PDO::FETCH_ASSOC);
    $Name = $fetch['Name'];
    $ColorCode = $fetch['ColorCode'];
    $SupplierCategoryID = $fetch['SupplierCategoryID'];
    $MobileNo = $fetch['MobileNo'];
    $Address = $fetch['Address'];
    $ContactPersonInfo = $fetch['ContactPersonInfo'];
    $OpeningBalance = $fetch['OpeningBalance'];
    $Status = $fetch['Status'];
    $EntryInfo = $fetch['EntryInfo'];
    $EntryDateTime =  date("d-m-y | h:i:s a",strtotime($fetch['CreateDate']));
    $UpdateInfo = $fetch['UpdateInfo'];
    $UpdateDateTime =  date("d-m-y | h:i:s a",strtotime($fetch['LastModifiedDate']));


?>

<!-- /.card-header -->
<div class="card-body">
  <div class="row">
  <div class="col-md-6">
      <div class="alert alert-success alert-dismissible">
        <h5><i class="icon fas fa-exclamation-triangle"></i> Entry Information!</h5>
        <?php print $EntryInfo; ?> | <?php print $EntryDateTime; ?>
      </div>

    </div>

    <div class="col-md-6">
      <div class="alert alert-warning alert-dismissible">
        <h5><i class="icon fas fa-exclamation-triangle"></i> Update Information!</h5>
        <?php print $UpdateInfo; ?> | <?php print $UpdateDateTime; ?>
      </div>

    </div>
  </div>
  <div class="row">

    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Supplier Name</label>
        <input type="text" class="form-control" id="Name" value="<?php print $Name; ?>">
      </div>

    </div>

    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Color Code</label>
        <select class="form-control" id="ColorCode" style="width: 100%;">
          <option value="Black" <?php if($ColorCode=='Black'){ print "Selected"; } ?>
            style="color:Black;font-weight:bold;">Black</option>
          <option value="Red" <?php if($ColorCode=='Red'){ print "Selected"; } ?> style="color:Red; font-weight:bold;">
            Red</option>
          <option value="Blue" <?php if($ColorCode=='Blue'){ print "Selected"; } ?>
            style="color:Blue; font-weight:bold;">Blue</option>
          <option value="Green" <?php if($ColorCode=='Green'){ print "Selected"; } ?>
            style="color:Green; font-weight:bold;">Green</option>
          <option value="DarkKhaki" <?php if($ColorCode=='DarkKhaki'){ print "Selected"; } ?>
            style="color:DarkKhaki; font-weight:bold;">DarkKhaki</option>
          <option value="Orange" <?php if($ColorCode=='Orange'){ print "Selected"; } ?>
            style="color:Orange; font-weight:bold;">Orange</option>
          <option value="Pink" <?php if($ColorCode=='Pink'){ print "Selected"; } ?>
            style="color:Pink; font-weight:bold;">Pink</option>
          <option value="Purple" <?php if($ColorCode=='Purple'){ print "Selected"; } ?>
            style="color:Purple; font-weight:bold;">Purple</option>
          <option value="Brown" <?php if($ColorCode=='Supplier'){ print "Selected"; } ?>
            style="color:Brown; font-weight:bold;">Brown</option>
          <option value="Gold" <?php if($ColorCode=='Gold'){ print "Selected"; } ?>
            style="color:Gold; font-weight:bold;">Gold</option>
          <option value="Olive" <?php if($ColorCode=='Olive'){ print "Selected"; } ?>
            style="color:Olive; font-weight:bold;">Olive</option>
          <option value="DarkCyan" <?php if($ColorCode=='DarkCyan'){ print "Selected"; } ?>
            style="color:DarkCyan; font-weight:bold;">DarkCyan</option>
          <option value="Aqua" <?php if($ColorCode=='Aqua'){ print "Selected"; } ?>
            style="color:Aqua; font-weight:bold;">Aqua</option>
          <option value="Aquamarine" <?php if($ColorCode=='Aquamarine'){ print "Selected"; } ?>
            style="color:Aquamarine; font-weight:bold;">Aquamarine</option>
          <option value="Maroon" <?php if($ColorCode=='Maroon'){ print "Selected"; } ?>
            style="color:Maroon; font-weight:bold;">Maroon</option>
          <option value="Indigo" <?php if($ColorCode=='Indigo'){ print "Selected"; } ?>
            style="color:Indigo; font-weight:bold;">Indigo</option>
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
                    <option  <?php if($SupplierCategoryID==$Fetch['SupplierCategoryID']){ print "Selected"; } ?> value="<?php print $Fetch['SupplierCategoryID']; ?>"><?php print sprintf("%03d", $Fetch['SupplierCategoryID']); ?> |
                        <?php print $Fetch['Name']; ?> </option>
                    <?php } ?>
                </select>
            </div>

        </div>
    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Mobile No</label>
        <input type="text" class="form-control" OnKeyUp="check_input();" id="MobileNo" <?php print $NumberValidity; ?>
          value="<?php print $MobileNo; ?>">
      </div>

    </div>

  </div>



  <div class="row">

  <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Address</label>
        <textarea id="Address" class="form-control"><?php print $Address; ?></textarea>
      </div>

    </div>

    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Contact Person Details</label>
        <textarea id="ContactPersonInfo" class="form-control"><?php print $ContactPersonInfo; ?></textarea>


      </div>

    </div>


  </div>


  <div class="row">
  <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Opening Balance</label>
        <input type="text" class="form-control" OnKeyUp="check_input();" id="OpeningBalance"
          value="<?php print $OpeningBalance; ?>" <?php print $QtyCheck; ?>>
      </div>

    </div>
    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Supplier Id</label>
        <input type="text" readonly class="form-control" id="UpdateId"
          value="<?php print $UpdateId; ?>">
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

    <input type="button" id="UpdateSupplier" onclick="UpdateSupplier();" value="Update Data" class="btn btn-success">
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