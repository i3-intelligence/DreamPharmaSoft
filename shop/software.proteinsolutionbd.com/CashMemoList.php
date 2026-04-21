<?php
require_once('auth.php');
include("db.php");
?>
<table class="table table-bordered table-striped">
 <thead>
<tr>
    <th colspan="9" style="text-align: center;"> <font color="#2A0000"> <b> Cash Memo Cart List </b> </font> </th>
</tr>
<tr>
    <th align="center"> SL </th>
    <th align="center"> Date </th>
	<th align="center"> Product Details & D.O No.</th>
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
$TotalKg = 0;
$QueryChart = $conn->prepare("SELECT 
        A.*,
        B.`Name` AS `ItemCategory`,
        C.`Thickness`,
        C.`Size`

FROM `CashMemo` A 
LEFT JOIN `ItemCategory` B ON (A.`ItemCategoryID` = B.`ItemCategoryID`)
LEFT JOIN `PackageSize` C ON (A.`PackageSizeID` = C.`PackageSizeID`)
WHERE A.`EntryID`='$SessionID' AND Cart = '' ORDER BY `CashMemoID` DESC ");
$QueryChart->execute();
$FetchChart = $QueryChart->FetchAll(PDO::FETCH_ASSOC);
foreach($FetchChart AS $Fetch) {
?>
<tr>
			<td align="center"><?php print $sl++; ?></td>
            <td align="center"><?php print date("d-M-Y", strtotime($Fetch['CreateDate'])); ?></td>
			<td align="center"><?php print $Fetch['ItemCategory']; ?> &times; <?php print $Fetch['Thickness']; ?><?php print $Fetch['Size']; ?> </td>
			
			<td align="right"> <?php print number_format($Fetch['SalesQuantity'],2,'.',''); ?> </td>

			<td align="right"> <?php print number_format($Fetch['SalesRate'],2,'.',''); ?> </td>
			<td align="right"> <?php print $Kg = number_format($Fetch['Thickness'] * $Fetch['SalesQuantity'],2,'.',''); ?> </td>

			<td align="right"> <?php print number_format($Fetch['SalesAmount'],2,'.',''); ?> </td>

			<td><a href='CashMemoAction.php?delete=yes&DeleteID=<?php print $Fetch['CashMemoID']; ?>&ChallanID=<?php print $Fetch['ChallanID']; ?>&SalesType=<?php print $SalesType; ?>&CustomerName=<?php print $CustomerName; ?>&CustomerAddress=<?php print $CustomerAddress; ?>&CustomerID=<?php print $CustomerID; ?>&SupplierID=<?php print $SupplierID; ?>&ItemCategoryID=<?php print $ItemCategoryID; ?>'>Remove</a></td>

			
</tr>
<?php
    $TotalQuantity +=$Fetch['SalesQuantity'];
    $TotalAmount += $Fetch['SalesAmount'];
    $TotalKg += $Kg;
	} //close while brace
?>
</tbody>
<tfoot>
<tr>
    <th colspan="3" style="text-align: right;">Total </th>
    <th style="text-align: right;"><?php print number_format($TotalQuantity,2,'.',''); ?> </th>
    <th colspan=""> &nbsp; </th>
    <th style="text-align: right;"><?php print number_format($TotalKg,2,'.',''); ?></th>
    <th style="text-align: right;"><?php print number_format($TotalAmount,2,'.',''); ?></th>
    <th colspan="2"> &nbsp; </th>
</tr>	 
</tfoot>
</table>