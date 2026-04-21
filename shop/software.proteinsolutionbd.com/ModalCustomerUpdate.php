<?php
require_once("auth.php");
include("db.php");
if(!empty($_GET['id'])){
    $UpdateId = $_GET['id'];
    $sql =$conn->prepare("SELECT 
                                A.`Name`,
                                A.`CustomerSubCategoryID`,
                                A.`CustomerCategoryID`,
                                A.`MobileNo`,
                                A.`Address`,
                                A.`CreditLimit`,
                                A.`OpeningBalance`,
                                A.`Status`,
                                A.`CreateDate`,
                                A.`LastModifiedDate`,
                                CONCAT(B.`UserName`,' - ', B.`Designation`,' - ', B.`Phone`) AS `EntryInfo`,
                                CONCAT(C.`UserName`,' - ', C.`Designation`,' - ', C.`Phone`) AS `UpdateInfo`
                          FROM `Customer` A 
                          LEFT JOIN `UserInformation` B ON (A.`EntryID` = B.`Id`)
                          LEFT JOIN `UserInformation` C ON (A.`UpdateId` = C.`Id`)
                          WHERE A.`CustomerID`='$UpdateId'");
    $sql->execute();
    $fetch = $sql->fetch(PDO::FETCH_ASSOC);
    $Name = $fetch['Name'];
    $CustomerSubCategoryID = $fetch['CustomerSubCategoryID'];
    $CustomerCategoryID = $fetch['CustomerCategoryID'];
    $MobileNo = $fetch['MobileNo'];
    $Address = $fetch['Address'];
    $CreditLimit = $fetch['CreditLimit'];
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
        <label class="col-form-label" for="inputSuccess">Customer Name</label>
        <input type="text" class="form-control" id="Name" value="<?php print $Name; ?>">
      </div>

    </div>


    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Mobile No</label>
        <input type="text" class="form-control" OnKeyUp="check_input();" id="MobileNo"
          value="<?php print $MobileNo; ?>"<?php print $NumberValidity; ?>>
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
                    <option  <?php if($CustomerCategoryID==$Fetch['CustomerCategoryID']){ print "Selected"; } ?> value="<?php print $Fetch['CustomerCategoryID']; ?>"><?php print sprintf("%03d", $Fetch['CustomerCategoryID']); ?> |
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
                              <option value="">Select Sub Customer Category</option>
          
                              <?php
          $query = $conn->prepare("SELECT * FROM `CustomerSubCategory` WHERE `Status` = 'Active' ORDER BY `Name` ASC");
          $query->execute();
          $FetchCustomerData = $query->fetchAll(PDO::FETCH_ASSOC);
          foreach($FetchCustomerData AS $Fetch) {
          ?>
                              <option  <?php if($CustomerSubCategoryID==$Fetch['CustomerSubCategoryID']){ print "Selected"; } ?> value="<?php print $Fetch['CustomerSubCategoryID']; ?>"><?php print sprintf("%03d", $Fetch['CustomerSubCategoryID']); ?> |
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
        <input type="text" class="form-control" id="Address" value="<?php print $Address; ?>" <?php print $AutoComplete; ?> list="CustomerAddressList" OnKeyUp="CustomerAddressList();">
        <datalist id="CustomerAddressList"></datalist>
      </div>

    </div>

    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Credit Limit</label>
        <input type="text" class="form-control" OnKeyUp="check_input();" id="CreditLimit"
          value="<?php print $CreditLimit; ?>" <?php print $QtyCheck; ?>>
      </div>

    </div>


  </div>


  <div class="row">
  <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Opening Balance</label>
        <input type="Text" readonly class="form-control" OnKeyUp="check_input();" id="OpeningBalance"
          value="<?php print $OpeningBalance; ?>" <?php print $QtyCheck; ?>>
      </div>

    </div>
    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Customer Id</label>
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

    <input type="button" id="UpdateCustomer" onclick="UpdateCustomer();" value="Update Data" class="btn btn-success">
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