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

    if(!empty($_GET['SupplierID']) && is_numeric($_GET['SupplierID'])){

    $SupplierID = $_GET['SupplierID'];
    $query = $conn->prepare("SELECT CONCAT(`SupplierID`,' - ',`Name`,'-',`MobileNo`) AS `sup_info` FROM `Supplier` WHERE  `SupplierID` = '$SupplierID' "); 
    $query->execute();
    $FetchSupplierID = $query->fetch();
     $SupplierInfo = $FetchSupplierID['sup_info'];

?>

<table class="table table-hover table-condensed table-striped table-bordered"  style="white-space: nowrap;">

<tr>
	<th style="text-align:center; font-size:18px;"> <?php print $company; ?> </th>
</tr>

<tr>
	<th style="text-align:center;"><?php print $c_address; ?></th>
</tr>		

<tr>
	<th style="text-align:center; font-size:18px;"> Supplier Ledger</th>
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
	<th style="font-size:14px; text-align :left">Supplier Info.: <?php print $SupplierInfo; ?> </th>
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
	<th> S/L </th>
	<th> Date </th>
	<th> Invoice </th>
	<th> Purpose </th>
	<th> Pay Mode </th>
	<th> Discount </th>
	<th> Paid Amount </th>
	<th> Receivable </th>
	<th> Payable </th>
	<th> Balance </th>
</tr>
<tr>
	<th colspan="9" style="text-align:center;"> Opening Balance / Previous  Balance </th>
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
	<td><?php echo $sl++; ?> </td>
  
	<td><?php  print date("d-m-Y",strtotime($fetch['Date'])); ?></td>
    <th style="text-align:center;" title="Click Here To Open Invoice">

<?php if($fetch['InvoiceType']=='Purchase'){ ?>

    <a onclick="window.open('ChallanInvoice.php?ChallanInvoice=<?php echo $fetch['Invoice']; ?>',
'mywindow','menubar=1,resizable=1,width=900,height=800');" ><?php echo $fetch['Invoice']; ?></a>

<?php }else if($fetch['InvoiceType']=='Purchase Return'){ ?>

<a onclick="window.open('ChallanReturnInvoice.php?ChallanReturnInvoice=<?php echo $fetch['Invoice']; ?>',
'mywindow','menubar=1,resizable=1,width=900,height=800');" ><?php echo $fetch['Invoice']; ?></a>

<?php }else if($fetch['InvoiceType']=='Supplier Payment'){ ?>
<a onclick="window.open('payment_Invoice.php?Invoice=<?php echo $fetch['Invoice']; ?>',
'mywindow','menubar=1,resizable=1,width=900,height=800');" ><?php echo $fetch['Invoice']; ?></a>

<?php
}
?>
    </th>
    <td style="text-align:center;"> <?php print $fetch['InvoiceType']; ?> </td>
    <td style="text-align:center;"> <?php print $fetch['PaymentType']; ?> </td>
    <td style="text-align:right;"> <?php print number_format($fetch['Discount'],2,'.',''); ?> </td>
    <td style="text-align:right;"> <?php print number_format($fetch['PaidAmount'],2,'.',''); ?> </td>
    <td  style="text-align:right;background-color:#47d147;"> <?php print number_format($fetch['Receivable'],2,'.',''); ?> </td>
    <td  style="text-align:right;background-color:#ff4d4d;"> <?php print number_format($fetch['Payable'] + $fetch['Discount'],2,'.',''); ?> </td>
    <th style="text-align:right; color:<?php if($Balance + $PreviousBalance <='0'){ print "green";}else{ print "red"; } ?>"> <?php print number_format($Balance + $PreviousBalance,2,'.',''); ?> </th>
   
</tr>

<?php	
$Balance = $Balance;

$PaidAmount += $fetch['PaidAmount'];
$Discount += $fetch['Discount'];
$Receivable += $fetch['Receivable'];
$Payable += $fetch['Payable'];

} //while 
?>

