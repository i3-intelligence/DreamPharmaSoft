<?php
include("auth.php");
include("db.php");
?>
<html>
<head>
<title>Customer Ledger</title>
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

<body>

<?php 
// if(!empty($mpk[1]) && $mpk[1]=='1'){ 	

if(!empty($_GET['CustomerSubCategoryID'])){

    
    $CustomerSubCategoryID = $_GET['CustomerSubCategoryID'];
    $query = $conn->prepare("SELECT `Name` FROM `CustomerSubCategory` WHERE  `CustomerSubCategoryID` = '$CustomerSubCategoryID' "); 
    $query->execute();
    $FetchCustomerSubCategoryID= $query->fetch();
    if($query->rowCount() != 0){
        $CustomerSubCategoryInfo = $FetchCustomerSubCategoryID['Name'];
    }else{
        $CustomerSubCategoryInfo = "All";
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
	<th style="text-align:center; font-size:18px;"> Customer Balance Summary</th>
</tr>
<tr>
<th style="font-size:14px; text-align :left">Customer Sub Category: <?php print $CustomerSubCategoryInfo; ?> </th>
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
$TableName = "temp_Customer_ledger".$SessionID;
$query = $conn->prepare("DROP TABLE IF EXISTS `$TableName`"); 
$query->execute();

## CREATE TABLE 
$create = $conn->prepare("CREATE TABLE `$TableName`  
(
`ID` INT(75) NULL,
`Date` DATE NOT NULL,
`Time` VARCHAR(125) NULL,
`CustomerID` INT(11) NULL,
`Invoice` VARCHAR(125) NULL,
`InvoiceType` VARCHAR(125) NULL,
`InvoiceAmount` DOUBLE NULL,
`ReceiveAmount` DOUBLE NULL,
`PaidAmount` DOUBLE NULL,
`Discount`DOUBLE NULL,
`Receivable` DOUBLE NULL,
`Payable` DOUBLE NULL,
`PaymentType` VARCHAR(125) NULL,
`Creator` INT(11) NULL
)
");
$create->execute();

//CashMemo
$CashMemo = $conn->exec("INSERT INTO `$TableName` 
SELECT 
        `CashMemoID`,
        `CashMemoDate`,
        `CreateDate` AS `CashMemoTime`,
        `CustomerID`,
        `CashMemoInvoice`,
        'Cash Memo' AS `InvoiceType`,
        `TotalAmount` AS `InvoiceAmount`, 
        `ReceiveAmount` AS `ReceiveAmount`,
        '0' AS `PaidAmount`,
        `Discount`,
        `ReceiveAmount` AS `Receivable`,
        `TotalAmount` AS `Payable`,
        `TransactionType` AS `PaymentType`, 
        `EntryID` 
    FROM `CashMemo` WHERE  `Cart` = 'Yes' AND `CashMemoDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' GROUP BY `CashMemoInvoice`");

//Cash Memo Return
$CashMemoReturn = $conn->exec("INSERT INTO `$TableName` 
SELECT 
        `CashMemoReturnID`,
        `CashMemoReturnDate`,
        `CreateDate` AS `CashMemoReturnTime`,
        `CustomerID`,
        `CashMemoReturnInvoice`,
        'Cash Memo Return' AS `InvoiceType`,
        `TotalAmount` AS `InvoiceAmount`, 
        '0' AS `ReceiveAmount`,
        `PaymentAmount` AS `PaidAmount`,
        '0' AS `Discount`,
        SUM(`ReturnAmount`) AS `Receivable`,
         `PaymentAmount` AS `Payable`,
        `TransactionType` AS `PaymentType`, 
        `EntryID` 
    FROM `CashMemoReturn` WHERE  `Cart` = 'Yes' AND `CashMemoReturnDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' GROUP BY `CashMemoReturnInvoice`");


//CustomerDue
$CustomerDue = $conn->exec("INSERT INTO `$TableName` 
SELECT 
    `ReceiveID`,
    `ReceiveDate`,
    `CreateDate` AS `PaymentTime`,
    `CustomerID`,
    `CustomerDueReceiveInvoice`,
    'Customer Due' AS `ReceiveType`, 
    '0' AS `InvoiceAmount`, 
    '0' AS `ReceiveAmount`,
    `ReceiveAmount` AS `PaidAmount`,
    `ReceiveDiscount` AS `Discount`,
    '0' AS `Receivable`,
    `ReceiveAmount` AS `Payable`, 
    `PaymentName` AS `PaymentType`, 
    `EntryID` 
FROM `Receive` WHERE  `ReceiveDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' AND CustomerDueReceiveInvoice != '' GROUP BY `CustomerDueReceiveInvoice` ");


//CustomerReceive
$CustomerReceive = $conn->exec("INSERT INTO `$TableName` 
SELECT 
    `ReceiveID`,
    `ReceiveDate`,
    `CreateDate` AS `PaymentTime`,
    `CustomerID`,
    `CustomerReceiveInvoice`,
    'Customer Receive' AS `ReceiveType`, 
    '0' AS `InvoiceAmount`, 
    `ReceiveAmount` AS `ReceiveAmount`,
    '0' AS `PaidAmount`,
    `ReceiveDiscount` AS `Discount`,
    `ReceiveAmount` AS `Receivable`,
    '0' AS `Payable`, 
    `PaymentName` AS `PaymentType`, 
    `EntryID` 
FROM `Receive` WHERE  `ReceiveDate` BETWEEN '".$i3_define_date."' AND '".$end_date."' AND CustomerReceiveInvoice != '' GROUP BY `CustomerReceiveInvoice` ");

?>

<table id="table" class="table table-hover table-condensed table-striped table-bordered"  style="white-space: nowrap;">

<thead>
<tr>
	<th> S/L </th>
	<th> Customer Info. </th>
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
$balance = 0;
$pre_balance = 0;
$total_Receivable = 0;
$total_Payable = 0;
$GNetReceivable = 0;
$GNetPayable = 0;
if(!empty($_GET['CustomerSubCategoryID']) AND $_GET['CustomerSubCategoryID'] == 'All'){
    $CustomerSubCategoryID = "";
}else{
    $CustomerSubCategoryID = "WHERE  A.`CustomerSubCategoryID` = '".$_GET['CustomerSubCategoryID']."'";
}
//previus Date
$pdate = date('Y-m-d', strtotime('-1 day', strtotime($start_date)));
$query = $conn->prepare("SELECT 
A.`CustomerID`,
CONCAT(A.`CustomerID`,' - ',A.`Name`,'<br>',A.`MobileNo`) AS `CustomerInfo`,
IFNULL(A.`OpeningBalance`,0) AS `OpeningBalance`,
((IFNULL(B.`pre_Payable`,0)) - (IFNULL(B.`pre_Receivable`,0) + IFNULL(B.`pre_Discount`,0))) `pre_balance`,
IFNULL(B.`Receivable`,0) AS `Receivable`,
IFNULL(B.`Payable`,0) AS `Payable`,
IFNULL(B.`Discount`,0) AS `Discount`,

((IFNULL(B.`Payable`,0)) - (IFNULL(B.`Receivable`,0) + IFNULL(B.`Discount`,0))) `balance`

 FROM `Customer` A 
 LEFT JOIN (SELECT
    `CustomerID`,
    SUM(CASE WHEN  `date` BETWEEN '".$i3_define_date."' AND '".$pdate."' THEN `Receivable` ELSE 0 END) `pre_Receivable`,
	
	SUM(CASE WHEN  `date` BETWEEN '".$i3_define_date."' AND '".$pdate."' THEN `PaidAmount` ELSE 0 END) `pre_PaidAmount`,

	SUM(CASE WHEN  `date` BETWEEN '".$i3_define_date."' AND '".$pdate."' THEN `Discount` ELSE 0 END) `pre_Discount`,

	SUM(CASE 
		WHEN  `date` BETWEEN  '".$i3_define_date."' AND '".$pdate."' THEN (IFNULL(`Payable`,0)) 
		ELSE 0
		END ) `pre_Payable`, 
	SUM(CASE WHEN  `date` BETWEEN '".$start_date."' AND '".$end_date."' THEN `Receivable` ELSE 0 END) `Receivable`,

	SUM(CASE WHEN  `date` BETWEEN '".$start_date."' AND '".$end_date."' THEN `PaidAmount` ELSE 0 END) `PaidAmount`,

	SUM(CASE WHEN  `date` BETWEEN '".$start_date."' AND '".$end_date."' THEN `Discount` ELSE 0 END) `Discount`,

	SUM(CASE 
	WHEN  `date` BETWEEN  '".$start_date."' AND '".$end_date."' THEN (IFNULL(`Payable`,0)) 
	ELSE 0
	END ) `Payable`

  FROM `$TableName` GROUP BY `CustomerID`  ) B ON (A.`CustomerID` = B.`CustomerID`)
  $CustomerSubCategoryID
 GROUP BY A.`CustomerID` 
 ORDER BY A.`CustomerID` ASC
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
    $pre_balance = ($fetch['OpeningBalance'] + $fetch['pre_balance']);		
    $balance = ($pre_balance + $fetch['balance']);
if($balance !=0){

    if($balance <='0'){ 
		$NetReceivable = abs($balance);
		$NetPayable = 0;
	}else{
		$NetReceivable = 0;
		$NetPayable = $balance;
	} 

?>


<tr>
	<td><?php echo $sl++; ?></td>

    <td style="text-align:left;" title="Click Here to Open ledger"> <a href="CustomerLedgerView.php?CustomerID=<?php print $fetch['CustomerID']; ?>&start_date=<?php print $_GET['start_date']; ?>&end_date=<?php print $_GET['end_date']; ?>" style="text-decoration: none;"><?php print $fetch['CustomerInfo']; ?> </a></td>
    <td style="text-align:right;"> <?php print number_format($pre_balance,2,'.',''); ?> </td>
    <td style="text-align:right;"> <?php print number_format($Receivable,2,'.',''); ?> </td>
    <td style="text-align:right;"> <?php print number_format($Payable,2,'.',''); ?> </td>
    <?php if($balance <='0'){ ?>
		<th></th>
	<th style="text-align:right; color: green;"> <?php print abs(number_format($NetReceivable,2,'.','')); ?> </th>

	<?php }else{ ?>

	<th style="text-align:right; color: red;"> <?php print number_format($NetPayable,2,'.',''); ?> </th>	
	<th></th>
	<?php } ?>

   
</tr>

<?php	
$balance = $balance;
$pre_balance += $pre_balance;
$total_Receivable += $Receivable;
$total_Payable += $Payable;
$GNetReceivable += $NetReceivable;
$GNetPayable += $NetPayable;
}
} //while 
?>

<tr>
	<th style="text-align:center;" colspan="2"> TOTAL </th>
	<th style="text-align:right;"> <?php print number_format($pre_balance,2,'.',''); ?></th>
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