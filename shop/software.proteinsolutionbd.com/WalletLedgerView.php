<?php
include("auth.php");
include("db.php");
?>
<html>
<head>
<title>Wallet Ledger</title>
<script src="1.5.1jquery.min.js"></script>
<link rel="stylesheet" href="dist/css/bootstrap.min.css">
<!-- start: Favicon -->
<link rel="shortcut icon" href="img/favicon.ico">
<!-- end: Favicon -->
<style>
body{
margin:2px;
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

    if(!empty($_GET['WalletID']) && is_numeric($_GET['WalletID'])){

    $WalletID = $_GET['WalletID'];
    $query = $conn->prepare("SELECT CONCAT(`WalletID`,' - ',`Name`) AS `WalletInfo` FROM `Wallet` WHERE  `WalletID` = '$WalletID' "); 
    $query->execute();
    $FetchWalletID = $query->fetch();
     $WalletInfo = $FetchWalletID['WalletInfo'];

?>

<table class="table table-hover table-condensed table-striped table-bordered"  style="white-space: nowrap;">

<tr>
	<th style="text-align:center; font-size:18px;"> <?php print $company; ?> </th>
</tr>

<tr>
	<th style="text-align:center;"><?php print $c_address; ?></th>
</tr>		

<tr>
	<th style="text-align:center; font-size:18px;"> Wallet Ledger</th>
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
	<th style="font-size:14px; text-align :left">Wallet Info.: <?php print $WalletInfo; ?> </th>
</tr>

</table>

<?php
$WalletID = $_GET['WalletID'];

$start_date = $get_start_date->format('Y-m-d');
$end_date =  $get_end_date->format('Y-m-d');

include("WalletLedgerCall.php");

?>
<table id="table" class="table table-hover table-condensed table-striped table-bordered"  style="white-space: nowrap;">

<thead>
<tr>
	<th> S/L </th>
	<th> Date </th>
	<th> Time </th>
	<th> Invoice </th>
	<th> Purpose </th>
	<th> Receivable </th>
	<th> Payable </th>
	<th> Balance </th>
</tr>
<tr>
	<th colspan="7" style="text-align:center;"> Opening Balance / Previous  Balance </th>
	<th style="text-align:right;"> <?php print $PreviousBalance; ?> </th>
</tr>
</thead>
<tbody>
	
<?php 

$sl =1;
$balance = 0;
$Receivable = 0;
$Payable = 0;

if($start_date == $end_date){
	$query = $conn->prepare("SELECT 
	`Date`,
	`time`,
	`InvoiceType`,
	`Invoice`,
	`PaymentType`,
	`Title`,
	`Remarks`,
	(CASE 
	WHEN  `InvoiceType` = 'Cash Memo' THEN IFNULL(`Receivable`,0) 
	WHEN  `InvoiceType` = 'Customer Receive' THEN IFNULL(`Receivable`,0) 
	ELSE 0
	END ) AS `Receivable` ,

	(CASE 
	WHEN  `InvoiceType` = 'Cash Memo Return' THEN IFNULL(`Payable`,0) 
	WHEN  `InvoiceType` = 'Supplier Payment' THEN IFNULL(`Payable`,0) 
	WHEN  `InvoiceType` = 'Customer Due' THEN IFNULL(`Payable`,0) 
	ELSE 0
	END ) AS `Payable` 

	FROM `$TableName` 
	WHERE `date` BETWEEN '".$start_date."' AND '".$end_date."'
	GROUP BY `Invoice`,`InvoiceType` ORDER BY `InvoiceType` ASC");
$query->execute();

}else{
	$query = $conn->prepare("SELECT 
	`Date`,
	`time`,
	`InvoiceType`,
	`Invoice`,
	`PaymentType`,
	`Title`,
	`Remarks`,
	(CASE 
	WHEN  `InvoiceType` = 'Cash Memo' THEN IFNULL(`Receivable`,0) 
	WHEN  `InvoiceType` = 'Customer Receive' THEN IFNULL(`Receivable`,0) 
	ELSE 0
	END ) AS `Receivable` ,

	(CASE 
	WHEN  `InvoiceType` = 'Cash Memo Return' THEN IFNULL(`Payable`,0) 
	WHEN  `InvoiceType` = 'Supplier Payment' THEN IFNULL(`Payable`,0) 
	WHEN  `InvoiceType` = 'Customer Due' THEN IFNULL(`Payable`,0) 
	ELSE 0
	END ) AS `Payable` 

	FROM `$TableName` 
	WHERE `date` BETWEEN '".$start_date."' AND '".$end_date."'
	GROUP BY `Invoice`,`InvoiceType` ORDER BY `date`,`time` ASC");
$query->execute();

}

                
    if($query->rowCount()==0){
    print "<tr> <td colspan=13 style=\"text-align:center; color:red;\"> No matching records found. </td> </tr>";	
    }
    $fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach($fetch_list AS $fetch) { 


		  if ($fetch['Receivable']){ 
			$dr =($fetch['Receivable'] );
			$balance += $dr;
		  }

		  if ($fetch['Payable']){ 
			$cr =($fetch['Payable']);
			$balance -= $cr;
		  }
?>


<tr>
	<td><?php echo $sl++; ?> </td>
  
	<td><?php  print date("d-m-Y",strtotime($fetch['Date'])); ?></td>
	<td><?php  print date("h:i:s a",strtotime($fetch['time'])); ?></td>
    <th style="text-align:center;" title="Click Here To Open Invoice">

<?php if($fetch['InvoiceType']=='Cash Memo'){ ?>

    <a onclick="window.open('CashMemoview.php?CashMemoInvoice=<?php echo $fetch['Invoice']; ?>',
'mywindow','menubar=1,resizable=1,width=900,height=800');" ><?php echo $fetch['Invoice']; ?></a>

<?php }else if($fetch['InvoiceType']=='Customer Receive'){ ?>

<a onclick="window.open('CustomerReceiveView.php?CustomerReceiveInvoice=<?php echo $fetch['Invoice']; ?>',
'mywindow','menubar=1,resizable=1,width=900,height=800');" ><?php echo $fetch['Invoice']; ?></a>

<?php }else if($fetch['InvoiceType']=='Customer Due'){ ?>
<a onclick="window.open('CustomerDueReceiveView.php?CustomerDueReceiveInvoice=<?php echo $fetch['Invoice']; ?>',
'mywindow','menubar=1,resizable=1,width=900,height=800');" ><?php echo $fetch['Invoice']; ?></a>

<?php }else if($fetch['InvoiceType']=='Cash Memo Return'){ ?>
<a onclick="window.open('payment_Invoice.php?Invoice=<?php echo $fetch['Invoice']; ?>',
'mywindow','menubar=1,resizable=1,width=900,height=800');" ><?php echo $fetch['Invoice']; ?></a>


<?php }else if($fetch['InvoiceType']=='Supplier Payment'){ ?>
<a onclick="window.open('SupplierPaymentView.php?SupplierPaymentInvoice=<?php echo $fetch['Invoice']; ?>',
'mywindow','menubar=1,resizable=1,width=900,height=800');" ><?php echo $fetch['Invoice']; ?></a>

<?php
}
?>
    </th>
    <td style="text-align:left;"> <b><?php print $fetch['InvoiceType']; ?></b> <br> <?php print wordwrap($fetch['Title'], 10, "</br>"); ?>
	<br><b>Remarks:</b> <?php print wordwrap($fetch['Remarks'], 10, "</br>"); ?> </td>

    <td style="text-align:right; background-color:#47d147;"> <?php print number_format($fetch['Receivable'],2,'.',''); ?> </td>
    <td style="text-align:right;background-color:#ff4d4d;"> <?php print number_format($fetch['Payable'],2,'.',''); ?> </td>
    <th style="text-align:right; color:<?php if($balance >='0'){ print "green";}else{ print "red"; } ?>"> <?php print number_format($balance + $PreviousBalance,2,'.',''); ?> </th>
   
