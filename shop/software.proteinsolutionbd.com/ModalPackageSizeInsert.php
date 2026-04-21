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
                <label class="col-form-label" for="inputSuccess">Package Size</label>
                <input type="text" class="form-control" id="Thickness" value="">
            </div>

        </div>

        <div class="col-md-6">
            <!-- input states -->
            <div class="form-group">
                <label class="col-form-label" for="inputSuccess">MOP</label>
                <Select class="form-control select2" id="Size" >
                    <option value="">Select Mode Of Packet</option>
                    <option value="DOSE">DOSE</option>
                    <option value="GM">GM</option>
                    <option value="KG">KG</option>
                    <option value="ML">ML</option>
                    <option value="LITER">LITER</option>
                    <option value="PCS">PCS</option>
                    <option value="BAG">BAG</option>
                    <option value="Month">Month</option>
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
                    <option value="<?php print $Fetch['SupplierID']; ?>"><?php print sprintf("%03d", $Fetch['SupplierID']); ?> |
                        <?php print $Fetch['Name']; ?> | <?php print $Fetch['MobileNo']; ?> |
                        <?php print $Fetch['Address']; ?></option>
                    <?php } ?>
                </select>
            </div>

        </div>


        <div class="col-md-6">
            <!-- input states -->
            <div class="form-group" id="loadItemCategory">
                
            </div>

        </div>

    </div>


    <div class="row">

        <div class="col-md-6">
            <!-- input states -->
            <div class="form-group">
                <label class="col-form-label" for="inputSuccess">Low Stock</label>
                <input type="text" class="form-control" id="LowStock" value="">
            </div>

        </div>
    </div>




    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

        <input type="button" id="AddPackageSize" onclick="AddPackageSize();" value="Save Data"
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