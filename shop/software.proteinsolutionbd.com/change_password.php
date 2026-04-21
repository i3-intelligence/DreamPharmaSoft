

<?php
include("auth.php");
include("db.php");

$query = $conn->prepare("SELECT * FROM `UserInformation` WHERE  `Id` = '".$SessionID."' ");
$query->execute();
$fetch_UserInformation = $query->fetch(PDO::FETCH_ASSOC);
?>
    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">User Information Update</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <div class="card-body">
<div class="row">

<div class="col-md-6">
  <!-- input states -->
  <div class="form-group">
    <label class="col-form-label" for="inputSuccess">User Name</label>
    <input type="text" class="form-control" OnKeyUp="check_input();" id="UserName" value="<?php Print $fetch_UserInformation['UserName']; ?>"
     placeholder="Enter User Name">
  </div>

</div>


<div class="col-md-6">
  <!-- input states -->
  <div class="form-group">
    <label class="col-form-label" for="inputSuccess">Designation</label>
    <input type="text" class="form-control" OnKeyUp="check_input();" id="Designation"  value="<?php Print $fetch_UserInformation['Designation']; ?>"
     placeholder="Enter Designation">
  </div>

</div>
</div>

<div class="row">

<div class="col-md-6">
  <!-- input states -->
  <div class="form-group">
    <label class="col-form-label" for="inputSuccess">User ID</label>
    <input type="text" class="form-control" OnKeyUp="check_input();" id="User" value="<?php Print $fetch_UserInformation['User']; ?>"
     placeholder="Enter User ID">
  </div>

</div>


<div class="col-md-6">
  <!-- input states -->
  <div class="form-group">
    <label class="col-form-label" for="inputSuccess">Password </label>
    <input type="Password" class="form-control" OnKeyUp="check_input();" id="Password"  value="<?php Print $fetch_UserInformation['DecryptPassword']; ?>"
     placeholder="Enter Password">
     <input type="checkbox" onclick="PasswordHideShow()">Show Password
  </div>

</div>
</div>

<div class="row">

<div class="col-md-6">
  <!-- input states -->
  <div class="form-group">
    <label class="col-form-label" for="inputSuccess">Mobile No</label>
    <input type="text" class="form-control" OnKeyUp="check_input();" id="Phone" value="<?php Print $fetch_UserInformation['Phone']; ?>"
     placeholder="Enter Mobile No">
  </div>

</div>


<div class="col-md-6">
  <!-- input states -->
  <div class="form-group">
    <label class="col-form-label" for="inputSuccess">Address</label>
    <textarea id="Address" class="form-control"   placeholder="Enter Address" ><?php Print nl2br($fetch_UserInformation['Address']); ?></textarea>

  </div>

</div>
</div>

              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="UserUpdate();">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <script>
function PasswordHideShow() {
  var x = document.getElementById("Password");
  if (x.type === "Password") {
    x.type = "text";
  } else {
    x.type = "Password";
  }
}

function check_input() {
  var UserName = $('#UserName').val();
  var Designation = $('#Designation').val();
  var User = $('#User').val();
  var Password = $('#Password').val();
  var Phone = $('#Phone').val();



  if (/^[a-zA-Z0-9-  ]*$/.test(UserName) == false) {
          toastr.error('Your Text contains illegal characters.');
          playclip_warning();
          $('#UserName').val('<?php Print $fetch_UserInformation['UserName']; ?>');
        }

        if (/^[a-zA-Z0-9-  ]*$/.test(Designation) == false) {
          toastr.error('Your Text contains illegal characters.');
          playclip_warning();
          $('#Designation').val('<?php Print $fetch_UserInformation['Designation']; ?>');
        }

        
        if (/^[a-zA-Z0-9-  ]*$/.test(Phone) == false) {
          toastr.error('Your Text contains illegal characters.');
          playclip_warning();
          $('#Phone').val('<?php Print $fetch_UserInformation['Phone']; ?>');
        }

        


}
function UserUpdate(){

//get the VALUE
var UserName = $('#UserName').val();
var Designation = $('#Designation').val();
var User = $('#User').val();
var Password = $('#Password').val();
var Phone = $('#Phone').val();
var Address = $('#Address').val();
var length = Password.length;

if (UserName == '') {
toastr.error('Please Enter User Name !!!');
playclip_warning();
$('#UserName').focus();
return false;
}


if (Designation == '') {
toastr.error('Please Enter Designation !!!');
playclip_warning();
$('#Designation').focus();
return false;
}

if (User == '') {
toastr.error('Please Enter User ID !!!');
playclip_warning();
$('#User').focus();
return false;
}


if (Password == '') {
toastr.error('Please Enter Password!!!');
playclip_warning();
$('#Password').focus();
return false;
}


if (Phone == '') {
toastr.error('Please Enter Mobile No !!!');
playclip_warning();
$('#Phone').focus();
return false;
}


if (Address == '') {
toastr.error('Please Enter Address !!!');
playclip_warning();
$('#Address').focus();
return false;
}

if (length <= '5' || length >= '25') {
toastr.error('Please Enter Password Minimum 6 Characters AND Maximum 25!!!');
playclip_warning();
$('#Password').focus();
return false;
}

  //use ajax to run the check
  $.post("user_update.php", {
        action: 'Session_Id_update',
        UserName: UserName,
        Designation: Designation,
        User: User,
        Password: Password,
        Phone: Phone,
        Address: Address
      },
      function (result) {
        //if the result is 200
        if (result == 1) {
          //alert(result);
          toastr.success(UserName + "  Information Updated !!!");
          //Form Value Clear

        } else {
          alert(result);
        }
      });

}
</script>