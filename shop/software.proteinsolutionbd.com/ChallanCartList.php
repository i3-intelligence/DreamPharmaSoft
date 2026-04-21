<?php
require_once('auth.php');
include("db.php");
?>
<table class="table table-bordered table-striped">
 <thead>
<tr>
    <th colspan="9" style="text-align: center;"> <font color="#2A0000"> <b> Challan Cart List </b> </font> </th>
</tr>
<tr>
	<th align="center"> SL </th>
	<th align="center"> Supplier Category </th>
	<th align="center"> Item Category </th>
	<th align="center"> Thickness & Size</th>
	<th align="center"> Qty </th>
	<th align="center"> Rate </th>
	<th align="center"> Total Amount </th>
	<th align="center"> Remarks </th>
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

FROM `Challan` A 
LEFT JOIN `ItemCategory` B ON (A.`ItemCategoryID` = B.`ItemCategoryID`)
LEFT JOIN `PackageSize` C ON (A.`PackageSizeID` = C.`PackageSizeID`)
WHERE A.`EntryID`='$SessionID' AND Cart = '' ORDER BY `ChallanID` DESC ");
$QueryChart->execute();
$FetchChart = $QueryChart->FetchAll(PDO::FETCH_ASSOC);
foreach($FetchChart AS $Fetch) {
?>
<tr>
			<td align="center"><?php print $sl++; ?></td>
			
			<td align="center"> <?php print $Fetch['SupplierCategory']; ?> </td>

			<td align="center"> <?php print $Fetch['ItemCategory']; ?> </td>
			
			<td align="center"> <?php print $Fetch['Thickness']; ?><?php print $Fetch['Size']; ?> </td>
			
			<td align="right"> <?php print number_format($Fetch['Quantity'],2,'.',''); ?> </td>

			<td align="right"> <?php print number_format($Fetch['Rate'],2,'.',''); ?> </td>

			<td align="right"> <?php print number_format($Fetch['Amount'],2,'.',''); ?> </td>
			
			<td align="center"> <?php print $Fetch['Remarks']; ?> </td>
			
			<td><a href='ChallanCartAction.php?delete=yes&id=<?php print $Fetch['ChallanID']; ?>'>Remove</a></td>

			
		
</tr>
<?php
    $TotalQuantity +=$Fetch['Quantity'];
    $TotalAmount +=$Fetch['Amount'];
	} //close while brace
?>
</tbody>
<tfoot>
<tr>
    <th colspan="4" style="text-align: right;">Total </th>
    <th style="text-align: right;"><?php print number_format($TotalQuantity,2,'.',''); ?> </th>
    <th colspan=""> &nbsp; </th>
    <th style="text-align: right;"><?php print number_format($TotalAmount,2,'.',''); ?></th>
    <th colspan="2"> &nbsp; </th>
</tr>	 
</tfoot>
</table>