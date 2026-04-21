<?php
include("auth.php");
include("db.php");
?>
<html>
<head>
<title>Low Stock Report</title>
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
	<th style="text-align:center; font-size:18px;">Low Stock Report </th>
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
	<th> SupplierName </th>
	<th> Product Info </th>
	<th> Purchase </th>
    <th> Purchase Return </th>
    <th> Sales </th>
    <th> Sales Return</th>
    <th>Low Stock</th>
    <th> Balance </th>
    <th> Balance <br> Amount </th>
</tr>

</thead>
<tbody>
<?php 
  

if(!empty($_GET['SupplierID']) && $_GET['SupplierID'] =='All'){
    $SupplierID ="";
}else{
    $SupplierID =" WHERE A.`SupplierID` = '$_GET[SupplierID]' ";
} 
 

$end_date =  $get_end_date->format('Y-m-d');

$sl =1;
$PurchaseQuantity = 0;
$PurchaseReturnQuantity = 0;
$SalesQuantity = 0;
$SalesReturnQuantity = 0;
$total_balance_quantity = 0;
$total_balance_am  = 0;

$query = $conn->prepare("SELECT 
A.`LowStock`,
CONCAT(C.`Name`,'-',A.`Thickness`,'-',A.`Size`) AS `Product`, 
CONCAT(B.`SupplierID`,'-',B.`Name`,'-',B.`MobileNo`,'-',B.`Address`) AS `SupplierInfo`,
IFNULL(D.`PurchaseQuantity`,0) AS `PurchaseQuantity`,
IFNULL(E.`PurchaseReturnQuantity`,0) AS `PurchaseReturnQuantity`,
IFNULL(F.`SalesQuantity`,0) AS `SalesQuantity`,
IFNULL(G.`SalesReturnQuantity`,0) AS `SalesReturnQuantity`,
I.`Rate`
FROM `PackageSize` A 
LEFT JOIN `Supplier` B ON (A.`SupplierID` = B.`SupplierID`) 
LEFT JOIN `ItemCategory` C ON (A.`ItemCategoryID` = C.`ItemCategoryID`) 

LEFT JOIN (SELECT
`PackageSizeID`,
SUM(CASE WHEN `Cart` = 'Yes' THEN `Quantity` ELSE 0 END) AS `PurchaseQuantity`
FROM `Challan` WHERE `ChallanDate` BETWEEN '$i3_define_date'  AND '$end_date' GROUP BY `PackageSizeID` ) D ON (A.`PackageSizeID` = D.`PackageSizeID`)

LEFT JOIN (SELECT
`PackageSizeID`,
SUM(CASE WHEN `Cart` = 'Yes' THEN `ReturnQuantity` ELSE 0 END) AS `PurchaseReturnQuantity`
FROM `ChallanReturn` WHERE `ChallanReturnDate` BETWEEN '$i3_define_date'  AND '$end_date' GROUP BY `PackageSizeID` ) E ON (A.`PackageSizeID` = E.`PackageSizeID`)


LEFT JOIN (SELECT
`PackageSizeID`,
SUM(CASE WHEN `Cart` = 'Yes' THEN `SalesQuantity` ELSE 0 END) AS `SalesQuantity`
FROM `CashMemo` WHERE `CashMemoDate` BETWEEN '$i3_define_date'  AND '$end_date' GROUP BY `PackageSizeID` ) F ON (A.`PackageSizeID` = F.`PackageSizeID`)

LEFT JOIN (SELECT
`PackageSizeID`,
SUM(CASE WHEN `Cart` = 'Yes' THEN `ReturnQuantity` ELSE 0 END) AS `SalesReturnQuantity`
FROM `CashMemoReturn` WHERE `CashMemoReturnDate` BETWEEN '$i3_define_date'  AND '$end_date' GROUP BY `PackageSizeID` ) G ON (A.`PackageSizeID` = G.`PackageSizeID`)

LEFT JOIN (SELECT CC.`ChallanID`, DD.`Rate`, DD.`PackageSizeID` FROM (SELECT MAX(`ChallanID`) AS `ChallanID` FROM `Challan` WHERE `ChallanDate` BETWEEN  '$i3_define_date'  AND '$end_date' GROUP BY `PackageSizeID`) CC JOIN `Challan` DD ON (CC.`ChallanID` = DD.`ChallanID`) GROUP BY DD.`PackageSizeID`) I ON (A.`PackageSizeID` = I.`PackageSizeID`)
$SupplierID 
ORDER BY A.`PackageSizeID` ASC");
$query->execute();
                
    if($query->rowCount()==0){
    print "<tr> <td colspan=7 style=\"text-align:center; color:red;\"> No matching records found. </td> </tr>";	
    }
    $fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach($fetch_list AS $fetch) { 
    $BalanceQuantity = (($fetch['PurchaseQuantity'] + $fetch['SalesReturnQuantity']) - ($fetch['PurchaseReturnQuantity'] + $fetch['SalesQuantity']));

if($BalanceQuantity !='0' && !empty($fetch['LowStock']) && $fetch['LowStock'] > $BalanceQuantity ){
        
?>


<tr>
	<td><?php echo $sl++; ?> </td>
    <td style="text-align:left;"><?php echo $fetch['SupplierInfo']; ?> </td>
    <td style="text-align:left;"><?php echo $fetch['Product']; ?></td>
    <td style="text-align:right;"><?php print number_format($fetch['PurchaseQuantity'],2,'.',''); ?> </td>
    <td style="text-align:right;"><?php print number_format($fetch['PurchaseReturnQuantity'],2,'.',''); ?> </td>
    <td style="text-align:right;"><?php print number_format($fetch['SalesQuantity'],2,'.',''); ?> </td>
    <td style="text-align:right;"><?php print number_format($fetch['SalesReturnQuantity'],2,'.',''); ?> </td>
    <td style="text-align:right;"><?php print number_format($fetch['LowStock'],2,'.',''); ?> </td>
    <td style="text-align:right;"><?php print number_format($BalanceQuantity,2,'.',''); ?> </td>
    <td style="text-align:right;"><?php print $balance_am = number_format($BalanceQuantity * $fetch['Rate'],2,'.',''); ?> </td>
   
</tr>

<?php	
$PurchaseQuantity += $fetch['PurchaseQuantity'];
$PurchaseReturnQuantity += $fetch['PurchaseReturnQuantity'];
$SalesQuantity += $fetch['SalesQuantity'];
$SalesReturnQuantity += $fetch['SalesReturnQuantity'];
$total_balance_quantity += $BalanceQuantity;
$total_balance_am += $balance_am;
}
} //while 
?>
<tr>
	<th style="text-align:center;" colspan="3"> TOTAL </th>
	<th style="text-align:right;"><?php print number_format($PurchaseQuantity,2,'.',''); ?></th>
	<th style="text-align:right;"><?php print number_format($PurchaseReturnQuantity,2,'.',''); ?></th>
    <th style="text-align:right;"><?php print number_format($SalesQuantity,2,'.',''); ?></th>
    <th style="text-align:right;"><?php print number_format($SalesReturnQuantity,2,'.',''); ?></th>
    <th></th>
	<th style="text-align:right;"><?php print number_format($total_balance_quantity,2,'.',''); ?></th>
	<th style="text-align:right;"><?php print number_format($total_balance_am,2,'.',''); ?></th>
</tr>
</tbody>
<tfoot>
	<tr>
		<th colspan="13">

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