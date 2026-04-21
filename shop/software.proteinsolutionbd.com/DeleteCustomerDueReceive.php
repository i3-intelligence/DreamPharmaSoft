<?php
include("auth.php");
include("db.php");
include_once("clean.php");

if(!empty($_GET['id'])){
$id = clean($_GET['id']);
$query = $conn->prepare("SELECT A.*,CONCAT(B.`CustomerID`,'-',B.`Name`,'-',B.`MobileNo`) AS `CustomerInfo`
FROM `Receive` A  
LEFT JOIN `Customer` B ON (A.`CustomerID` = B.`CustomerID`) 
WHERE A.`ReceiveID` = '".$id."' AND B.`status` = 'Active'  ORDER BY A.`CustomerDueReceiveInvoice` DESC");
$query->execute();
$FetchDeleteData = $query->fetch(PDO::FETCH_ASSOC);
?>
<input type="hidden" id="PrimaryID" value="<?php Print $id; ?>">
<!-- /.card-header -->
<div class="card-body">

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Customer Info.</label>
                    <p><?php Print $FetchDeleteData['CustomerInfo']; ?></p>
                  </div>

                 </div>
                 <div class="col-md-6">
                  <div class="form-group">
                    <label>Payment Type</label>
                    <p><?php Print $FetchDeleteData['TransactionType']; ?> : <?php Print $FetchDeleteData['PaymentName']; ?></p>
                  </div>

                 </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Receive Amount</label>
                    <p><?php Print number_format($FetchDeleteData['ReceiveAmount'],2,'.',''); ?></p>
                  </div>

                 </div>
                 
              <div class="col-md-6">
                  <div class="form-group">
                    <label>Discount Amount</label>
                    <p><?php Print number_format($FetchDeleteData['ReceiveDiscount'],2,'.',''); ?></p>
                  </div>

                 </div>
                 
              </div>
              <div class="row">

              <div class="col-md-6">
                  <div class="form-group">
                    <label>Receive Note</label>
                    <p><?php Print $FetchDeleteData['ReceiveNote']; ?></p>
                  </div>

                 </div>
              </div>   
<?php
}
?>
