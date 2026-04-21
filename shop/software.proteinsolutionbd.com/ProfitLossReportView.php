<?php
include("auth.php");
include("db.php");
?>
<html>
<head>
<title>Profit/Loss Customer Wise Report >> <?php print $_GET['type']; ?></title>
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

if(!empty($_GET['CustomerID']) && $_GET['CustomerID'] !='All'){

    $CustomerID = $_GET['CustomerID'];
    $query = $conn->prepare("SELECT CONCAT(`CustomerID`,'-',`Name`,'-',`MobileNo`,'-',`Address`) AS `CustomerInfo` FROM `Customer` WHERE  `CustomerID` = '$CustomerID' "); 
    $query->execute();
    $Customer = $query->fetch();
      $CustomerInfo = $Customer['CustomerInfo'];
    }else{
       $CustomerInfo = 'All';
    }

    
    if(!empty($_GET['ItemCategory']) && $_GET['ItemCategory'] !='All'){
        $ItemCategory = $_GET['ItemCategory'];
        $query = $conn->prepare("SELECT `Name` FROM `ItemCategory` WHERE  `ItemCategoryID` = '$ItemCategory'"); 
        $query->execute();
        $ItemCategory = $query->fetch();
        $ItemCategory = $ItemCategory['Name'];
        }else{
            $ItemCategory = 'All';
        }

        
    
    if(!empty($_GET['SupplierID']) && $_GET['SupplierID'] !='All'){
        $SupplierID = $_GET['SupplierID'];
        $query = $conn->prepare("SELECT * FROM `Supplier` WHERE  `SupplierID` = '$SupplierID'"); 
        $query->execute();
        $Supplier = $query->fetch();
        $Supplier = $Supplier['Name'].' '.$Supplier['Address'] .' '.$Supplier['MobileNo'];
        }else{
            $Supplier = 'All';
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
	<th style="text-align:center; font-size:18px;">Profit/Loss Customer Wise Report
	<?php if(!empty($_GET['type'])){ ?> (<?php print $_GET['type']; ?>) <?php } ?></th>
</tr>
<tr>
	<th style="font-size:14px; text-align :left">Customer : <?php print $CustomerInfo; ?> / Item Category Name : <?php print $ItemCategory; ?>  / Supplier Name : <?php print $Supplier; ?></th>
</tr>
</table>



<?php
## Cash Memo Report Product Wise
if(!empty($_GET['type']) && ($_GET['type'] =='Product Wise') && !empty($_GET['start_date']) && !empty($_GET['end_date'])){

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
	<th style="font-size:14px; text-align :center">Statement  From: <?php print $statement_start_date = $get_start_date->format('d-m-Y');  ?> To:  <?php print $statement_end_date = $get_end_date->format('d-m-Y');  ?></th>
</tr>

</table>


<table id="table" class="table table-hover table-condensed table-striped table-bordered"  style="white-space: nowrap;">

<thead>
<tr>
	<th> S/L </th>
	<th> Date</th>
	<th> Supplier </th>
    <th>Customer </th>
	<th> Description </th>
	<th> Cash Memo </th>
	<th> Return <br> Memo </th>
	<th> Sales <br> Qty </th>
	<th> Return <br> Qty </th>
	<th> D.O. <br> Rate </th>
    <th> Sales <br> Rate </th>
    <th> Distance </th>
    <th> Profit </th>
    <th> Loss </th>
</tr>
</thead>
<tbody>
<?php 
if(!empty($_GET['CustomerID']) && $_GET['CustomerID'] =='All'){
    $CustomerID ="";
}else{
    $CustomerID =" AND A.`CustomerID` = '$_GET[CustomerID]' ";
}   


if(!empty($_GET['ItemCategoryID']) && $_GET['ItemCategoryID'] =='All'){
    $ItemCategoryID ="";
}else{
    $ItemCategoryID =" AND A.`ItemCategoryID` = '$_GET[ItemCategoryID]' ";
} 



if(!empty($_GET['SupplierID']) && $_GET['SupplierID'] =='All'){
    $SupplierID ="";
}else{
    $SupplierID =" AND A.`SupplierID` = '$_GET[SupplierID]' ";
} 



$start_date = $get_start_date->format('Y-m-d');
$end_date =  $get_end_date->format('Y-m-d');



//  DROP TABLE                              
$TableName = "TempProfitLossReport".$SessionID;
$Drop = $conn->prepare("DROP TABLE IF EXISTS `$TableName`"); 
$Drop->execute();

## CREATE TABLE 
$Create = $conn->prepare("CREATE TABLE `$TableName`  
(
`CashMemoID` INT(11) NULL,
`ChallanRate` DOUBLE NOT NULL,
`SalesRate` DOUBLE NOT NULL,
`Name` VARCHAR(300) NULL,
`Quantity` DOUBLE NOT NULL,
`ReturnQuantity` DOUBLE NOT NULL,
`PackageSize` VARCHAR(300) NULL,
`SupplierInfo` VARCHAR(300) NULL,
`CustomerInfo` VARCHAR(300) NULL,
`Date` DATE NOT NULL,
`CashMemoInvoice` VARCHAR(300) NULL,
`CashMemoReturnInvoice` VARCHAR(300) NULL,
`InvoiceType` VARCHAR(300) NULL
)
");
$Create->execute();

$CashMemo = $conn->exec("INSERT INTO `$TableName` 
SELECT 
A.`CashMemoID`,
IFNULL(A.`ChallanRate`,0) AS `ChallanRate`,
IFNULL(A.`SalesRate`,0) AS `SalesRate`,
B.`Name`,
IFNULL(A.`SalesQuantity`,0) AS `SalesQuantity`, 
'0' AS `ReturnQuantity`, 
CONCAT(C.`Thickness`,'-',C.`Size`) AS `PackageSize`,
CONCAT(D.`Name`,' - ',D.`Address`,' - ',D.`MobileNo`) AS `SupplierInfo`,
(CASE WHEN  A.`CustomerID` = '0'  THEN A.`CustomerName` ELSE CONCAT(E.`CustomerID`,'-',E.`Name`,'- ',E.`MobileNo`) END) AS `CustomerInfo`,
A.`CashMemoDate`,
A.`CashMemoInvoice`,
'' AS `CashMemoReturnInvoice`,
'Cash Memo' `InvoiceType`

FROM `CashMemo` A 
LEFT JOIN `ItemCategory` B ON (A.`ItemCategoryID` = B.`ItemCategoryID`)
LEFT JOIN `PackageSize` C ON (A.`PackageSizeID` = C.`PackageSizeID`)
LEFT JOIN `Supplier` D ON (A.`SupplierID` = D.`SupplierID`)
LEFT JOIN `Customer` E ON (A.`CustomerID` = E.`CustomerID`)

WHERE A.`Cart` = 'Yes' 
AND A.`CashMemoDate` 
BETWEEN '$start_date' 
AND '$end_date'  $CustomerID $ItemCategoryID $SupplierID
GROUP BY A.`PackageSizeID`,A.`CashMemoID` 
ORDER BY B.`Name`,A.`PackageSizeID`,A.`CashMemoInvoice` ASC ");


$CashMemoReturn = $conn->exec("INSERT INTO `$TableName` 
SELECT 
A.`CashMemoID`,
IFNULL(F.`Rate`,0) AS `ReturnRate`,
IFNULL(A.`SalesRate`,0) AS `SalesRate`,
B.`Name`,
'0' AS `SalesQuantity`, 
IFNULL(A.`ReturnQuantity`,0) AS `ReturnQuantity`, 
CONCAT(C.`Thickness`,'-',C.`Size`) AS `PackageSize`,
CONCAT(D.`Name`,' - ',D.`Address`,' - ',D.`MobileNo`) AS `SupplierInfo`,
(CASE WHEN  A.`CustomerID` = '0'  THEN A.`CustomerName` ELSE CONCAT(E.`CustomerID`,'-',E.`Name`,'- ',E.`MobileNo`) END) AS `CustomerInfo`,
A.`CashMemoReturnDate`,
A.`CashMemoInvoice`,
A.`CashMemoReturnInvoice`,
'Cash Memo Return' `InvoiceType`

FROM `CashMemoReturn` A 
LEFT JOIN `ItemCategory` B ON (A.`ItemCategoryID` = B.`ItemCategoryID`)
LEFT JOIN `PackageSize` C ON (A.`PackageSizeID` = C.`PackageSizeID`)
LEFT JOIN `Supplier` D ON (A.`SupplierID` = D.`SupplierID`)
LEFT JOIN `Customer` E ON (A.`CustomerID` = E.`CustomerID`)
LEFT JOIN `Challan` F ON (A.`ChallanID` = F.`ChallanID`)

WHERE A.`Cart` = 'Yes' 
AND A.`CashMemoReturnDate` 
BETWEEN '$start_date' 
AND '$end_date'  $CustomerID $ItemCategoryID $SupplierID
GROUP BY A.`PackageSizeID`,A.`CashMemoReturnID` 
ORDER BY B.`Name`,A.`PackageSizeID`,A.`CashMemoReturnInvoice` ASC ");


$sl =1;
$ReturnQuantity = 0;
$SalesQuantity = 0;
$NetProfit = 0;
$NetLoss = 0;

$query = $conn->prepare("SELECT 
`CashMemoID`,
`CashMemoInvoice`,
`Date`,
IFNULL(`ChallanRate`,0) AS ChallanRate,
IFNULL(`SalesRate`,0) AS SalesRate,
`Name`,
(IFNULL(`Quantity`,0)) AS `Quantity`, 
`PackageSize`,
`SupplierInfo`,
`CustomerInfo`,
(IFNULL(`ReturnQuantity`,0)) AS ReturnQuantity,
`CashMemoReturnInvoice`
FROM  $TableName
ORDER BY `Date`,`CashMemoInvoice` ASC");
$query->execute();
                
    if($query->rowCount()==0){
    print "<tr> <td colspan=20 style=\"text-align:center; color:red;\"> No matching records found. </td> </tr>";	
    }
    $fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach($fetch_list AS $fetch) { 
$Quantity = ($fetch['Quantity']);

$ProfitDistance = number_format($fetch['SalesRate'] - $fetch['ChallanRate'],2,'.','');
$ProfitCalculate = number_format($ProfitDistance * $Quantity,2,'.','');

if($ProfitCalculate > 0){
    $Profit = $ProfitCalculate;
    $Loss = 0;
}else if($fetch['ReturnQuantity'] >=1){
	$Profit = 0;
    $Loss = number_format(-$fetch['ReturnQuantity'] * $ProfitDistance,2,'.','');
}else{
    $Profit = 0;
    $Loss = $ProfitCalculate;
}

?>


<tr>
	<td><?php echo $sl++; ?> </td>
	<td style="text-align:left;"><?php print date("d-m-Y",strtotime($fetch['Date']));?></td>

    <td style="text-align:left;"><?php print wordwrap($fetch['SupplierInfo'],3, "<br>"); ?></td>
    <td style="text-align:left; color:blue;" ><?php print wordwrap($fetch['CustomerInfo'],3, "<br>"); ?></td>
    <td style="text-align:left;"><?php echo $fetch['Name']; ?> <?php echo $fetch['PackageSize']; ?> </td>
    <td style="text-align:center;" title="Click Here To Open Cash Memo Invoice">
    <a onclick="window.open('CashMemoview.php?CashMemoInvoice=<?php echo $fetch['CashMemoInvoice']; ?>',
'mywindow','menubar=1,resizable=1,width=1000,height=800');" ><?php print $fetch['CashMemoInvoice']; ?></a>
    </td>
    <td style="text-align:center;" title="Click Here To Open Return Memo Invoice">
    <a onclick="window.open('CashMemoReturnview.php?CashMemoReturnInvoice=<?php echo $fetch['CashMemoReturnInvoice']; ?>',
'mywindow','menubar=1,resizable=1,width=1000,height=800');" ><?php print $fetch['CashMemoReturnInvoice']; ?></a>
    </td>
    <td style="text-align:right;"> <?php print number_format($Quantity,2,'.',''); ?> </td>
    <td style="text-align:right;"> <?php print number_format($fetch['ReturnQuantity'],2,'.',''); ?> </td>
  
    <td style="text-align:right;"> <?php print number_format($fetch['ChallanRate'],2,'.',''); ?> </td>
    <td style="text-align:right;"> <?php print number_format($fetch['SalesRate'],2,'.',''); ?> </td>
    <td style="text-align:right;"> <?php print number_format($ProfitDistance,2,'.',''); ?> </td>
    <th style="text-align:right; <?php if($Profit >'0'){ print "color:green;"; }?>"> <?php print number_format($Profit,2,'.',''); ?> </th>
    <th style="text-align:right; <?php if($Profit < '0.1'){ print "color:red;"; }?>"> <?php print number_format($Loss,2,'.',''); ?> </th>
</tr>

<?php	
$SalesQuantity += $fetch['Quantity'];
$ReturnQuantity += $fetch['ReturnQuantity'];
$NetProfit += $Profit;
$NetLoss += $Loss;

} //while 
?>

<tr>
	<th style="text-align:center;" colspan="7"> TOTAL </th>
	<th style="text-align:right;"> <?php print number_format($SalesQuantity,2,'.',''); ?></th>
    <th style="text-align:right;"> <?php print number_format($ReturnQuantity,2,'.',''); ?></th>
	<th colspan="3">  </th>
    <th style="text-align:right;"> <?php print number_format($NetProfit,2,'.',''); ?></th>
    <th style="text-align:right;"> <?php print number_format($NetLoss,2,'.',''); ?></th>

</tr>
</tbody>
<tfoot>
	<tr>
		<th colspan=20>

            
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
	} // END 
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
			htmlToCSV(html, "Profit/Loss Customer Wise Report.csv");
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