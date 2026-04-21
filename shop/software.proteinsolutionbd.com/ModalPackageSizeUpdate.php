<?php
require_once("auth.php");
include("db.php");
if(!empty($_GET['id'])){
    $UpdateId = $_GET['id'];
    $sql =$conn->prepare("SELECT 
                                A.`Thickness`,
                                A.`Size`,
                                A.`SupplierID`,
                                A.`LowStock`,
                                A.`ItemCategoryID`,
                                A.`Status`,
                                A.`CreateDate`,
                                A.`LastModifiedDate`,
                                CONCAT(B.`UserName`,' - ', B.`Designation`,' - ', B.`Phone`) AS `EntryInfo`,
                                CONCAT(C.`UserName`,' - ', C.`Designation`,' - ', C.`Phone`) AS `UpdateInfo`
                          FROM `PackageSize` A 
                          LEFT JOIN `UserInformation` B ON (A.`EntryID` = B.`Id`)
                          LEFT JOIN `UserInformation` C ON (A.`UpdateId` = C.`Id`)
                          WHERE A.`PackageSizeID`='$UpdateId'");
    $sql->execute();
    $fetch = $sql->fetch(PDO::FETCH_ASSOC);
    
    $Thickness = $fetch['Thickness'];
    $Size = $fetch['Size'];
    $SupplierID = $fetch['SupplierID'];
    $LowStock = $fetch['LowStock'];
    $ItemCategoryID = $fetch['ItemCategoryID'];
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
                <label class="col-form-label" for="inputSuccess">Package Size</label>
                <input type="text" class="form-control" id="Thickness" value="<?php print $Thickness; ?>">
            </div>

        </div>

        <div class="col-md-6">
            <!-- input states -->
            <div class="form-group">
                <label class="col-form-label" for="inputSuccess">MOP</label>
                <Select class="form-control select2" id="Size" >
                    <option value="">Select Mode Of Packet</option>
                    <option value="DOSE" <?php if($Size=='DOSE'){ print "Selected"; } ?>>DOSE</option>
                    <option value="GM" <?php if($Size=='GM'){ print "Selected"; } ?>>GM</option>
                    <option value="KG" <?php if($Size=='KG'){ print "Selected"; } ?>>KG</option>
                    <option value="ML" <?php if($Size=='ML'){ print "Selected"; } ?>>ML</option>
                    <option value="LITER" <?php if($Size=='LITER'){ print "Selected"; } ?>>LITER</option>
                    <option value="PCS" <?php if($Size=='PCS'){ print "Selected"; } ?>>PCS</option>
                    <option value="BAG" <?php if($Size=='BAG'){ print "Selected"; } ?>>BAG</option>
                    <option value="Month" <?php if($Size=='Month'){ print "Selected"; } ?>>Month</option>
                </Select>
            </div>

        </div>
    </div>
    <div class="row">

        <div class="col-md-6">
            <!-- input states -->
            <div class="form-group">
                <label class="col-form-label" for="inputSuccess">Supplier Info</label>
                <select class="form-control select2" id="SupplierID" style="width: 100%;" onchange="SupItemCategory();">
                    <option value="">Select Supplier</option>

                    <?php
$query = $conn->prepare("SELECT * FROM `Supplier` WHERE `Status` = 'Active' ORDER BY `Name` ASC");
$query->execute();
$FetchSupplierData = $query->fetchAll(PDO::FETCH_ASSOC);
foreach($FetchSupplierData AS $Fetch) {
?>
                    <option value="<?php print $Fetch['SupplierID']; ?>" <?php if($SupplierID==$Fetch['SupplierID']){ print "Selected"; } ?>><?php print sprintf("%03d", $Fetch['SupplierID']); ?> |
                        <?php print $Fetch['Name']; ?> | <?php print $Fetch['MobileNo']; ?> |
                        <?php print $Fetch['Address']; ?></option>
                    <?php } ?>
                </select>
            </div>

        </div>


        <div class="col-md-6">
            <!-- input states -->
            <div class="form-group" id="loadItemCategory">
            <label class="col-form-label" for="inputSuccess">Item Category</label>
                <select class="form-control select2" id="ItemCategoryID" style="width: 100%;" >
                    <option value="">Select Item Category</option>

                    <?php
$query = $conn->prepare("SELECT * FROM `ItemCategory` WHERE `Status` = 'Active' AND  `SupplierID` = '$SupplierID' ORDER BY `Name` ASC");
$query->execute();
$FetchSupplierData = $query->fetchAll(PDO::FETCH_ASSOC);
foreach($FetchSupplierData AS $Fetch) {
?>
                    <option value="<?php print $Fetch['ItemCategoryID']; ?>" <?php if($ItemCategoryID==$Fetch['ItemCategoryID']){ print "Selected"; } ?>>
                        <?php print $Fetch['Name']; ?></option>
                    <?php } ?>
                </select>
            </div>

        </div>

    </div>


    <div class="row">
    
        <div class="col-md-6">
            <!-- input states -->
            <div class="form-group">
                <label class="col-form-label" for="inputSuccess">Low Stock</label>
                <input type="text" class="form-control" id="LowStock" value="<?php print $LowStock; ?>">
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

<div class="row">
<div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Package Size Id</label>
        <input type="text" readonly class="form-control" OnKeyUp="check_input();" id="UpdateId"
          value="<?php print $UpdateId; ?>">
      </div>

    </div>
</div>


    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

        <input type="button" id="UpdatePackageSize" onclick="UpdatePackageSize();" value="Update Data"
            class="btn btn-success">
    </div>

</div>
<script>
    //select2 
    $('.select2').select2({
        theme: 'bootstrap4'
    });

// LOAD Sub Item Category
function SupItemCategory() {
      //get the VALUE
      var SupplierID = $('#SupplierID').val();
        // alert(SupplierID);
     
      document.getElementById('loadItemCategory').innerHTML = 'Loading...';
      //use ajax to run the check
      $.post("JsonValue.php", {
        SupplierID: SupplierID
        },
        function (result) {
          document.getElementById('loadItemCategory').innerHTML = result['loadItemCategory'];
          $("#ItemCategoryID").select2();
        });
    }
</script>
<?php
}
?>