</tr>

<?php	
$balance = $balance;
$Receivable += $fetch['Receivable'];
$Payable += $fetch['Payable'];

} //while 
?>

<tr>
	<th style="text-align:center;" colspan="4"> TOTAL </th>
	<th></th>
	<th style="text-align:right;"> <?php print number_format($Receivable,2,'.',''); ?></th>
	<th style="text-align:right;"> <?php print number_format($Payable,2,'.',''); ?></th>
	<th style="text-align:right;"> <?php print number_format($PreviousBalance + $balance,2,'.',''); ?></th>
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
	<th style="text-align:center; font-size:18px;"> Wallet Balance Summary(<?php print $_GET['WalletID']; ?>)</th>
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
$TableName = "temp_Wallet_ledger".$SessionID;
$query = $conn->prepare("DROP TABLE IF EXISTS `$TableName`"); 
$query->execute();

## CREATE TABLE 
$create = $conn->prepare("CREATE TABLE `$TableName`  
(
`ID` INT(75) NULL,
`Date` DATE NOT NULL,
`Time` VARCHAR(125) NULL,
`WalletID` INT(11) NULL,
`Invoice` VARCHAR(125) NULL,
`InvoiceType` VARCHAR(125) NULL,
`Receivable` DOUBLE NULL,
`Payable` DOUBLE NULL,
`PaymentType` VARCHAR(125) NULL,
`Creator` INT(11) NULL
)
");
$create->execute();

//Cash Memo
$CashMemo = $conn->exec("INSERT INTO `$TableName` 
SELECT 
        `CashMemoID`,
        `CashMemoDate`,
        `CreateDate` AS `CashMemoTime`,
        `WalletID`,
        `CashMemoInvoice`,
        'Cash Memo' AS `InvoiceType`,
        (`ReceiveAmount`) AS `Receivable`,
        '0' AS `Payable`,
        '' AS `PaymentType`, 
        `EntryID` 
    FROM `CashMemo` WHERE  `Cart` = 'Yes' AND `CashMemoDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' GROUP BY `CashMemoInvoice`");

//Cash Memo Return
$CashMemoReturn = $conn->exec("INSERT INTO `$TableName` 
SELECT 
        `CashMemoReturnID`,
        `CashMemoReturnDate`,
        `CreateDate` AS `CashMemoTime`,
        `WalletID`,
        `CashMemoReturnInvoice`,
        'Cash Memo Return' AS `InvoiceType`,
        '0' AS `Receivable`,
        `PaymentAmount` AS `Payable`,
        '' AS `PaymentType`, 
        `EntryID` 
    FROM `CashMemoReturn` WHERE  `Cart` = 'Yes' AND `CashMemoReturnDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' GROUP BY `CashMemoReturnInvoice`");

//CustomerReceive
$CustomerReceive = $conn->exec("INSERT INTO `$TableName` 
SELECT 
    `ReceiveID`,
    `ReceiveDate`,
    `CreateDate` AS `ReceiveTime`,
    `WalletID`,
    `CustomerReceiveInvoice`,
    'Customer Receive' AS `InvoiceType`, 
    `ReceiveAmount` AS `Receivable`,
    '0' AS `Payable`, 
    '' AS `ReceiveType`, 
    `EntryID` 
FROM `Receive` WHERE  `ReceiveDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' AND `CustomerReceiveInvoice` != '' GROUP BY `CustomerReceiveInvoice` ");


//CustomerDueReceive
$CustomerDueReceive = $conn->exec("INSERT INTO `$TableName` 
SELECT 
    `ReceiveID`,
    `ReceiveDate`,
    `CreateDate` AS `ReceiveTime`,
    `WalletID`,
    `CustomerDueReceiveInvoice`,
    'Customer Due' AS `InvoiceType`, 
    '0' AS `Receivable`,
    `ReceiveAmount` AS `Payable`, 
    '' AS `ReceiveType`, 
    `EntryID` 
FROM `Receive` WHERE  `ReceiveDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' AND `CustomerDueReceiveInvoice` != '' GROUP BY `CustomerDueReceiveInvoice` ");


//Supplier Payment
$SupplierPayment = $conn->exec("INSERT INTO `$TableName` 
SELECT 
    `PaymentID`,
    `PaymentDate`,
    `CreateDate` AS `PaymentTime`,
    `WalletID`,
    `SupplierPaymentInvoice`,
    'Supplier Payment' AS `InvoiceType`, 
    '0' AS `Receivable`,
    `PaymentAmount` AS `Payable`, 
    '' AS `PaymentType`, 
    `EntryID` 
FROM `Payment` WHERE  `PaymentDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' AND `SupplierPaymentInvoice` != '' GROUP BY `SupplierPaymentInvoice` ");


?>

<table id="table" class="table table-hover table-condensed table-striped table-bordered"  style="white-space: nowrap;">

<thead>
<tr>
	<th> S/L </th>
	<th> Wallet Info. </th>
	<th> Opening </th>
	<th> Receive </th>
	<th> Payment </th>
	<th> Balance </th>
</tr>

</thead>
<tbody>
	
<?php 
$sl =1;
$balance = 0;
$pre_balance = 0;
$total_Receivable = 0;
$total_Payable = 0;
$total_balance = 0;

//previus Date
$pdate = date('Y-m-d', strtotime('-1 day', strtotime($start_date)));
$query = $conn->prepare("SELECT 
A.`WalletID`,
CONCAT(A.`WalletID`,' - ',A.`Name`) AS `WalletInfo`,
((IFNULL(A.`OpeningBalance`,0) + IFNULL(B.`pre_Receivable`,0)) - (IFNULL(B.`pre_Payable`,0))) `pre_balance`,
IFNULL(B.`Receivable`,0) AS `Receivable`,
IFNULL(B.`Payable`,0) AS `Payable`,
((IFNULL(B.`Receivable`,0)) - (IFNULL(B.`Payable`,0))) `balance`

 FROM `Wallet` A 
 LEFT JOIN (SELECT
    `WalletID`,
    SUM(CASE WHEN  `date` BETWEEN '".$i3_define_date."' AND '".$pdate."' THEN `Receivable` ELSE 0 END) `pre_Receivable`,

	SUM(CASE 
		WHEN  `date` BETWEEN  '".$i3_define_date."' AND '".$pdate."' THEN (IFNULL(`Payable`,0)) 
		ELSE 0
		END ) `pre_Payable`, 
	SUM(CASE WHEN  `date` BETWEEN '".$start_date."' AND '".$end_date."' THEN `Receivable` ELSE 0 END) `Receivable`,
	SUM(CASE 
	WHEN  `date` BETWEEN  '".$start_date."' AND '".$end_date."' THEN (IFNULL(`Payable`,0)) 
	ELSE 0
	END ) `Payable`

  FROM `$TableName` GROUP BY `WalletID`  ) B ON (A.`WalletID` = B.`WalletID`)
 GROUP BY A.`WalletID` 
 ORDER BY A.`WalletID` ASC
 ");
$query->execute();
                
    if($query->rowCount()==0){
    print "<tr> <td colspan=10 style=\"text-align:center; color:red;\"> No matching records found. </td> </tr>";	
    }
    $fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach($fetch_list AS $fetch) { 

$Receivable = $fetch['Receivable'];

	$Payable = abs($fetch['Payable']);
		
$balance = ($fetch['pre_balance'] + $fetch['balance']);
if($balance !=0){
?>


<tr>
	<td><?php echo $sl++; ?></td>

    <td style="text-align:left;" title="Click Here to Open ledger"> <a href="WalletLedgerView.php?WalletID=<?php print $fetch['WalletID']; ?>&start_date=<?php print $_GET['start_date']; ?>&end_date=<?php print $_GET['end_date']; ?>" style="text-decoration: none;"><?php print $fetch['WalletInfo']; ?> </a></td>
    <td style="text-align:right;"> <?php print number_format($fetch['pre_balance'],2,'.',''); ?> </td>
    <td style="text-align:right;"> <?php print number_format($Receivable,2,'.',''); ?> </td>
    <td style="text-align:right;"> <?php print number_format($Payable,2,'.',''); ?> </td>
    <th style="text-align:right; color:<?php if($balance >='0'){ print "green";}else{ print "red"; } ?>"> <?php print number_format($balance,2,'.',''); ?> </th>
   
</tr>

<?php	
$balance = $balance;
$pre_balance += $fetch['pre_balance'];
$total_Receivable += $Receivable;
$total_Payable += $Payable;
$total_balance += $balance;
}
} //while 
?>

<tr>
	<th style="text-align:center;" colspan="2"> TOTAL </th>
	<th style="text-align:right;"> <?php print number_format($pre_balance,2,'.',''); ?></th>
	<th style="text-align:right;"> <?php print number_format($total_Receivable,2,'.',''); ?></th>
	<th style="text-align:right;"> <?php print number_format($total_Payable,2,'.',''); ?></th>
	<th style="text-align:right;"> <?php print number_format($total_balance,2,'.',''); ?></th>

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
			htmlToCSV(html, "Wallet Ledger.csv");
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