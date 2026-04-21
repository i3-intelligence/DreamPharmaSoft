<?php
include("auth.php");
include("db.php");
?>
<html>
<head>
<title>Supplier Ledger</title>
<script src="1.5.1jquery.min.js"></script>
<link rel="stylesheet" href="dist/css/bootstrap.min.css">
<!-- start: Favicon -->
<link rel="shortcut icon" href="img/favicon.ico">
<!-- end: Favicon -->
<style>
body{
margin:5px;
}	
.table{
font-size:18px;
white-space:nowrap;
font-family:verdana;
}
#table{
	border-color:black;
}
#table tr td{
	border-color:black;
}
#table tr th{
	border-color:black;
}
@media print {
 .dontPrint{
 display:none;
 }
}

</style>

</head>
<script>
$("document").ready(function() {
$("#table tr").toggle(function(){
    $(this).css('background-color','yellow');
},function(){
    $(this).css('background-color','white');
	
});	
});
</script>
<body>

<?php 
// if(!empty($mpk[1]) && $mpk[1]=='1'){ 	

    if(!empty($_GET['SupplierID']) && is_numeric($_GET['SupplierID'])){

    $SupplierID = $_GET['SupplierID'];
    $query = $conn->prepare("SELECT CONCAT(`SupplierID`,' - ',`Name`,'-',`MobileNo`) AS `sup_info` FROM `Supplier` WHERE  `SupplierID` = '$SupplierID' "); 
    $query->execute();
    $FetchSupplierID = $query->fetch();
     $SupplierInfo = $FetchSupplierID['sup_info'];

?>

<table class="table table-hover table-condensed table-striped table-bordered"  style="white-space: nowrap;" >

<tr>
	<th style="text-align:center; font-size:18px;"> <?php print $company; ?> </th>
</tr>

<tr>
	<th style="text-align:center;"><?php print $c_address; ?></th>
</tr>		

<tr>
	<th style="text-align:center; font-size:18px;"> Supplier Ledger Details</th>
</tr>

</table>

<?php
    //GET START DATE
    $datestring_start_date =$_GET['start_date'];
    list($day, $month, $year) = explode('/', $datestring_start_date);
    $get_start_date = DateTime::createFromFormat('Ymd', $year . $month . $day);

    //GET END DATE
    $datestring_end_date =$_GET['end_date'];
    list($day2, $month2, $year2) = explode('/', $datestring_end_date);
    $get_end_date = DateTime::createFromFormat('Ymd', $year2 . $month2 . $day2);  
?>



<table class="table table-hover table-condensed table-striped table-bordered"  style="white-space: nowrap;">

<tr>
	<th style="font-size:18px; text-align :center">Statement  From: <?php print $statement_start_date = $get_start_date->format('d-m-Y');  ?> To:  <?php print $statement_end_date = $get_end_date->format('d-m-Y');  ?></th>
</tr>

<tr>
	<th style="font-size:18px; text-align :left">Supplier Info.: <?php print $SupplierInfo; ?> </th>
</tr>

</table>

<?php
$SupplierID = $_GET['SupplierID'];

$start_date = $get_start_date->format('Y-m-d');
$end_date =  $get_end_date->format('Y-m-d');

include("SupplierLedgerCall.php");

?>
<table id="table" class="table table-hover table-condensed table-striped table-bordered"  style="white-space: nowrap;">

<thead>
<tr>
	<th style="text-align:center;"> Date </th>
	<th style="text-align:center;"> Details</th>
	<th style="text-align:center;"> Receivable </th>
	<th style="text-align:center;"> Payable </th>
	<th style="text-align:center;"> Balance </th>
</tr>
<tr>
	<th colspan="4" style="text-align:center;"> Opening Balance / Previous  Balance </th>
	<th style="text-align:right;"> <?php print $PreviousBalance; ?> </th>
</tr>
</thead>
<tbody>
	
<?php 

$sl =1;
$Balance = 0;
$Receivable = 0;
$Payable = 0;
$Discount = 0;
$PaidAmount = 0;
$query = $conn->prepare("SELECT 
		`Date`,
		`InvoiceType`,
		`Invoice`,
		`PaymentType`,
		`Title`,
		`PaidAmount`,
		`Discount`,
		(CASE 
		WHEN  `InvoiceType` = 'Purchase' THEN IFNULL(`Receivable`,0) 
		ELSE 0
		END ) AS `Receivable` ,

		(CASE 
		WHEN  `InvoiceType` = 'Supplier Payment' THEN IFNULL(`Payable`,0) 
		WHEN  `InvoiceType` = 'Purchase Return' THEN IFNULL(`Payable`,0) 
		ELSE 0
		END ) AS `Payable` 

		FROM `$TableName` 
		WHERE `date` BETWEEN '".$start_date."' AND '".$end_date."'
		GROUP BY `Invoice`,`InvoiceType` ORDER BY `date`,`time` ASC");
$query->execute();
                
    if($query->rowCount()==0){
    print "<tr> <td colspan=12 style=\"text-align:center; color:red;\"> No matching records found. </td> </tr>";	
    }
    $fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach($fetch_list AS $fetch) { 


		  if ($fetch['Receivable']){ 
		  $dr =($fetch['Receivable']/* - ($fetch['Discount'])*/);
			$Balance -= $dr;
		  }

		  if ($fetch['Payable'] + $fetch['Discount']){ 
			$cr =($fetch['Payable']  + $fetch['Discount']);
			$Balance += $cr;
		  }
?>


<tr>
	<td><?php  print date("d-m-Y",strtotime($fetch['Date'])); ?></td>
  
	<td style="color:<?php if($fetch['Discount'] !='0'){ print "green"; }else{
		print "red"; } 
	 ?>">
	<?php  if($fetch['InvoiceType']=='Purchase'){
		?>
		<table  id="table">
			<thead>
			<tr>
				<th colspan="5"  style="text-align:center;">
				<?php print $fetch['InvoiceType']; ?> :<a onclick="window.open('ChallanInvoice.php?ChallanInvoice=<?php echo $fetch['Invoice']; ?>',
'mywindow','menubar=1,resizable=1,width=900,height=800');" ><?php echo $fetch['Invoice']; ?></a>
				</th>
			</tr>
			<tr>
				<th>Description</th>
				<th>Rate</th>
				<th>Factory Qty</th>
				<th>Depot Qty</th>
				<th>Total</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$FactoryQty=0;
			$DepotQty=0;
			$gdelivery_rate = 0;
			$gdelivery_total_amount = 0;
	
			$select_item = $conn->prepare("SELECT 
			A.*,
			B.`Name` AS `ItemCategory`,
			C.`Thickness`,
			C.`Size`,
			(CASE WHEN A.`SupplierCategory` = 'Factory' THEN A.`Quantity` ELSE 0 END) AS `FactoryQty`,
			(CASE WHEN A.`SupplierCategory` = 'Depot' THEN A.`Quantity` ELSE 0 END) AS `DepotQty`
		
			FROM `Challan` A 
			LEFT JOIN `ItemCategory` B ON (A.`ItemCategoryID` = B.`ItemCategoryID`)
			LEFT JOIN `PackageSize` C ON (A.`PackageSizeID` = C.`PackageSizeID`)
			WHERE A.`ChallanInvoice` = '".$fetch['Invoice']."' AND A.`Cart` = 'Yes' 
			ORDER BY A.`ChallanID` ASC");
			$select_item->execute();
			$fetch_item = $select_item->fetchAll(PDO::FETCH_ASSOC);
			foreach($fetch_item AS $fetch_item){
			?>

			<tr>

				<td style="text-align:center;font-size:18px;"><?php print $fetch_item['ItemCategory']; ?>-<?php print $fetch_item['Thickness']; ?><?php print $fetch_item['Size']; ?></td>
				<td style="text-align:center;font-size:18px;"> <?php print number_format($fetch_item['Rate'],2,'.',''); ?> </td>
				<td style="text-align:center;font-size:18px;"> <?php print $fetch_item['FactoryQty']; ?> </td>
				<td style="text-align:center;font-size:18px;"> <?php print $fetch_item['DepotQty']; ?> </td>
				<td style="text-align:center;font-size:18px;"> <?php print number_format($fetch_item['Amount'],2,'.',''); ?> </td>
			</tr>
			<?php
			$FactoryQty += $fetch_item['FactoryQty'];
			$DepotQty += $fetch_item['DepotQty'];
			$gdelivery_total_amount += $fetch_item['Amount'];
			}
			?>
			<tr>
				<th colspan="2"> Total </th>
				<th style="text-align:center; font-size:18px;"> <?php print $FactoryQty; ?> </th>
				<th style="text-align:center; font-size:18px;"> <?php print $DepotQty; ?> </th>
				<th style="text-align:center; font-size:18px;"> <?php print number_format($gdelivery_total_amount,2,'.',''); ?> </th>
			</tr>
			</tbody>
		</table>
		<?php }else if($fetch['InvoiceType']=='Purchase Return'){
		?>
		<table  id="table" style="">
			<thead>
			<tr>
				<th colspan="5"  style="text-align:center; color:blue;">
				<?php print $fetch['InvoiceType']; ?> :<a onclick="window.open('ChallanInvoice.php?ChallanInvoice=<?php echo $fetch['Invoice']; ?>',
'mywindow','menubar=1,resizable=1,width=900,height=800');" ><?php echo $fetch['Invoice']; ?></a>
				</th>
			</tr>
			<tr>
				<th style="color:blue;">Description</th>
				<th style="color:blue;">Rate</th>
				<th style="color:blue;">Return Qty</th>
				<th style="color:blue;">Total</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$ReturnQuantity=0;
			$gdelivery_rate = 0;
			$gdelivery_total_amount = 0;
	
			$select_item = $conn->prepare("SELECT 
			A.*,
			B.`Name` AS `ItemCategory`,
			C.`Thickness`,
			C.`Size`
		
			FROM `ChallanReturn` A 
			LEFT JOIN `ItemCategory` B ON (A.`ItemCategoryID` = B.`ItemCategoryID`)
			LEFT JOIN `PackageSize` C ON (A.`PackageSizeID` = C.`PackageSizeID`)
			WHERE A.`ChallanReturnInvoice` = '".$fetch['Invoice']."' AND A.`Cart` = 'Yes' 
			ORDER BY A.`ChallanReturnID` ASC");
			$select_item->execute();
			$fetch_item = $select_item->fetchAll(PDO::FETCH_ASSOC);
			foreach($fetch_item AS $fetch_item){
			?>

			<tr>

				<td style="text-align:center;font-size:18px;color:blue;"><?php print $fetch_item['ItemCategory']; ?>-<?php print $fetch_item['Thickness']; ?><?php print $fetch_item['Size']; ?> </td>
				<td style="text-align:center;font-size:18px;color:blue;"> <?php print number_format($fetch_item['ReturnRate'],2,'.',''); ?> </td>
				<td style="text-align:center;font-size:18px;color:blue;"> <?php print $fetch_item['ReturnQuantity']; ?> </td>

				<td style="text-align:center;font-size:18px;color:blue;"> <?php print number_format($fetch_item['ReturnAmount'],2,'.',''); ?> </td>
			</tr>
			<?php
			$ReturnQuantity += $fetch_item['ReturnQuantity'];
			$gdelivery_total_amount += $fetch_item['ReturnAmount'];
			}
			?>
			<tr>
				<th colspan="2" style="color:blue;"> Total </th>
				<th style="text-align:center; font-size:18px;color:blue;"> <?php print $ReturnQuantity; ?> </th>
				<th style="text-align:center; font-size:18px;color:blue;"> <?php print number_format($gdelivery_total_amount,2,'.',''); ?> </th>
			</tr>
			</tbody>
		</table>
		<?php
		}else{

		 ?>
		 
<b>
<a onclick="window.open('SupplierPaymentView.php?SupplierPaymentInvoice=<?php echo $fetch['Invoice']; ?>',
'mywindow','menubar=1,resizable=1,width=900,height=800');" ><?php echo $fetch['Invoice']; ?></a>
</b>
<br>

<?php print $fetch['PaymentType']; ?>/<?php print $fetch['InvoiceType']; ?><br>
<?php print wordwrap($fetch['Title'], 20, "<br>"); ?>
		<?php
		}
		?>
	</td>
    <td  style="text-align:right;background-color:#47d147;"> <?php print number_format($fetch['Receivable'],2,'.',''); ?> </td>
    <td  style="text-align:right;background-color:#ff4d4d;"> <?php print number_format($fetch['Payable'] + $fetch['Discount'],2,'.',''); ?> </td>
    <th style="text-align:right; color:<?php if($Balance + $PreviousBalance <='0'){ print "green";}else{ print "red"; } ?>"> <?php print number_format($Balance + $PreviousBalance,2,'.',''); ?> </th>
   
</tr>

<?php	
$Balance = $Balance;
$Receivable += $fetch['Receivable'];
$Payable += $fetch['Payable'];

} //while 
?>

