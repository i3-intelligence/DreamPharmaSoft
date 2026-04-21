<?php
include("auth.php");
include("db.php");
include_once("clean.php");
?>

<table id="example2" class="table table-bordered table-striped">
  <thead>
      <tr>
            <th colspan="10" style="text-align: center; color:blue;">Last 100 Supplier Payment Entry</th>
      </tr>
    <tr>
      <th>SL</th>
      <th>Supplier Info.</th>
      <th>Date</th>
      <th>Invoice</th>
      <th>Transaction Type</th>
      <th>Discount Amount</th>
      <th>Payment Amount</th>
      <th>Remarks</th>
      <th>Entry Info</th>
<?php if($fetch_operator['DeleteAccess']=='Yes'){ ?>
      <th>Delete</th>
<?php
}
?>
    </tr>
  </thead>
  <tbody>
    <?php
$i = 1;
$total_discount = 0;
$total_received = 0;
$query = $conn->prepare("SELECT A.*,CONCAT(LPAD(B.`SupplierID`, 3, '0'),'-',B.`Name`,'-',B.`MobileNo`,'-',B.`Address`) AS `SupplierInfo` FROM `Payment` A  
LEFT JOIN `Supplier` B ON (A.`SupplierID` = B.`SupplierID`) 
WHERE A.`PaymentType` = 'Supplier Payment' AND A.`EntryID` ='$SessionID'  ORDER BY A.`PaymentID` DESC  LIMIT 100"); 
$query->execute();
$fetch_due_entry = $query->fetchAll(PDO::FETCH_ASSOC);
foreach($fetch_due_entry AS $fetch) {
// output data of each row

?>
    <tr>
      <td><?php Print $i++; ?></td>
      <td style="text-align: left;"><?php Print $fetch['SupplierInfo']; ?></td>
      <td><?php Print date("d-m-Y",strtotime($fetch['PaymentDate'])); ?></td>
      <th style="text-align: center;"><a title="Click here To Open Invoice" data-toggle="tooltip" onclick="window.open('sales_invoice.php?invoice=<?php echo $fetch['SupplierPaymentInvoice']; ?>', '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');"
          style="cursor: pointer;"><?php Print $fetch['SupplierPaymentInvoice']; ?></a></th>
      <td style="text-align: left;"><?php Print $fetch['TransactionType']; ?> : <?php Print $fetch['PaymentName']; ?></td>

      <td style="text-align: right;"><?php Print number_format($fetch['PaymentDiscount'],2,'.',''); ?></td>
      <td style="text-align: right;"><?php Print number_format($fetch['PaymentAmount'],2,'.',''); ?></td>
      
      <td><?php Print $fetch['PaymentNote']; ?></td>
      <td>
            <?php Print date("d/m/Y - h:i:s a",strtotime($fetch['CreateDate'])); ?>
       </td>

      <?php if($fetch['PaymentDate']==$CurrentDate){ ?>

      <td>
        <a title="View To More Details" class="btn btn-danger" data-toggle="modal" data-target="#modal-default1"
          data-whatever="<?php print $fetch['PaymentID']; ?>">
          <i class="fas fa-trash"></i>
          Delete
        </a>
      </td>

<?php
  }else{
    echo "<td></td>";
}
?>

    </tr>
    <?php
    $total_discount += $fetch['PaymentDiscount']; 
    $total_received += $fetch['PaymentAmount']; 
}
?>

  </tbody>
  <tfoot>
  <tr>
    <th colspan="5" style="text-align: right;">Total Payment</th>
    <th style="text-align: right;"><?php Print number_format($total_discount,2,'.',''); ?></th>
    <th style="text-align: right;"><?php Print number_format($total_received,2,'.',''); ?></th>
    <th colspan="3"></th>
</tr>
    </tr>
  </tfoot>
</table>