<tr>
	<th style="text-align:center;" colspan="4"> TOTAL </th>
	<th></th>
	<th style="text-align:right;"> <?php print number_format($Discount,2,'.',''); ?></th>
	<th style="text-align:right;"> <?php print number_format($PaidAmount,2,'.',''); ?></th>
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

}else{
?>


<table class="table table-hover table-condensed table-striped table-bordered"  style="white-space: nowrap;">

<tr>
	<th style="text-align:center; font-size:18px;"> <?php print $company; ?> </th>
</tr>

<tr>
	<th style="text-align:center;"><?php print $c_address; ?></th>
</tr>		

<tr>
	<th style="text-align:center; font-size:18px;"> Supplier Balance Summary(<?php print $_GET['SupplierID']; ?>)</th>
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



</table>

<?php

$start_date = $get_start_date->format('Y-m-d');
$end_date =  $get_end_date->format('Y-m-d');
$TableName = "temp_supplier_ledger".$SessionID;
$query = $conn->prepare("DROP TABLE IF EXISTS `$TableName`"); 
$query->execute();

## CREATE TABLE 
$create = $conn->prepare("CREATE TABLE `$TableName`  
(
`ID` INT(75) NULL,
`Date` DATE NOT NULL,
`Time` VARCHAR(125) NULL,
`SupplierID` INT(11) NULL,
`Invoice` VARCHAR(125) NULL,
`InvoiceType` VARCHAR(125) NULL,
`InvoiceAmoint` DOUBLE NULL,
`PaidAmount` DOUBLE NULL,
`Discount`DOUBLE NULL,
`Receivable` DOUBLE NULL,
`Payable` DOUBLE NULL,
`PaymentType` VARCHAR(125) NULL,
`Creator` INT(11) NULL
)
");
$create->execute();

//Purchase
$Purchase = $conn->exec("INSERT INTO `$TableName` 
SELECT 
        `ChallanID`,
        `ChallanDate`,
        `CreateDate` AS `ChallanTime`,
        `SupplierID`,
        `ChallanInvoice`,
        'Purchase' AS `InvoiceType`,
        '' AS `InvoiceAmoint`, 
        '0' AS `PaidAmount`,
        '0' AS `Discount`,
        SUM(`Amount`) AS `Receivable`,
        '0' AS `Payable`,
        '' AS `PaymentType`, 
        `EntryID` 
    FROM `Challan` WHERE  `Cart` = 'Yes' AND `ChallanDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' GROUP BY `ChallanInvoice`");

//Purchase Return
$PurchaseReturn = $conn->exec("INSERT INTO `$TableName` 
SELECT 
        `ChallanReturnID`,
        `ChallanReturnDate`,
        `CreateDate` AS `ChallanTime`,
        `SupplierID`,
        `ChallanReturnInvoice`,
        'Purchase Return' AS `InvoiceType`,
        '' AS `InvoiceAmoint`, 
        '0' AS `PaidAmount`,
        '0' AS `Discount`,
        '0' AS `Receivable`,
        SUM(`ReturnAmount`) AS `Payable`,
        '' AS `PaymentType`, 
        `EntryID` 
    FROM `ChallanReturn` WHERE  `Cart` = 'Yes' AND `ChallanReturnDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' GROUP BY `ChallanReturnInvoice`");

//Payment
$payment = $conn->exec("INSERT INTO `$TableName` 
SELECT 
    `PaymentID`,
    `PaymentDate`,
    `CreateDate` AS `PaymentTime`,
    `SupplierID`,
    `SupplierPaymentInvoice`,
    'Supplier Payment' AS `InvoiceType`, 
    '0' AS `InvoiceAmoint`, 
    `PaymentAmount` AS `PaidAmount`,
    `PaymentDiscount` AS `Discount`,
    '0' AS `Receivable`,
    `PaymentAmount` AS `Payable`, 
    `PaymentName` AS `PaymentType`, 
    `EntryID` 
FROM `Payment` WHERE  `PaymentDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' GROUP BY `SupplierPaymentInvoice` ");

?>

<table id="table" class="table table-hover table-condensed table-striped table-bordered"  style="white-space: nowrap;">

<thead>
<tr>
	<th> S/L </th>
	<th> Supplier Info. </th>
	<th> Opening </th>
	<th> Receive </th>
	<th> Payment </th>
	<th>Receivable Balance </th>
	<th>Payable Balance </th>
</tr>

</thead>
<tbody>
	
<?php 
$sl =1;
$Balance = 0;
$pre_Balance = 0;
$total_Receivable = 0;
$total_Payable = 0;
$GNetReceivable = 0;
$GNetPayable = 0;

//previus Date
$pdate = date('Y-m-d', strtotime('-1 day', strtotime($start_date)));
$query = $conn->prepare("SELECT 
A.`SupplierID`,
CONCAT(A.`SupplierID`,' - ',A.`Name`,'-',A.`MobileNo`) AS `SupplierInfo`,
IFNULL(A.`OpeningBalance`,0) AS `OpeningBalance`,

(IFNULL(B.`pre_Payable`,0) - IFNULL(B.`pre_Receivable`,0) + IFNULL(B.`pre_Discount`,0)) AS `pre_Balance`,

IFNULL(B.`Receivable`,0) AS `Receivable`,
IFNULL(B.`Payable`,0) AS `Payable`,
IFNULL(B.`Discount`,0) AS `Discount`,
(IFNULL(B.`Payable`,0) - IFNULL(B.`Receivable`,0) + IFNULL(B.`Discount`,0)) AS `Balance`
 FROM `Supplier` A 
 LEFT JOIN (SELECT
    `SupplierID`,
    SUM(CASE WHEN  `date` BETWEEN '".$i3_define_date."' AND '".$pdate."' THEN `Receivable` ELSE 0 END) `pre_Receivable`,
	SUM(CASE WHEN  `date` BETWEEN '".$i3_define_date."' AND '".$pdate."' THEN `Payable` ELSE 0 END) `pre_Payable`,

	SUM(CASE WHEN  `date` BETWEEN '".$i3_define_date."' AND '".$pdate."' THEN `Discount` ELSE 0 END) `pre_Discount`,

	SUM(CASE WHEN  `date` BETWEEN '".$start_date."' AND '".$end_date."' THEN `Receivable` ELSE 0 END) `Receivable`,


	SUM(CASE WHEN  `date` BETWEEN '".$start_date."' AND '".$end_date."' THEN `Discount` ELSE 0 END) `Discount`,

	SUM(CASE 
	WHEN  `date` BETWEEN  '".$start_date."' AND '".$end_date."' THEN (IFNULL(`Payable`,0)) 
	ELSE 0
	END ) `Payable`

  FROM `$TableName` GROUP BY `SupplierID`  ) B ON (A.`SupplierID` = B.`SupplierID`)
 GROUP BY A.`SupplierID` 
 ORDER BY A.`SupplierID` ASC
 ");
$query->execute();
                
    if($query->rowCount()==0){
    print "<tr> <td colspan=10 style=\"text-align:center; color:red;\"> No matching records found. </td> </tr>";	
    }
    $fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach($fetch_list AS $fetch) { 

	$Receivable = $fetch['Receivable'];
	$Discount = abs($fetch['Discount']);
	$Payable = abs($fetch['Payable']);

if($fetch['OpeningBalance'] >= 0 ){
    $Balance = number_format( $fetch['OpeningBalance'] + ($fetch['pre_Balance'] + $fetch['Balance']) ,2,'.','');
}else{
    $Balance = number_format( ($fetch['pre_Balance'] + $fetch['Balance']) + $fetch['OpeningBalance'],2,'.','');
}


if($Balance !=0){

	if($Balance <='0'){ 
		$NetReceivable = abs($Balance);
		$NetPayable = 0;
	}else{
		$NetReceivable = 0;
		$NetPayable = $Balance;
	} 
?>


<tr>
	<td><?php echo $sl++; ?></td>

    <td style="text-align:left;" title="Click Here to Open ledger"> <a href="SupplierLedgerView.php?SupplierID=<?php print $fetch['SupplierID']; ?>&start_date=<?php print $_GET['start_date']; ?>&end_date=<?php print $_GET['end_date']; ?>" style="text-decoration: none;"><?php print $fetch['SupplierInfo']; ?> </a></td>
    <td style="text-align:right;"> <?php print number_format($fetch['pre_Balance']+$fetch['OpeningBalance'],2,'.',''); ?> </td>
    <td style="text-align:right;"> <?php print number_format($Receivable,2,'.',''); ?> </td>
    <td style="text-align:right;"> <?php print number_format($Payable,2,'.',''); ?> </td>
	<?php if($Balance <='0'){ ?>
		<th></th>
	<th style="text-align:right; color: green;"> <?php print abs(number_format($NetReceivable,2,'.','')); ?> </th>

	<?php }else{ ?>

	<th style="text-align:right; color: red;"> <?php print number_format($NetPayable,2,'.',''); ?> </th>	
	<th></th>
	<?php } ?>
   
</tr>

<?php	
$Balance = $Balance;
$pre_Balance += $fetch['pre_Balance'];
$total_Receivable += $Receivable;
$total_Payable += $Payable;
$GNetReceivable += $NetReceivable;
$GNetPayable += $NetPayable;
}
} //while 
?>

<tr>
	<th style="text-align:center;" colspan="2"> TOTAL </th>
	<th style="text-align:right;"> <?php print number_format($pre_Balance + $Balance,2,'.',''); ?></th>
	<th style="text-align:right;"> <?php print number_format($total_Receivable,2,'.',''); ?></th>
	<th style="text-align:right;"> <?php print number_format($total_Payable,2,'.',''); ?></th>
    <th style="text-align:right;"> <?php print number_format($GNetPayable,2,'.',''); ?></th>
	<th style="text-align:right;"> <?php print number_format($GNetReceivable,2,'.',''); ?></th>
</tr>
<tr>
	<th style="text-align:center;" colspan="5"> Grand Total </th>
	<th style="text-align:center;" colspan="2"> <?php print number_format($GNetPayable - $GNetReceivable,2,'.',''); ?></th>
</tr>
</tbody>
<tfoot>
	<tr>
		<th colspan=9>

            
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