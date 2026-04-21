
<!-- Delete Modals -->
<div class="modal fade" id="modal-default1" role="dialog">
<div class="modal-dialog modal-md">

    <div class="modal-content">
        <div class="modal-header">

            <h4 class="modal-title"> Are You Sure To Delete ?</h4>
        </div>
        <div class="modal-body">

            <div class="dash">
                <!-- Content goes in here -->
            </div>

        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>

            <input type="button" id="Delete" onclick="CustomerDueReceiveDelete();" value="Delete" class="btn btn-danger">
        </div>
    </div>
</div>
</div>


<!--Wallet Receive Modal -->
<div class="modal fade" id="modal-default3" role="dialog">
    <div class="modal-dialog modal-xl">

        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Wallet Receive </h4>
            </div>
            <div class="modal-body">

                <div class="dash">

                        <!-- input states -->
                        <div class="form-group">
                            <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><span class="material-icons"
                            title="Required Field">error</span>Wallet Info</span>
                            </div>

                            <select class="form-control select2" 
                            id="WalletID" onchange="WalletSelect();">
                            <option value="">Select One</option>
                            <?php
                            $query = $conn->prepare("SELECT `WalletID`,`Name` FROM `Wallet` WHERE `Status` = 'Active'   ORDER BY `Name` ASC "); 
                            $query->execute();
                            $fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);
                            foreach($fetch_list AS $fetch) { 
                            ?>
                            <option value="<?php print $fetch['WalletID']; ?>"> <?php print $fetch['Name']; ?></option>
                            <?php 
                            } 
                            ?>				
                            </select></div>

                        </div>

                        <input type="hidden" id="WalletInfo" value="">
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>

                <input type="button" id="WalletReceive" onclick="WalletReceive();" value="Wallet Receive" class="btn btn-info">
            </div>
        </div>
    </div>
</div>



<!-- Bank Receive Modal -->
<div class="modal fade" id="modal-default7" role="dialog">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Bank Receive </h4>
            </div>
            <div class="modal-body">

                <div class="dash">

              
                        <!-- input states -->
                        <div class="form-group">
                            <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><span class="material-icons"
                            title="Required Field">error</span>Bank Info</span>
                            </div>

                            <select class="form-control select2" 
                            id="BankID" onchange="BankSelect();">
                            <option value="">Select One</option>
                            <?php
                            $query = $conn->prepare("SELECT `BankID`,CONCAT(`AccountNumber`,' - ',`AccountName`,' - ',`BankName`,' - ',`BranchName`) AS `BankInfo` FROM `Bank` WHERE `Status` = 'Active'   ORDER BY `BankName` ASC "); 
                            $query->execute();
                            $fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);
                            foreach($fetch_list AS $fetch) { ?>
                            <option value="<?php print $fetch['BankID']; ?>"> <?php print $fetch['BankInfo']; ?></option>
                            <?php } ?>				
                            </select></div>

                            <input type="hidden" id="BankInfo" value="">
                        </div>


            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>

                <input type="button" id="reprint" onclick="BankPayment();" value="Payment" class="btn btn-info">
            </div>
        </div>
    </div>
</div>
</div>

<script>
 // LOAD Wallet  Info
  function WalletSelect() {
//get the VALUE
var WalletID = $('#WalletID').val();

  document.getElementById('WalletInfo').value = '';
  //use ajax to run the check
  $.post("LevelInfo.php", {
    WalletID: WalletID
      },
      function (result) {
          document.getElementById('WalletInfo').value = result;
      });
    
  }

  // LOAD Bank  Info
  function BankSelect() {
//get the VALUE
var BankID = $('#BankID').val();

  document.getElementById('BankInfo').value = '';
  //use ajax to run the check
  $.post("LevelInfo.php", {
    BankID: BankID
      },
      function (result) {
          document.getElementById('BankInfo').value = result;
      });
    
  }
  
  </script>