<tr>
	<th style="text-align:center;" colspan=""> TOTAL </th>
	<th></th>
	<th style="text-align:right;"> <?php print number_format($Receivable,2,'.',''); ?></th>
	<th style="text-align:right;"> <?php print number_format($Payable + $Discount,2,'.',''); ?></th>
	<th style="text-align:right;"> <?php print number_format($PreviousBalance + $Balance,2,'.',''); ?></th>
</tr>
</tbody>
<tfoot>
	<tr>
		<th colspan=10>

            
			<div style="width:200px; height:80px; border:1px solid #CCCCCC; float:left; margin-left:100px; margin-top:30px;"> 
			<b style="float:left; margin-left:50px;">Prepared by  </b>

			<b style="margin-top:40px; margin-left:20px; float:left; text-align:center;"> </b>  
			</div>

			<div style="width:200px; height:80px; border:1px solid #CCCCCC; float:left; margin-left:100px; margin-top:30px;"> 
			<b style="float:left; margin-left:50px;"> Manager  </b>

			<b style="margin-top:40px; margin-left:20px; float:left; text-align:center;"> </b>  
			</div>

            
			<div style="width:200px; height:80px; border:1px solid #CCCCCC; float:left; margin-left:100px; margin-top:30px;"> 
			<b style="float:left; margin-left:50px;"> Authorized </b>

			<b style="margin-top:40px; margin-left:20px; float:left; text-align:center;"></b>  
			</div>
			</div>
		</th>
	</tr>
