<?php
require_once('auth.php');
include("db.php");
?>
<table id="example2" class="table table-bordered table-striped">
<tr>
    <th colspan="10" style="text-align: center;"> <font color="#2A0000"> <b> Purchase Rate Setup List </b> </font> </th>
</tr>
<tr>
	<th align="center"> SL </th>
	<th align="center"> Item Category </th>
	<th align="center"> Customer Category </th>
	<th align="center"> Thickness & Size</th>
	<th align="center"> Rate </th>
    <th align="center"> Date </th>
    <th align="center"> Time </th>
    <th align="center"> Operator </th>
    <th align="center"> Remove </th>
</tr>
	
<?php
$sl=1;
$QueryChart = $conn->prepare("SELECT 
        A.*,
        date_format(A.`CreateDate`,'%d-%m-%Y') AS `date`,
        date_format(A.`CreateDate`,'%h:%i:%s %p') AS `mtime`,
        B.`Name` AS `ItemCategory`,
        C.`Thickness`,
        C.`Size`,
        D.`UserName` AS `EntryBy` 

FROM `PurchaseRate` A 
LEFT JOIN `ItemCategory` B ON (A.`ItemCategoryID` = B.`ItemCategoryID`)
LEFT JOIN `PackageSize` C ON (A.`PackageSizeID` = C.`PackageSizeID`)
LEFT JOIN `UserInformation` D ON (A.`EntryID` = D.`Id`)
WHERE A.`SupplierID`='$SupplierID' AND A.`ItemCategoryID`='$ItemCategoryID' ORDER BY `PurchaseRateID` ASC ");
$QueryChart->execute();
$FetchChart = $QueryChart->FetchAll(PDO::FETCH_ASSOC);
foreach($FetchChart AS $Fetch) {
?>
<tr>
			<td align="center"><?php print $sl++; ?></td>
			
			<td align="center"> <?php print $Fetch['ItemCategory']; ?> </td>

			<td align="center"> <?php print $Fetch['SupplierCategory']; ?> </td>
			
			<td align="center"> <?php print $Fetch['Thickness']; ?> (<?php print $Fetch['Size']; ?>) </td>
			
			<td align="right"> <?php print $Fetch['Rate']; ?> </td>
			
			<td align="center"> <?php print $Fetch['date']; ?> </td>
			
			<td align="center"> <?php print $Fetch['mtime']; ?> </td>
			
			<td align="center"> <?php print $Fetch['EntryBy']; ?> </td>
			<td><a href='PurchaseRateAction.php?delete=yes&id=<?php print $Fetch['PurchaseRateID']; ?>'>Remove</a></td>

			
		
</tr>
<?php
	} //close while brace
		
?>	 
	 
</table>