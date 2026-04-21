<?php
require_once("auth.php");
include("db.php");
if(!empty($_GET['id'])){
    $UpdateId = $_GET['id'];
    $sql =$conn->prepare("SELECT 
                                A.`Name`,
                                A.`Status`,
                                A.`CreateDate`,
                                A.`LastModifiedDate`,
                                CONCAT(B.`UserName`,' - ', B.`Designation`,' - ', B.`Phone`) AS `EntryInfo`,
                                CONCAT(C.`UserName`,' - ', C.`Designation`,' - ', C.`Phone`) AS `UpdateInfo`
                          FROM `CustomerSubCategory` A 
                          LEFT JOIN `UserInformation` B ON (A.`EntryID` = B.`Id`)
                          LEFT JOIN `UserInformation` C ON (A.`UpdateId` = C.`Id`)
                          WHERE A.`CustomerSubCategoryID`='$UpdateId'");
    $sql->execute();
    $fetch = $sql->fetch(PDO::FETCH_ASSOC);
    $Name = $fetch['Name'];
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
        <label class="col-form-label" for="inputSuccess">Customer Sub Category Name</label>
        <input type="text" class="form-control" id="Name" value="<?php print $Name; ?>">
      </div>

    </div>

    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Customer Sub Category Id</label>
        <input type="text" readonly class="form-control" OnKeyUp="check_input();" id="UpdateId"
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

    <input type="button" id="UpdateCustomerSubCategory" onclick="UpdateCustomerSubCategory();" value="Update Data" class="btn btn-success">
  </div>

</div>
<script>
  //select2 
  $('.select2').select2({
    theme: 'bootstrap4'
  });
</script>

<?php
}
?>