</tfoot>
</table>

<?php 
	} 
?>

<?php 
	// }else{ 
?>
<!-- <table style="margin:10px;" class="table table-hover table-condensed table-striped table-bordered"  style="white-space: nowrap;">
	<tr>
		<th><span class="label label-danger"> You do not have permission. </span></th>
	</tr>	
</table> -->
<?php 
	// } 
?>

<button onclick="window.print();" class="dontPrint">PRINT THIS PAGE </button>
<button id="download-button" class="dontPrint">Download CSV</button>

	<script type="text/javascript">

	function downloadCSVFile(csv, filename) {
	    var csv_file, download_link;

	    csv_file = new Blob([csv], {type: "text/csv"});

	    download_link = document.createElement("a");

	    download_link.download = filename;

	    download_link.href = window.URL.createObjectURL(csv_file);

	    download_link.style.display = "none";

	    document.body.appendChild(download_link);

	    download_link.click();
	}

		document.getElementById("download-button").addEventListener("click", function () {
		    var html = document.querySelector("table").outerHTML;
			htmlToCSV(html, "Supplier Ledger.csv");
		});


		function htmlToCSV(html, filename) {
			var data = [];
			var rows = document.querySelectorAll("table tr");
					
			for (var i = 0; i < rows.length; i++) {
				var row = [], cols = rows[i].querySelectorAll("td, th");
						
				 for (var j = 0; j < cols.length; j++) {
				        row.push(cols[j].innerText);
		                 }
				        
				data.push(row.join(","));		
			}

			//to remove table heading
			//data.shift()

			downloadCSVFile(data.join("\n"), filename);
		}

	</script>
<?php 
include("DropTable.php");
?>
</body>
</html>