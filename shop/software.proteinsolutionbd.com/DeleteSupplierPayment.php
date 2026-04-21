<?php
include("auth.php");
include("db.php");
include_once("clean.php");

if(!empty($_GET['id'])){
$id = clean($_GET['id']);
$query = $conn->prepare("SELECT A.*,CONCAT(B.`SupplierID`,'-',B.`Name`,'-',B.`MobileNo`) AS `SupplierInfo`
FROM `Payment` A  
LEFT JOIN `Supplier` B ON (A.`SupplierID` = B.`SupplierID`) 
WHERE A.`PaymentID` = '".$id."' AND B.`Status` = 'Active'  ORDER BY A.`SupplierPaymentInvoice` DESC");
$query->execute();
$FetchDeleteData = $query->fetch(PDO::FETCH_ASSOC);
?>
<input type="hidden" id="PrimaryID" value="<?php Print $id; ?>">
<!-- /.card-header -->
<div class="card-body">

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Supplier Info.</label>
                    <p><?php Print $FetchDeleteData['SupplierInfo']; ?></p>
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
                    <label>Payment Amount</label>
                    <p><?php Print number_format($FetchDeleteData['PaymentAmount'],2,'.',''); ?></p>
                  </div>

                 </div>
                 
              <div class="col-md-6">
                  <div class="form-group">
                    <label>Discount Amount</label>
                    <p><?php Print number_format($FetchDeleteData['PaymentDiscount'],2,'.',''); ?></p>
                  </div>

                 </div>
                 
              </div>
              <div class="row">

              <div class="col-md-6">
                  <div class="form-group">
                    <label>Payment Note</label>
                    <p><?php Print $FetchDeleteData['PaymentNote']; ?></p>
                  </div>

                 </div>
              </div>   
<?php
}
?>
