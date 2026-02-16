<?php
require_once '../includes/Auth.php'; // Session Starting file
include '../config/Database.php'; // Database connection file


if(!empty($_GET['id'])){

$UpdateId = $_GET['id'];
$sql =$conn->prepare("SELECT 
A.`Id`,
A.`UserName`,
A.`Phone`,
B.`PackageId`,
B.`ShopName`,
B.`ShopAddress`,
CONCAT(C.`PackageName`, '/' ,C.`PacakageDuration`, '/' ,C.`PacakageAmount` , 'Tk/' ,C.`NumberOfUser`,' Users') AS PackageInfo,
B.`SubscriptionStartDate`,
B.`SubscriptionEndDate`,
B.`Status`,
A.`CreateDate`

FROM `user_information` A 
LEFT JOIN `Shop` B ON A.`ShopId`=B.`Id`
LEFT JOIN `package` C ON B.`PackageId`=C.`Id`
WHERE A.`Id`='$UpdateId'");
$sql->execute();
$fetch = $sql->fetch(PDO::FETCH_ASSOC);

$OwnerName = $fetch['UserName']; 
$Phone = $fetch['Phone'];
$ShopName = $fetch['ShopName'];
$ShopAddress = $fetch['ShopAddress'];
$PackageId = $fetch['PackageId'];
$PackageInfo = $fetch['PackageInfo'];
$SubscriptionStartDate = $fetch['SubscriptionStartDate'];
$SubscriptionEndDate = $fetch['SubscriptionEndDate'];
$Status = $fetch['Status'];
$CreateDate = $fetch['CreateDate'];

?>


<!-- /.card-header -->
<div class="card-body">
  <div class="row">
  <input type="hidden" id="UpdateId" value="<?php print $UpdateId; ?>">
    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Owner Name</label>
        <input type="text" class="form-control" onkeyup="check_input();" id="OwnerName" value="<?php print $OwnerName; ?>"
          placeholder="Enter Owner Name">
      </div>

    </div>


    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Owner Moblie No.</label>
        <input type="text" class="form-control" onkeyup="check_input();" id="Phone" value="<?php print $Phone; ?>" <?php print $NumberValidity; ?>
          placeholder="Enter Owner Mobile No.">
      </div>

    </div>


  </div>

  <div class="row">

  <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Shop Name</label>
        <input type="text" class="form-control" onkeyup="check_input();" id="ShopName" value="<?php print $ShopName; ?>"
          placeholder="Enter Shop Name">
      </div>

    </div>

    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Shop Address</label>
        <textarea class="form-control" onkeyup="check_input();" id="ShopAddress"  placeholder="Enter Shop Address"><?php print $ShopAddress; ?></textarea>
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
              <option value="<?php print $fetch['Id']; ?>" <?php if(!empty($PackageId) && $PackageId == $fetch['Id']){ print "Selected"; } ?>><?php print $fetch['PackageName']; ?> / <?php print $fetch['PacakageDuration']; ?>  / <?php print $fetch['PacakageAmount']; ?> Tk / <?php print $fetch['NumberOfUser']; ?> Users</option>
              <?php } ?>
            </select>
      </div>

    </div>

    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Subscription Start Date</label>
        <input type="date" class="form-control" onkeyup="check_input();" id="SubscriptionStartDate" value="<?php print $SubscriptionStartDate; ?>"
          placeholder="Enter Subscription Start Date">
      </div>

    </div>

  </div>

  <div class="row">
  <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Subscription End Date</label>
        <input type="date" class="form-control" onkeyup="check_input();" id="SubscriptionEndDate" value="<?php print $SubscriptionEndDate; ?>"
          placeholder="Enter Subscription End Date">
      </div>

    </div>
    
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
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

    <input type="button" id="UpdateOwner" onclick="UpdateOwner();" value="Update Data" class="btn btn-warning">
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