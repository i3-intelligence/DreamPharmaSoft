<?php
require_once('auth.php');
include("db.php");
?>
<table id="example2" class="table table-bordered table-striped">
 <thead>
<tr>
    <th colspan="9" style="text-align: center;"> <font color="#2A0000"> <b> Challan Return Cart List </b> </font> </th>
</tr>
<tr>
	<th align="center"> SL </th>
	<th align="center"> Challan Invoice </th>
	<th align="center"> Item Category </th>
	<th align="center"> Thickness & Size</th>
	<th align="center"> Qty </th>
	<th align="center"> Return Rate </th>
	<th align="center"> Total Return Amount </th>
	<th align="center"> Remarks </th>
    <th align="center"> Remove </th>
</tr>
</thead>	
<tbody>
<?php
$sl=1;
$TotalReturnQuantity = 0;
$TotalReturnAmount = 0;
$QueryChart = $conn->prepare("SELECT 
        A.*,
        B.`Name` AS `ItemCategory`,
        C.`Thickness`,
        C.`Size`

FROM `ChallanReturn` A 
LEFT JOIN `ItemCategory` B ON (A.`ItemCategoryID` = B.`ItemCategoryID`)
LEFT JOIN `PackageSize` C ON (A.`PackageSizeID` = C.`PackageSizeID`)
WHERE A.`EntryID`='$SessionID' AND Cart = '' ORDER BY `ChallanReturnID` DESC ");
$QueryChart->execute();
$FetchChart = $QueryChart->FetchAll(PDO::FETCH_ASSOC);
foreach($FetchChart AS $Fetch) {
?>
<tr>
			<td align="center"><?php print $sl++; ?></td>
			
			<td align="center"> <?php print $Fetch['ChallanInvoice']; ?> </td>

			<td align="center"> <?php print $Fetch['ItemCategory']; ?> </td>
			
			<td align="center"> <?php print $Fetch['Thickness']; ?><?php print $Fetch['Size']; ?> </td>
			
			<td align="right"> <?php print number_format($Fetch['ReturnQuantity'],2,'.',''); ?> </td>

			<td align="right"> <?php print number_format($Fetch['ReturnRate'],2,'.',''); ?> </td>

			<td align="right"> <?php print number_format($Fetch['ReturnAmount'],2,'.',''); ?> </td>
			
			<td align="center"> <?php print $Fetch['Remarks']; ?> </td>
			
			<td><a href='ChallanReturnAction.php?delete=yes&DeleteID=<?php print $Fetch['ChallanReturnID']; ?>&ChallanInvoice=<?php print $Fetch['ChallanInvoice']; ?>'>Remove</a></td>

			
		
</tr>
<?php
    $TotalReturnQuantity +=$Fetch['ReturnQuantity'];
    $TotalReturnAmount +=$Fetch['ReturnAmount'];
	} //close while brace
?>
</tbody>
<tfoot>
<tr>
    <th colspan="4" style="text-align: right;">Total </th>
    <th style="text-align: right;"><?php print number_format($TotalReturnQuantity,2,'.',''); ?> </th>
    <th colspan=""> &nbsp; </th>
    <th style="text-align: right;"><?php print number_format($TotalReturnAmount,2,'.',''); ?></th>
    <th colspan="2"> &nbsp; </th>
</tr>	 
</tfoot>
</table>