<?php
require_once('auth.php');
include("db.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset='UTF-8'>
	<title>Challan Return Invoice</title>
	<link rel='stylesheet' href='style1.css'>
	<link rel='stylesheet' href='print.css' media="print">
	<style>
	@media print {
  body {
    zoom: 70%;
  }

  #page-wrap {
    width: 65%;
  }
}
	</style>
</head>

<body>

<?php
$query = $conn->prepare("SELECT *,date_format(`ChallanReturnDate`,'%d-%m-%Y') AS `mdate` FROM `ChallanReturn` WHERE `ChallanReturnInvoice` = '$_GET[ChallanReturnInvoice]'   AND `Cart` = 'Yes' GROUP BY `ChallanReturnInvoice`"); 
$query->execute();
if($query->rowCount()==0)	{

	echo "<h1 style='text-align:center; color:red;'>ChallanReturn Invoice Not Found !!!</h1>";
	exit();
	}

$fetch = $query->fetch(PDO::FETCH_ASSOC);


$query1 = $conn->prepare("SELECT CONCAT('Supplier ID: ',`SupplierID`,'<br> ','Supplier Name: ',`Name`,'<br> ','Address: ',`Address`,'<br> ','Mobile: ',MobileNo) AS `sup_info`  FROM `Supplier` WHERE `SupplierID` = '$fetch[SupplierID]' "); 
$query1->execute();
$fetch_supplier = $query1->fetch(PDO::FETCH_ASSOC);

$query2 = $conn->prepare("SELECT * FROM `UserInformation` WHERE `id` = '$fetch[EntryID]'"); 
$query2->execute();
$fetch_logerh = $query2->fetch(PDO::FETCH_ASSOC);
?>

	<div id="page-wrap">
		

         <style>
				.container {
					display: flex;
					/* justify-content: center;
					margin-left: 28px; */
					margin-top: 30px;
				}

				.container img {
					float: left;
					margin-right: 5px;
					margin-top: 30px;
					margin-bottom: 5px;
				}

				.container span {
					margin-right: 5px;
				}
				#items td.total-line{
					border-right: solid 1px;
				}

				#sign5 {
					text-align: right;
					margin: 20px -27px 0 0;
					float: right;
				}
			</style>
 
			


				<center>
				<div >
				<p><font style="font-size:16px;">বিসমিল্লাহির রাহমানির রাহীম</font><br>
				<font style="font-size:30px;"> <b><?php print $company; ?> </b></font><br>
				<font style="font-size:13px;"> <b><?php print $c_address; ?> <br> <?php print $c_mobile; ?>. <?php print $c_email; ?></b></font></p>
				</div>	

				<h2>Challan Return Invoice</h2> </center>
		
		<div id="identity" style="border:0px solid; width:100%; float:left;">
        	
           <div style="float:left;">
               

            <b><font style="font-size: 14px;"> <?php print $fetch_supplier['sup_info']; ?></font></b>
	
           </div>
            
           <table id="meta" style="width: 250px;">
                
                <tr>
                    <td style="border: none;text-align: left;font-size:15px;padding: 0px;"> <b>Date:</b></td>
                    <td style="border: none;text-align: left;font-size:15px;padding: 0px;"><b><?php print $fetch['mdate']; ?></b></td>
                </tr>
                
                <tr>
                   
                </tr>
                
                <tr>
                    <td style="border: none;text-align: left;font-size:15px;padding: 0px;"><b>ChallanReturn No.:</b> </td>
                    <td style="border: none;text-align: left;font-size:15px;padding: 0px;"><b><?php print $_GET['ChallanReturnInvoice']; ?></b></td>
                </tr>

                <tr>
                    <td style="border: none;text-align: left;font-size:15px;padding: 0px;"><b>User:</b></td>
                    <td style="border: none;text-align: left;font-size:15px;padding: 0px;"><div class="due"><b><?php print "$fetch_logerh[UserName]"; ?></b> </div></td>
                </tr>

            </table>
		</div>
		
        
		<div style="clear:both"></div>
		

		
