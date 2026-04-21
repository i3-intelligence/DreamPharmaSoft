<?php
require_once('auth.php');
include("db.php");
?>
<table id="example2" class="table table-bordered table-striped">
 <thead>
<tr>
    <th colspan="9" style="text-align: center;"> <font color="#2A0000"> <b> Cash Memo Return Cart List </b> </font> </th>
</tr>
<tr>
    <th align="center"> SL </th>
    <th align="center"> Date </th>
	<th align="center"> Product Details & Cash Memo.</th>
	<th align="center"> Qty </th>
	<th align="center"> Rate </th>
	<th align="center"> Total Kg </th>
	<th align="center"> Total Value </th>
    <th align="center"> Remove </th>
</tr>
</thead>	
<tbody>
<?php
$sl=1;
$TotalQuantity = 0;
$TotalAmount = 0;
$QueryChart = $conn->prepare("SELECT 
        A.*,
        B.`Name` AS `ItemCategory`,
        C.`Thickness`,
        C.`Size`

FROM `CashMemoReturn` A 
LEFT JOIN `ItemCategory` B ON (A.`ItemCategoryID` = B.`ItemCategoryID`)
LEFT JOIN `PackageSize` C ON (A.`PackageSizeID` = C.`PackageSizeID`)
WHERE A.`EntryID`='$SessionID' AND `Cart` = ''  ORDER BY `CashMemoReturnID` DESC ");
$QueryChart->execute();
$FetchChart = $QueryChart->FetchAll(PDO::FETCH_ASSOC);
foreach($FetchChart AS $Fetch) {
?>
<tr>
			<td align="center"><?php print $sl++; ?></td>
            <td align="center"><?php print date("d-M-Y", strtotime($Fetch['CreateDate'])); ?></td>
			<td align="center"><?php print $Fetch['ItemCategory']; ?> &times; <?php print $Fetch['Thickness']; ?><?php print $Fetch['Size']; ?> </td>
			
			<td align="right"> <?php print number_format($Fetch['ReturnQuantity'],2,'.',''); ?> </td>

			<td align="right"> <?php print number_format($Fetch['ReturnRate'],2,'.',''); ?> </td>
			<td align="right"> <?php print number_format($Fetch['Thickness'] * $Fetch['ReturnQuantity'],2,'.',''); ?> </td>

			<td align="right"> <?php print number_format($Fetch['ReturnAmount'],2,'.',''); ?> </td>

			<td><a href='CashMemoReturnAction.php?delete=yes&DeleteID=<?php print $Fetch['CashMemoReturnID']; ?>&CashMemoInvoice=<?php print $Fetch['CashMemoInvoice']; ?>'>Remove</a></td>

			
		
</tr>
<?php
    $TotalQuantity +=$Fetch['ReturnQuantity'];
    $TotalAmount +=$Fetch['ReturnAmount'];
	} //close while brace
?>
</tbody>
<tfoot>
<tr>
    <th colspan="3" style="text-align: right;">Total </th>
    <th style="text-align: right;"><?php print number_format($TotalQuantity,2,'.',''); ?> </th>
    <th colspan="2"> &nbsp; </th>
    <th style="text-align: right;"><?php print number_format($TotalAmount,2,'.',''); ?></th>
    <th colspan="2"> &nbsp; </th>
</tr>	 
</tfoot>
</table>