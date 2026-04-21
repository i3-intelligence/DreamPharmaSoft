<?php
include("auth.php");
include("db.php");
?>
<html>
<head>
<title>Customer Ledger</title>
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

    if(!empty($_GET['CustomerID']) && is_numeric($_GET['CustomerID'])){

    $CustomerID = $_GET['CustomerID'];
    $query = $conn->prepare("SELECT CONCAT(`CustomerID`,' - ',`Name`,'-',`MobileNo`) AS `sup_info` FROM `Customer` WHERE  `CustomerID` = '$CustomerID' "); 
    $query->execute();
    $FetchCustomerID = $query->fetch();
     $CustomerInfo = $FetchCustomerID['sup_info'];

?>

<table class="table table-hover table-condensed table-striped table-bordered"  style="white-space: nowrap;">

<tr>
	<th style="text-align:center; font-size:18px;"> <?php print $company; ?> </th>
</tr>

<tr>
	<th style="text-align:center;"><?php print $c_address; ?></th>
</tr>		

<tr>
	<th style="text-align:center; font-size:18px;"> Customer Ledger Detalis</th>
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
	<th style="font-size:14px; text-align :center">Statement  From: <?php print $statement_start_date = $get_start_date->format('d-m-Y');  ?> To:  <?php print $statement_end_date = $get_end_date->format('d-m-Y');  ?></th>
</tr>

<tr>
	<th style="font-size:14px; text-align :left">Customer Info.: <?php print $CustomerInfo; ?> </th>
</tr>

</table>

<?php
$CustomerID = $_GET['CustomerID'];

$start_date = $get_start_date->format('Y-m-d');
$end_date =  $get_end_date->format('Y-m-d');

include("CustomerLedgerCall.php");

?>
<table id="table" class="table table-hover table-condensed table-striped table-bordered"  style="white-space: nowrap;">

<thead>
<tr>
	<th> Date </th>
	<th> Details </th>
	<th> Receivable </th>
	<th> Payable </th>
	<th> Balance </th>
</tr>

</thead>
<tbody>
<tr>
	<th colspan="4" style="text-align:center;"> Opening Balance / Previous  Balance </th>
	<th style="text-align:right;"> <?php print $PreviousBalance; ?> </th>
</tr>
<?php 

$sl =1;
$balance = 0;
$Receivable = 0;
$Payable = 0;
$Discount = 0;
$InvoiceAmount = 0;
$ReceiveAmount = 0;
$PaidAmount = 0;
$query = $conn->prepare("SELECT 
		`Date`,
		`InvoiceType`,
		`Invoice`,
		`InvoiceAmount`,
		`PaymentType`,
		`Remarks`,
		`ReceiveAmount`,
		`PaidAmount`,
		`Discount`,
		(CASE 
		WHEN  `InvoiceType` = 'Cash Memo' THEN IFNULL(`Receivable`,0) 
		WHEN  `InvoiceType` = 'Cash Memo Return' THEN IFNULL(`Receivable`,0) 
		WHEN  `InvoiceType` = 'Customer Receive' THEN IFNULL(`Receivable`,0) 
		ELSE 0
		END ) AS `Receivable` ,

		(CASE 
		WHEN  `InvoiceType` = 'Cash Memo' THEN IFNULL(`Payable`,0) 
		WHEN  `InvoiceType` = 'Cash Memo Return' THEN IFNULL(`Payable`,0)
		WHEN  `InvoiceType` = 'Customer Due' THEN IFNULL(`Payable`,0)
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
          $dr =($fetch['Receivable'] + $fetch['Discount']);
			$balance -= $dr;
		  }

		  if ($fetch['Payable']){ 
          $cr =($fetch['Payable']  - $fetch['Discount']);
			$balance += $cr;
		  }
?>


<tr>
	<td><?php  print date("d-m-Y",strtotime($fetch['Date'])); ?></td>
    <td>
     
<?php if($fetch['InvoiceType']=='Cash Memo'){ ?>
<table>
<tr>
<th colspan="4">
Cash Memo :
<a onclick="window.open('CashMemoview.php?CashMemoInvoice=<?php echo $fetch['Invoice']; ?>',
'mywindow','menubar=1,resizable=1,width=900,height=800');" ><?php echo $fetch['Invoice']; ?></a>
</th>
</tr>
<tr>
    <th>Description</th>
    <th>Qty</th>
    <th>Unit Price</th>
    <th>Total</th>
</tr>
        
		  
<?php
$sl=1;
$SalesAmount = 0;
$QueryInvoiceData = $conn->prepare("SELECT 
        A.*,
        B.`Name` AS `ItemCategory`,
        C.`Thickness`,
        C.`Size`,
		D.`ColorCode`
FROM `CashMemo` A 
LEFT JOIN `ItemCategory` B ON (A.`ItemCategoryID` = B.`ItemCategoryID`)
LEFT JOIN `PackageSize` C ON (A.`PackageSizeID` = C.`PackageSizeID`)
LEFT JOIN `Supplier` D ON (A.`SupplierID` = D.`SupplierID`)
WHERE A.`CashMemoInvoice`='$fetch[Invoice]' ORDER BY `CashMemoID` ASC ");
$QueryInvoiceData->execute();
$FetchInvoice = $QueryInvoiceData->FetchAll(PDO::FETCH_ASSOC);
foreach($FetchInvoice AS $Fetch) {
?>		  
		  
		  <tr style="color:<?php print $Fetch['ColorCode']; ?>">
		      <td class="description" ><?php print $Fetch['ItemCategory']; ?> &times;  <?php print $Fetch['Thickness']; ?>&times; <?php print $Fetch['Size']; ?></td>
              
		      <td style="text-align:right;"><?php print $Fetch['SalesQuantity']; ?></td>
		      <td style="text-align:right;"><?php print $Fetch['SalesRate']; ?></td>
		      <td style="text-align:right;"><span class="price">  <?php print $Fetch['SalesAmount']; ?> </span></td>
		  </tr>
		  
<?php  
$SalesAmount += $Fetch['SalesAmount'];
} // WHILE ?>	
<tr>
    <th colspan="3" style="text-align:right;">Total</th>
    <th style="text-align:right;"><?php print number_format($SalesAmount,2,'.',''); ?></th>
</tr>
<tr>
	<td colspan="4">Remarks : <?php echo wordwrap($fetch['Remarks'],30,"<br>"); ?></td>
</tr>
</table>

<?php }else if($fetch['InvoiceType']=='Cash Memo Return'){ ?>
    <table>
<tr>
<th colspan="4">
Cash Memo Return:
<a onclick="window.open('CashMemoReturnview.php?CashMemoReturnInvoice=<?php echo $fetch['Invoice']; ?>',
'mywindow','menubar=1,resizable=1,width=900,height=800');" ><?php echo $fetch['Invoice']; ?></a>
</th>
</tr>
<tr>
    <th>Description</th>
    <th>Qty</th>
    <th>Unit Price</th>
    <th>Total</th>
</tr>
        
		  
<?php
$sl=1;
$CashMemoReturnAmount = 0;
$QueryInvoiceData2 = $conn->prepare("SELECT 
        A.*,
        B.`Name` AS `ItemCategory`,
        C.`Thickness`,
        C.`Size`
FROM `CashMemoReturn` A 
LEFT JOIN `ItemCategory` B ON (A.`ItemCategoryID` = B.`ItemCategoryID`)
LEFT JOIN `PackageSize` C ON (A.`PackageSizeID` = C.`PackageSizeID`)
WHERE A.`CashMemoReturnInvoice`='$fetch[Invoice]' ORDER BY `CashMemoReturnID` ASC ");
$QueryInvoiceData2->execute();
$FetchInvoiceReturn = $QueryInvoiceData2->FetchAll(PDO::FETCH_ASSOC);
foreach($FetchInvoiceReturn AS $Fetch2) {
?>		  
		  
		  <tr style="color:blue;">
		      <td class="description"><?php print $Fetch2['ItemCategory']; ?> &times;  <?php print $Fetch2['Thickness']; ?>&times; <?php print $Fetch2['Size']; ?></td>
              
		      <td style="text-align:right;"><?php print $Fetch2['ReturnQuantity']; ?></td>
		      <td style="text-align:right;"><?php print $Fetch2['ReturnRate']; ?></td>
		      <td style="text-align:right;"><span class="price"> <?php print $Fetch2['ReturnAmount']; ?> </span></td>
		  </tr>
<?php  
$CashMemoReturnAmount += $Fetch2['ReturnAmount'];
} // WHILE ?>	
<tr>
    <th colspan="3" style="text-align:right;">Total</th>
    <th style="text-align:right;"><?php print number_format($CashMemoReturnAmount,2,'.',''); ?></th>
</tr>
<tr>
	<td colspan="4">Remarks : <?php echo wordwrap($fetch['Remarks'],30,"<br>"); ?></td>
</tr>
</table>

<?php }else if($fetch['InvoiceType']=='Customer Due'){ ?>
    <a onclick="window.open('CustomerDueReceiveView.php?CustomerDueReceiveInvoice=<?php echo $fetch['Invoice']; ?>',
'mywindow','menubar=1,resizable=1,width=900,height=800');" ><?php echo $fetch['Invoice']; ?></a>

<br> Remarks : <?php echo wordwrap($fetch['Remarks'],30,"<br>"); ?>
<?php }else if($fetch['InvoiceType']=='Customer Receive'){ ?>
    <a onclick="window.open('CustomerReceiveView.php?CustomerReceiveInvoice=<?php echo $fetch['Invoice']; ?>',
'mywindow','menubar=1,resizable=1,width=900,height=800');" ><?php echo $fetch['Invoice']; ?></a>
<br> Remarks : <?php echo wordwrap($fetch['Remarks'],30,"<br>"); ?>
<?php
}
?>
    </td>
   
    <td style="text-align:right; background-color:#47d147;"> <?php print number_format($fetch['Receivable'] + $fetch['Discount'],2,'.',''); ?> </td>
    <td style="text-align:right;background-color:#ff4d4d;"> <?php print number_format($fetch['Payable'],2,'.',''); ?> </td>
    <th style="text-align:right; color:<?php if($balance + $PreviousBalance <='0'){ print "green";}else{ print "red"; } ?>"> <?php print number_format($balance + $PreviousBalance,2,'.',''); ?> </th>
   
</tr>

<?php	
$balance = $balance;
$Receivable += $fetch['Receivable'];
$Payable += $fetch['Payable'];

} //while 
?>

<tr>
	<th style="text-align:center;" colspan="2"> TOTAL </th>
	<th style="text-align:right;"> <?php print number_format($Receivable+$Discount,2,'.',''); ?></th>
	<th style="text-align:right;"> <?php print number_format($Payable,2,'.',''); ?></th>
	<th style="text-align:right;"> <?php print number_format($PreviousBalance + $balance,2,'.',''); ?></th>
</tr>
<!-- <tr> 
		<th colspan="12">

            
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
		</tr> -->
</tbody>
<tfoot>
	
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
			htmlToCSV(html, "Customer Ledger.csv");
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