<table id="items">
<tr>
  <th style="width: 10%">SL</th>
  <th style="width: 45%">Description</th>
  <th style="width: 15%">Return Rate</th>
  <th style="width: 15%">Challan Return Qty</th>
  <th style="width: 15%">Total</th>
</tr>

<?php
$sl=1;
$qty=0;
$gdelivery_rate = 0;
$gdelivery_total_amount = 0;
$num_rows  = 0;


$select_item = $conn->prepare("SELECT 
A.*,
B.`Name` AS `ItemCategory`,
C.`Thickness`,
C.`Size`

FROM `ChallanReturn` A 
LEFT JOIN `ItemCategory` B ON (A.`ItemCategoryID` = B.`ItemCategoryID`)
LEFT JOIN `PackageSize` C ON (A.`PackageSizeID` = C.`PackageSizeID`)
WHERE A.`ChallanReturnInvoice` = '".$_GET['ChallanReturnInvoice']."' AND A.`Cart` = 'Yes' 
ORDER BY A.`ChallanReturnID` ASC"); 
$select_item->execute();
$fetch_list = $select_item->fetchAll(PDO::FETCH_ASSOC);
foreach($fetch_list AS $Fetch){

?>		  

<tr class="item-row">
  <td style="border-right: solid 1px;"><div class="delete-wpr"><b><?php print $sl++; ?> <a class="delete" href="javascript:;" title="Remove row">&radic;</a></b></div></td>
  
  <td class="description"><b><?php print $Fetch['ItemCategory']; ?>-<?php print $Fetch['Thickness']; ?><?php print $Fetch['Size']; ?> </b></td>
  <td style="text-align:right;border-left: solid 1px;"><b><?php print $Fetch['ReturnRate']; ?></b></td>
  <td style="text-align:right;border-left: solid 1px;"><b><?php print $Fetch['ReturnQuantity']; ?></b></td>
  <td style="text-align:right;border-left: solid 1px;"><b><?php print $Fetch['ReturnAmount']; ?></b></td>
</tr>

<?php  
$qty +=$Fetch['ReturnQuantity'];
$gdelivery_rate +=$Fetch['ReturnRate'];
$gdelivery_total_amount +=$Fetch['ReturnAmount'];

	} // WHILE ?>		  
		  
<?php
if ($num_rows < 17) {
	$row = 16 - $num_rows;

for ($x = 0; $x <= $row; $x++) {
	print "<tr class='items'>
	<td style=\"border-bottom: none;border-top: none;\"></td>
	  <td class=\"description\" style=\"border-bottom: none;border-top: none;padding: 14px;\"></td>
	  <td style=\"text-align:right;border-bottom: none;border-top: none;padding: 14px;\"></td>
	  <td style=\"text-align:right;border-bottom: none;border-top: none;padding: 14px;\"></td>
	  <td style=\"text-align:right;border-bottom: none;border-top: none;padding: 14px;\"></td>
	</tr>";
  }
}
?>	


  <tr>
	<th colspan="3"> <b>Total Return Amount</b> </th>
	<th style="text-align:right;"> <b><?php print number_format($qty,2,'.',''); ?></b> </th>
	<th style="text-align:right;"> <b><?php print number_format($gdelivery_total_amount,2,'.',''); ?></b> </th>
  </tr>	



</table>

<div id="terms" style="margin-top: 5px; font-size: 12px;margin-bottom: 70px;">
  <b>Remarks: <?php print $fetch['Remarks']; ?> </b>
</div>

<div style="width: 33%; height: 50%; float:left;text-decoration: overline;"><b>Prepared By</b></div>
<div style="width: 33%; height: 50%; float:right;text-align: right;text-decoration: overline;"><b>Authorized By</b></div>
<div style="width: 33%; height: 50%; float:right;text-align: center;text-decoration: overline;"><b>Checked By</b></div>

<div style="width: 100%; height: 50%; clear:both;text-align: center;margin-top: 15%;font-size:13px;">
Powered By <b><?php print $company; ?></b> || Design & Developed By <a href="https://www.i3intelligence.com/" style="color:black;text-decoration: none;"><b>i3 intelligence</b></a>.
</div> 
</div>
	
</body>

</html>