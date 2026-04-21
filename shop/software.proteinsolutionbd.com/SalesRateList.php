<?php
require_once('auth.php');
include("db.php");
?>
<table id="example2" class="table table-bordered table-striped">
<tr>
    <th colspan="10" style="text-align: center;"> <font color="#2A0000"> <b> Salese Rate Setup List </b> </font> </th>
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
        date_format(A.`CreateDate`,'%d-%m-%Y') AS `Date`,
        date_format(A.`CreateDate`,'%h:%i:%s %p') AS `Time`,
        B.`Name` AS `ItemCategory`,
        C.`Thickness`,
        C.`Size`,
        D.`UserName` AS `EntryBy`,
        E.`Name` AS `CustomerCategory`

FROM `SalesRate` A 
LEFT JOIN `ItemCategory` B ON (A.`ItemCategoryID` = B.`ItemCategoryID`)
LEFT JOIN `PackageSize` C ON (A.`PackageSizeID` = C.`PackageSizeID`)
LEFT JOIN `UserInformation` D ON (A.`EntryID` = D.`Id`)
LEFT JOIN `CustomerCategory` E ON (A.`CustomerCategoryID` = E.`CustomerCategoryID`)
WHERE A.`SupplierID`='$SupplierID' AND A.`ItemCategoryID`='$ItemCategoryID' /*AND A.CustomerCategoryID = '$CustomerCategoryID' */ORDER BY `SalesRateID` ASC ");
$QueryChart->execute();
$FetchChart = $QueryChart->FetchAll(PDO::FETCH_ASSOC);
foreach($FetchChart AS $Fetch) {
?>
<tr>
			<td align="center"><?php print $sl++; ?></td>
			
			<td align="center"> <?php print $Fetch['ItemCategory']; ?> </td>

			<td align="center"> <?php print $Fetch['CustomerCategory']; ?> </td>
			
			<td align="center"> <?php print $Fetch['Thickness']; ?> (<?php print $Fetch['Size']; ?>) </td>
			
			<td align="right"> <?php print $Fetch['Rate']; ?> </td>
			
			<td align="center"> <?php print $Fetch['Date']; ?> </td>
			
			<td align="center"> <?php print $Fetch['Time']; ?> </td>
			
			<td align="center"> <?php print $Fetch['EntryBy']; ?> </td>
			<td><a href='SalesRateAction.php?delete=yes&id=<?php print $Fetch['SalesRateID']; ?>'>Remove</a></td>

			
		
</tr>
<?php
	} //close while brace
		
?>	 
	 
</table>