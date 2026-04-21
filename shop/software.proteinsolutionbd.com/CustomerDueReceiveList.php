<?php
include("auth.php");
include("db.php");
include_once("clean.php");
?>

<table id="example2" class="table table-bordered table-striped">
  <thead>
      <tr>
            <th colspan="10" style="text-align: center; color:blue;">Last 100 Customer Due Receive Entry</th>
      </tr>
    <tr>
      <th>SL</th>
      <th>Customer Info.</th>
      <th>Date</th>
      <th>Invoice</th>
      <th>Transaction Type</th>
      <th>Discount Amount</th>
      <th>Receive Amount</th>
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
$query = $conn->prepare("SELECT A.*,CONCAT(LPAD(B.`CustomerID`, 3, '0'),'-',B.`Name`,'-',B.`MobileNo`,'-',B.`Address`) AS `CustomerInfo` FROM `Receive` A  
LEFT JOIN `Customer` B ON (A.`CustomerID` = B.`CustomerID`) 
WHERE A.`ReceiveType` = 'Customer Due Receive' AND A.`EntryID` ='$SessionID'  ORDER BY A.`ReceiveID` DESC  LIMIT 100"); 
$query->execute();
$fetch_due_entry = $query->fetchAll(PDO::FETCH_ASSOC);
foreach($fetch_due_entry AS $fetch) {
// output data of each row

?>
    <tr>
      <td><?php Print $i++; ?></td>
      <td style="text-align: left;"><?php Print $fetch['CustomerInfo']; ?></td>
      <td><?php Print date("d-m-Y",strtotime($fetch['ReceiveDate'])); ?></td>
      <th style="text-align: center;"><a title="Click here To Open Invoice" data-toggle="tooltip" onclick="window.open('sales_invoice.php?invoice=<?php echo $fetch['CustomerDueReceiveInvoice']; ?>', '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');"
          style="cursor: pointer;"><?php Print $fetch['CustomerDueReceiveInvoice']; ?></a></th>
      <td style="text-align: left;"><?php Print $fetch['TransactionType']; ?> : <?php Print $fetch['PaymentName']; ?></td>

      <td style="text-align: right;"><?php Print number_format($fetch['ReceiveDiscount'],2,'.',''); ?></td>
      <td style="text-align: right;"><?php Print number_format($fetch['ReceiveAmount'],2,'.',''); ?></td>
      
      <td><?php Print $fetch['ReceiveNote']; ?></td>
      <td>
            <?php Print date("d/m/Y - h:i:s a",strtotime($fetch['CreateDate'])); ?>
       </td>

       <?php if($fetch['ReceiveDate']==$CurrentDate){ ?>
      <td>
        <a title="View To More Details" class="btn btn-danger" data-toggle="modal" data-target="#modal-default1"
          data-whatever="<?php print $fetch['ReceiveID']; ?>">
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
    $total_discount += $fetch['ReceiveDiscount']; 
    $total_received += $fetch['ReceiveAmount']; 
}
?>

  </tbody>
  <tfoot>
  <tr>
    <th colspan="5" style="text-align: right;">Total Received</th>
    <th style="text-align: right;"><?php Print number_format($total_discount,2,'.',''); ?></th>
    <th style="text-align: right;"><?php Print number_format($total_received,2,'.',''); ?></th>
    <th colspan="3"></th>
</tr>
    </tr>
  </tfoot>
</table>
