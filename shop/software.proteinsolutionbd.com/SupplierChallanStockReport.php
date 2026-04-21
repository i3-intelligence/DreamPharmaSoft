<?php
include("auth.php");
include("db.php");
?>
<html>
<head>
<title> Stock Report</title>
<link rel="stylesheet" href="dist/css/bootstrap.min.css">
<script src="1.5.1jquery.min.js"></script>
<!-- start: Favicon -->
<link rel="shortcut icon" href="img/favicon.ico">
<!-- end: Favicon -->
<style>
body{
margin:5px;
}	
.table{
font-size:15px;
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
<script>
$("document").ready(function() {
$("#table tr").toggle(function(){
    $(this).css('background-color','yellow');
},function(){
    $(this).css('background-color','white');
	
});	
});
</script>
</head>

<body>

<?php 
// if(!empty($mpk[1]) && $mpk[1]=='1'){ 	

    
    if(!empty($_GET['SupplierID']) && $_GET['SupplierID'] !='All'){
        $SupplierID = $_GET['SupplierID'];
        $query = $conn->prepare("SELECT CONCAT(`SupplierID`,'-',`Name`,'-',`MobileNo`,'-',`Address`) AS `SupplierInfo` FROM `Supplier` WHERE  `SupplierID` = '$SupplierID'"); 
        $query->execute();
        $SupplierID = $query->fetch();
        $SupplierInfo = $SupplierID['SupplierInfo'];
        }else{
            $SupplierInfo = 'All';
        }
?>


<table class="table table-hover table-condensed table-striped table-bordered"  style="white-space: nowrap;">

<tr>
	<th style="text-align:center; font-size:18px;"> <?php print $company; ?> </th>
</tr>

<tr>
	<th style="text-align:center;"><?php print $c_address; ?></th>
</tr>		

<tr>
	<th style="text-align:center; font-size:18px;"> Stock Report </th>
</tr>

</table>

<?php
        //GET END DATE
        $datestring_end_date =$_GET['end_date'];
        list($day2, $month2, $year2) = explode('/', $datestring_end_date);
        $get_end_date = DateTime::createFromFormat('Ymd', $year2 . $month2 . $day2);  
?>



<table class="table table-hover table-condensed table-striped table-bordered"  style="white-space: nowrap;">

<tr>
	<th style="font-size:14px; text-align :center">Statement : <?php print $statement_end_date = $get_end_date->format('d-m-Y');  ?></th>
</tr>

<tr>
	<th style="font-size:14px; text-align :left">Supplier Info : <?php print $SupplierInfo; ?></th>
</tr>

</table>


<table id="table" class="table table-hover table-condensed table-striped table-bordered"  style="white-space: nowrap;">

<thead>
<tr>
	<th> S/L </th>
	<th> Supplier Name </th>
	<th> Challan Invoice </th>
	<th> Product Info </th>
	<th> D.O Rate</th>
	<th> Opening </th>
	<th> Purchase </th>
    <th> Purchase <br> Return </th>
    <th> Sales </th>
    <th> Sales <br> Return</th>
    <th> Balance </th>
    <th>Closing <br> Balance </th>
	<th> Balance <br> Amount </th>
    <th>Closing <br> Balance <br> Amount </th>
</tr>

</thead>
<tbody>
<?php 
  

if(!empty($_GET['SupplierID']) && $_GET['SupplierID'] =='All'){
    $SupplierID ="";
}else{
    $SupplierID =" AND A.`SupplierID` = '$_GET[SupplierID]' ";
} 
 

$end_date =  $get_end_date->format('Y-m-d');
$pdate = date('Y-m-d', strtotime('-1 day', strtotime($end_date)));
$sl =1;
$PurchaseQuantity = 0;
$PurchaseReturnQuantity = 0;
$SalesQuantity = 0;
$SalesReturnQuantity = 0;
$total_balance_quantity = 0;
$total_balance_am  = 0;
$TotalOpeningBalanceQuantity = 0;
$TotalClosingBalance = 0;

$query = $conn->prepare("SELECT 
A.`ChallanID`,
CONCAT(C.`Name`,'-',D.`Thickness`,'-',D.`Size`) AS `Product`, 
A.`PackageSizeID`,
A.`ChallanInvoice`,
A.`ChallanDate`,
A.`Rate`,
(CASE WHEN `Cart` = 'Yes' AND A.`ChallanDate` BETWEEN '$i3_define_date' AND '$pdate' THEN A.`Quantity` ELSE 0 END) AS `OpeningPurchaseQuantity`,
(CASE WHEN `Cart` = 'Yes' AND A.`ChallanDate` = '$end_date'  THEN A.`Quantity` ELSE 0 END) AS `PurchaseQuantity`,
CONCAT(B.`SupplierID`,'-',B.`Name`,'-',B.`MobileNo`,'-',B.`Address`) AS `SupplierInfo`,
IFNULL(E.`OpeningPurchaseReturnQuantity`,0) AS `OpeningPurchaseReturnQuantity`,
IFNULL(F.`OpeningSalesQuantity`,0) AS `OpeningSalesQuantity`,
IFNULL(G.`OpeningSalesReturnQuantity`,0) AS `OpeningSalesReturnQuantity`,
IFNULL(E.`PurchaseReturnQuantity`,0) AS `PurchaseReturnQuantity`,
IFNULL(F.`SalesQuantity`,0) AS `SalesQuantity`,
IFNULL(G.`SalesReturnQuantity`,0) AS `SalesReturnQuantity`

FROM `Challan` A 
LEFT JOIN `Supplier` B ON (A.`SupplierID` = B.`SupplierID`) 
LEFT JOIN `ItemCategory` C ON (A.`ItemCategoryID` = C.`ItemCategoryID`) 

LEFT JOIN (SELECT
`PackageSizeID`,
`Thickness`,
`Size`
FROM `PackageSize` ) D ON (A.`PackageSizeID` = D.`PackageSizeID`)

LEFT JOIN (SELECT
`ChallanID`,
SUM(CASE WHEN `Cart` = 'Yes' AND `ChallanReturnDate` BETWEEN '$i3_define_date'  AND '$pdate' THEN `ReturnQuantity` ELSE 0 END) AS `OpeningPurchaseReturnQuantity`,
SUM(CASE WHEN `Cart` = 'Yes' AND `ChallanReturnDate` = '$end_date' THEN `ReturnQuantity` ELSE 0 END) AS `PurchaseReturnQuantity`
FROM `ChallanReturn` WHERE `ChallanReturnDate` BETWEEN '$i3_define_date'  AND '$end_date' GROUP BY `ChallanID` ) E ON (A.`ChallanID` = E.`ChallanID`)


LEFT JOIN (SELECT
`ChallanID`,
SUM(CASE WHEN `Cart` = 'Yes' AND `CashMemoDate` BETWEEN '$i3_define_date'  AND '$pdate' THEN `SalesQuantity` ELSE 0 END) AS `OpeningSalesQuantity`,
SUM(CASE WHEN `Cart` = 'Yes' AND `CashMemoDate` = '$end_date' THEN `SalesQuantity` ELSE 0 END) AS `SalesQuantity`
FROM `CashMemo` WHERE `CashMemoDate` BETWEEN '$i3_define_date'  AND '$end_date' GROUP BY `ChallanID` ) F ON (A.`ChallanID` = F.`ChallanID`)

LEFT JOIN (SELECT
`ChallanID`,
SUM(CASE WHEN `Cart` = 'Yes' AND `CashMemoReturnDate` BETWEEN '$i3_define_date'  AND '$pdate' THEN `ReturnQuantity` ELSE 0 END) AS `OpeningSalesReturnQuantity`,
SUM(CASE WHEN `Cart` = 'Yes' AND `CashMemoReturnDate` = '$end_date' THEN `ReturnQuantity` ELSE 0 END) AS `SalesReturnQuantity`
FROM `CashMemoReturn` WHERE `CashMemoReturnDate` BETWEEN '$i3_define_date'  AND '$end_date' GROUP BY `ChallanID` ) G ON (A.`ChallanID` = G.`ChallanID`)

 
WHERE A.`ChallanDate` BETWEEN '$i3_define_date'  AND '$end_date' $SupplierID
GROUP BY A.`ChallanID`
ORDER BY A.`ChallanDate`,A.`ChallanInvoice` ASC");
$query->execute();
                
    if($query->rowCount()==0){
    print "<tr> <td colspan=7 style=\"text-align:center; color:red;\"> No matching records found. </td> </tr>";	
    }
    $fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach($fetch_list AS $fetch) { 
	$OpeningBalanceQuantity = (($fetch['OpeningPurchaseQuantity'] + $fetch['OpeningSalesReturnQuantity']) - ($fetch['OpeningPurchaseReturnQuantity'] + $fetch['OpeningSalesQuantity']));
	
    $BalanceQuantity = (($fetch['PurchaseQuantity'] + $fetch['SalesReturnQuantity']) - ($fetch['PurchaseReturnQuantity'] + $fetch['SalesQuantity']));

if(($OpeningBalanceQuantity + $BalanceQuantity) !='0' ){
        
?>


<tr>
	<td Title="<?php echo $fetch['ChallanID']; ?>"><?php echo $sl++; ?> </td>
    <td style="text-align:left;" Title="Supplier Name"><?php echo $fetch['SupplierInfo']; ?> </td>
    <td style="text-align:left;" Title="Challan Invoice"><?php echo $fetch['ChallanInvoice']; ?> </td>
    <td style="text-align:left;" Title="Product Info"><?php echo $fetch['Product']; ?></td>
	<td style="text-align:right;" Title="D.O Rate"><?php print number_format($fetch['Rate'],3,'.',''); ?> </td>
	<td style="text-align:right;" Title="Opening"><?php print number_format($OpeningBalanceQuantity,2,'.',''); ?> </td>
    <td style="text-align:right;" Title="Purchase"><?php print number_format($fetch['PurchaseQuantity'],2,'.',''); ?> </td>
    <td style="text-align:right;" Title="Purchase Return"><?php print number_format($fetch['PurchaseReturnQuantity'],2,'.',''); ?> </td>
    <td style="text-align:right;" Title="Sales"><?php print number_format($fetch['SalesQuantity'],2,'.',''); ?> </td>
    <td style="text-align:right;" Title="Sales Return"><?php print number_format($fetch['SalesReturnQuantity'],2,'.',''); ?> </td>
    <td style="text-align:right;" Title="Balance"><?php print number_format($BalanceQuantity,2,'.',''); ?> </td>
    <td style="text-align:right;"  Title="Closing Balance"><?php print number_format($OpeningBalanceQuantity+$BalanceQuantity,2,'.',''); ?> </td>
    <td style="text-align:right;"  Title="Balance Amount"><?php print $balance_am = number_format($BalanceQuantity * $fetch['Rate'],2,'.',''); ?> </td>
	<td style="text-align:right;"  Title="Closing Balance Amount"><?php print $ClosingBalance = number_format(($OpeningBalanceQuantity + $BalanceQuantity) * $fetch['Rate'],2,'.',''); ?> </td>
   
</tr>

<?php	
$PurchaseQuantity += $fetch['PurchaseQuantity'];
$PurchaseReturnQuantity += $fetch['PurchaseReturnQuantity'];
$SalesQuantity += $fetch['SalesQuantity'];
$SalesReturnQuantity += $fetch['SalesReturnQuantity'];
$TotalOpeningBalanceQuantity += $OpeningBalanceQuantity;
$total_balance_quantity += $BalanceQuantity;
$total_balance_am += $balance_am;
$TotalClosingBalance += $ClosingBalance;
} //if
} //while 
?>
<tr>
	<th style="text-align:center;" colspan="5"> TOTAL </th>
	<th style="text-align:right;"><?php print number_format($TotalOpeningBalanceQuantity,2,'.',''); ?></th>
	<th style="text-align:right;"><?php print number_format($PurchaseQuantity,2,'.',''); ?></th>
	<th style="text-align:right;"><?php print number_format($PurchaseReturnQuantity,2,'.',''); ?></th>
    <th style="text-align:right;"><?php print number_format($SalesQuantity,2,'.',''); ?></th>
    <th style="text-align:right;"><?php print number_format($SalesReturnQuantity,2,'.',''); ?></th>
	<th style="text-align:right;"><?php print number_format($total_balance_quantity,2,'.',''); ?></th>
	<th style="text-align:right;"><?php print number_format($TotalOpeningBalanceQuantity+$total_balance_quantity,2,'.',''); ?></th>
	<th style="text-align:right;"><?php print number_format($total_balance_am,2,'.',''); ?></th>
	<th style="text-align:right;"><?php print number_format($TotalClosingBalance,2,'.',''); ?></th>
</tr>
</tbody>
<tfoot>
	<tr>
		<th colspan="15">

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
			htmlToCSV(html, "Safety Stock Report.csv");
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
</body>
</html>