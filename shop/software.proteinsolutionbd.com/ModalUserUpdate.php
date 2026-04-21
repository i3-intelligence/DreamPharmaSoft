<?php
require_once("auth.php");
include("db.php");
if(!empty($_GET['id'])){
    $UpdateId = $_GET['id'];
    $sql =$conn->prepare("SELECT 
                            *
                          FROM `UserInformation` 
                          WHERE `id`='$UpdateId'");
    $sql->execute();
    $fetch = $sql->fetch(PDO::FETCH_ASSOC);
    $UserName = $fetch['UserName'];
    $User = $fetch['User'];
    $DecryptPassword = $fetch['DecryptPassword'];
    $Admin = $fetch['Admin'];
    $EditAccess = $fetch['EditAccess'];
    $DeleteAccess = $fetch['DeleteAccess'];
    $Block = $fetch['Block'];
    $EntryDateTime =  date("d-m-y | h:i:s a",strtotime($fetch['CreateDate']));
    $UpdateDateTime =  date("d-m-y | h:i:s a",strtotime($fetch['LastLogin']));


?>

<!-- /.card-header -->
<div class="card-body">
  <div class="row">
  <div class="col-md-6">
      <div class="alert alert-success alert-dismissible">
        <h5><i class="icon fas fa-exclamation-triangle"></i> Entry Date!</h5>
       <?php print $EntryDateTime; ?>
      </div>

    </div>

    <div class="col-md-6">
      <div class="alert alert-warning alert-dismissible">
        <h5><i class="icon fas fa-exclamation-triangle"></i> Last Login!</h5>
       <?php print $UpdateDateTime; ?>
      </div>

    </div>
  </div>
  <div class="row">
  <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess"> Id</label>
        <input type="text" readonly class="form-control" OnKeyUp="check_input();" id="UpdateId"
          value="<?php print $UpdateId; ?>">
      </div>
    </div>

      <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">User Name</label>
        <input type="text" class="form-control" id="UserName" value="<?php print $UserName; ?>">
      </div>

    </div>
    </div>



    <div class="row">
  
    
    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">User ID</label>
        <input type="text" class="form-control" id="User" value="<?php print $User; ?>">
      </div>

    </div>

    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess"> Password</label>
        <input type="text" class="form-control" OnKeyUp="check_input();" id="DecryptPassword"
          value="<?php print $DecryptPassword; ?>">
      </div>

    </div>


    </div>

<div class="row">


<div class="col-md-6">
        <!-- input states -->
        <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Admin</label>
        <select id="Admin" class="form-control select2">
            <option value="Yes" <?php if($Admin == "Yes"){ print "Selected";} ?>>Yes</option>
            <option value="No" <?php if($Admin == "No"){ print "Selected";} ?>>No</option>
        </select>
        </div>
    </div>

    <div class="col-md-6">
        <!-- input states -->
        <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Edit Access</label>
        <select id="EditAccess" class="form-control select2">
            <option value="Yes" <?php if($EditAccess == "Yes"){ print "Selected";} ?>>Yes</option>
            <option value="No" <?php if($EditAccess == "No"){ print "Selected";} ?>>No</option>
        </select>
        </div>
    </div>


</div>
  <div class="row">

  
<div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Delete Access</label>
        <select id="DeleteAccess" class="form-control select2">
          <option value="Yes" <?php if($DeleteAccess == "Yes"){ print "Selected";} ?>>Yes</option>
          <option value="No" <?php if($DeleteAccess == "No"){ print "Selected";} ?>>No</option>
        </select>
      </div>
    </div>

    <div class="col-md-6">
      <!-- input states -->
      <div class="form-group">
        <label class="col-form-label" for="inputSuccess">Block</label>
        <select id="Block" class="form-control select2">
          <option value="Yes" <?php if($Block == "Yes"){ print "Selected";} ?>>Yes</option>
          <option value="No" <?php if($Block == "No"){ print "Selected";} ?>>No</option>
        </select>
      </div>
    </div>

  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

    <input type="button" id="UpdateUser" onclick="UpdateUser();" value="Update Data" class="btn btn-success">
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