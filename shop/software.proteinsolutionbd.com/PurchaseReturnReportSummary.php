<?php
include("auth.php");
include("db.php");
?>
<html>
<head>
<title>Challan Return Report >> <?php print $_GET['type']; ?></title>
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
    $query = $conn->prepare("SELECT CONCAT(`SupplierID`,'-',`Name`,'-',`MobileNo`,'-',`Address`) AS `SupplierInfo` FROM `Supplier` WHERE  `SupplierID` = '$SupplierID' "); 
    $query->execute();
    $Supplier = $query->fetch();
      $SupplierInfo = $Supplier['SupplierInfo'];
    }else{
       $SupplierInfo = 'All';
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

            
?>


<table class="table table-hover table-condensed table-striped table-bordered"  style="white-space: nowrap;">

<tr>
	<th style="text-align:center; font-size:18px;"> <?php print $company; ?> </th>
</tr>

<tr>
	<th style="text-align:center;"><?php print $c_address; ?></th>
</tr>		

<tr>
	<th style="text-align:center; font-size:18px;"> Challan Return Summary Report 
	<?php if(!empty($_GET['type'])){ ?> (<?php print $_GET['type']; ?>) <?php } ?></th>
</tr>
<tr>
	<th style="font-size:14px; text-align :left">Supplier : <?php print $SupplierInfo; ?> / Item Category Name : <?php print $ItemCategory; ?></th>
</tr>
</table>

<?php
## Challan Return Report Invoice Wise
if(!empty($_GET['type']) && ($_GET['type'] =='Invoice Wise') && !empty($_GET['start_date']) && !empty($_GET['end_date'])){

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
	<th> Date </th>
	<th> Supplier </th>
	<th> Challan Return Invoice </th>
	<th> Challan Return Invoice ReturnAmount </th>
	<!-- <th> Discount </th>
	<th> Transport </th>
	<th> Payable </th> -->
</tr>
</thead>
<tbody>
<?php 

if(!empty($_GET['SupplierID']) && $_GET['SupplierID'] =='All'){
    $SupplierID ="";
}else{
    $SupplierID =" AND A.`SupplierID` = '$_GET[SupplierID]' ";
}   

if(!empty($_GET['ItemCategory']) && $_GET['ItemCategory'] =='All'){
    $ItemCategoryID ="";
}else{
    $ItemCategoryID =" AND A.`ItemCategoryID` = '$_GET[ItemCategory]' ";
} 




$start_date = $get_start_date->format('Y-m-d');
$end_date =  $get_end_date->format('Y-m-d');

$sl =1;
$TotalReturnAmount = 0;
$discount = 0;
$transport_cost = 0;
$payable = 0;

$query = $conn->prepare("SELECT A.*,SUM(`ReturnAmount`) AS `TotalReturnAmount`, CONCAT(B.`Name`,'-',B.`MobileNo`) AS `SupplierInfo`  FROM `ChallanReturn` A 
LEFT JOIN `Supplier` B ON (A.`SupplierID` = B.`SupplierID`)
WHERE A.`Cart` = 'Yes' AND A.`ChallanReturnDate` BETWEEN '$start_date' AND '$end_date'  $SupplierID $ItemCategoryID GROUP BY A.`ChallanReturnInvoice` ORDER BY A.`ChallanReturnInvoice` ASC");
$query->execute();
                
    if($query->rowCount()==0){
    print "<tr> <td colspan=7 style=\"text-align:center; color:red;\"> No matching records found. </td> </tr>";	
    }
    $fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach($fetch_list AS $fetch) { 

?>


<tr>
	<td><?php echo $sl++; ?> </td>
    <td style="text-align:left;"> <?php print date("d-m-Y",strtotime($fetch['ChallanReturnDate'])); ?> </td>
    <td style="text-align:left;"><?php print $fetch['SupplierInfo']; ?></td>
    <th style="text-align:center;" title="Click Here To Open Challan Return Invoice">
    <a onclick="window.open('Challan_ChallanInvoice.php?ChallanInvoice=<?php echo $fetch['ChallanReturnInvoice']; ?>',
'mywindow','menubar=1,resizable=1,width=900,height=800');" ><?php echo $fetch['ChallanReturnInvoice']; ?></a>
      
    </th>
    <td style="text-align:right;"> <?php print number_format($fetch['TotalReturnAmount'],2,'.',''); ?> </td>
    <!-- <td style="text-align:right;"> <?php //print number_format($fetch['discount'],2,'.',''); ?> </td>
    <td style="text-align:right;"> <?php //print number_format($fetch['transport_cost'],2,'.',''); ?> </td>
    <td style="text-align:right;"> <?php //print number_format($fetch['payable'],2,'.',''); ?> </td> -->
   
</tr>

<?php	
$TotalReturnAmount += $fetch['TotalReturnAmount'];
// $discount += $fetch['discount'];
// $transport_cost += $fetch['transport_cost'];
// $payable += $fetch['payable'];

} //while 
?>

<tr>
	<th style="text-align:center;" colspan="4"> TOTAL </th>
	<th style="text-align:right;"><?php print number_format($TotalReturnAmount,2,'.',''); ?></th>
	<!-- <th style="text-align:right;"> <?php //print number_format($discount,2,'.',''); ?></th>
	<th style="text-align:right;"> <?php //print number_format($transport_cost,2,'.',''); ?></th>
	<th style="text-align:right;"> <?php //print number_format($payable,2,'.',''); ?></th> -->
</tr>
</tbody>
<tfoot>
	<tr>
		<th colspan=8>

            
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
## Challan Return Report Product Wise
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
	<th>Item Category Name </th>
	<th> Product Info </th>
	<th> Challan Return Qty </th>
    <th> Total ReturnAmount </th>
</tr>
</thead>
<tbody>
<?php 

if(!empty($_GET['SupplierID']) && $_GET['SupplierID'] =='All'){
    $SupplierID ="";
}else{
    $SupplierID =" AND A.`SupplierID` = '$_GET[SupplierID]' ";
}   


if(!empty($_GET['ItemCategory']) && $_GET['ItemCategory'] =='All'){
    $ItemCategoryID ="";
}else{
    $ItemCategoryID =" AND A.`ItemCategoryID` = '$_GET[ItemCategory]' ";
} 




$start_date = $get_start_date->format('Y-m-d');
$end_date =  $get_end_date->format('Y-m-d');

$sl =1;
$TotalReturnAmount = 0;
$ReturnQuantity = 0;
$free_ReturnQuantity = 0;

$query = $conn->prepare("SELECT 
B.`Name`,
SUM(A.`ReturnQuantity`) AS `ReturnQuantity`, 
SUM(A.`ReturnAmount`) AS `TotalReturnAmount`,
CONCAT(C.`Thickness`,'-',C.`Size`) AS `PackageSize`
FROM `ChallanReturn` A 
LEFT JOIN `ItemCategory` B ON (A.`ItemCategoryID` = B.`ItemCategoryID`)
LEFT JOIN `PackageSize` C ON (A.`PackageSizeID` = C.`PackageSizeID`)

WHERE A.`Cart` = 'Yes' 
AND A.`ChallanReturnDate` 
BETWEEN '$start_date' 
AND '$end_date'  $SupplierID $ItemCategoryID  
GROUP BY A.`PackageSizeID` 
ORDER BY B.`Name`,A.`PackageSizeID` ASC");
$query->execute();
                
    if($query->rowCount()==0){
    print "<tr> <td colspan=8 style=\"text-align:center; color:red;\"> No matching records found. </td> </tr>";	
    }
    $fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach($fetch_list AS $fetch) { 

?>


<tr>
	<td><?php echo $sl++; ?> </td>
    <td style="text-align:left;"><?php echo $fetch['Name']; ?> </td>
    <td style="text-align:left;"><?php echo $fetch['PackageSize']; ?> </td>
    <td style="text-align:right;"> <?php print number_format($fetch['ReturnQuantity'],2,'.',''); ?> </td>
    <td style="text-align:right;"> <?php print number_format($fetch['TotalReturnAmount'],2,'.',''); ?> </td>
   
</tr>

<?php	
$ReturnQuantity += $fetch['ReturnQuantity'];
$TotalReturnAmount += $fetch['TotalReturnAmount'];

} //while 
?>

<tr>
	<th style="text-align:center;" colspan="3"> TOTAL </th>
	<th style="text-align:right;"> <?php print number_format($ReturnQuantity,2,'.',''); ?></th>
	<th style="text-align:right;"><?php print number_format($TotalReturnAmount,2,'.',''); ?></th>

</tr>
</tbody>
<tfoot>
	<tr>
		<th colspan=8>

            
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
## Sales ReportInvoice Details
if(!empty($_GET['type']) && ($_GET['type'] =='Invoice Details') && !empty($_GET['start_date']) && !empty($_GET['end_date'])){

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
	<th rowspan="2"> S/L </th>
	<th rowspan="2"> Date </th>
	<th rowspan="2"> Supplier Info </th>
	<th rowspan="2"> Challan Return Invoice </th>
	<th colspan="4" style="text-align:Center;"> Challan Return Invoice Details </th>
</tr>
<tr>
    <th>Product</th>
    <th>Qty</th>
    <th>Return. Rate</th>
    <th>Total</th>
</tr>
</thead>
<tbody>
<?php 

if(!empty($_GET['SupplierID']) && $_GET['SupplierID'] =='All'){
    $SupplierID ="";
}else{
    $SupplierID =" AND A.`SupplierID` = '$_GET[SupplierID]' ";
}   

if(!empty($_GET['ItemCategory']) && $_GET['ItemCategory'] =='All'){
    $ItemCategoryID ="";
}else{
    $ItemCategoryID =" AND A.`ItemCategoryID` = '$_GET[ItemCategory]' ";
} 

$start_date = $get_start_date->format('Y-m-d');
$end_date =  $get_end_date->format('Y-m-d');

$sl =1;
$TotalReturnAmount = 0;
$discount = 0;
$ChallanReturnReturnAmount = 0;

$query = $conn->prepare("SELECT 
                            COUNT(A.`ChallanReturnID`) AS `total_data`,
                            A.`ChallanReturnInvoice`,
                            A.`ChallanReturnDate`,
							A.`Remarks`,
                            SUM(A.`ReturnAmount`) AS `TotalReturnAmount` ,
                            SUM(A.`ReturnQuantity`) AS `total_ReturnQuantity` ,
                            CONCAT(B.`SupplierID`,'-',B.`Name`,'-',B.`MobileNo`) AS `SupplierInfo`

                        FROM `ChallanReturn` A 
                        LEFT JOIN `Supplier` B ON A.`SupplierID` = B.`SupplierID` 
WHERE A.`Cart` = 'Yes' AND  A.`ChallanReturnDate` BETWEEN '$start_date' AND '$end_date'  $SupplierID $ItemCategoryID  GROUP BY A.`ChallanReturnInvoice` ORDER BY A.`ChallanReturnInvoice` ASC");
$query->execute();
                
    if($query->rowCount()==0){
    print "<tr> <td colspan=7 style=\"text-align:center; color:red;\"> No matching records found. </td> </tr>";	
    }
    $fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach($fetch_list AS $fetch) { 

?>


<tr>
	<td rowspan="<?php print $fetch['total_data']; ?>"><?php echo $sl++; ?></td>
    <td style="text-align:left;" rowspan="<?php print $fetch['total_data']; ?>"> <?php print date("d-m-Y",strtotime($fetch['ChallanReturnDate'])); ?> </td>
	<td style="text-align:left;" rowspan="<?php print $fetch['total_data']; ?>"><?php print $fetch['SupplierInfo']; ?></td>
    <td style="text-align:center;" rowspan="<?php print $fetch['total_data']; ?>" title="Click Here To Open Challan Return Invoice">
    <a onclick="window.open('ChallanReturnInvoice.php?ChallanReturnInvoice=<?php echo $fetch['ChallanReturnInvoice']; ?>',
'mywindow','menubar=1,resizable=1,width=1000,height=800');" ><?php print $fetch['ChallanReturnInvoice']; ?></a>
      
    </td>


<?php
$query2 = $conn->prepare("SELECT 
A.*,
B.`Name` AS `ItemCategory`,
C.`Thickness`,
C.`Size`
FROM `ChallanReturn` A 
LEFT JOIN `ItemCategory` B ON (A.`ItemCategoryID` = B.`ItemCategoryID`)
LEFT JOIN `PackageSize` C ON (A.`PackageSizeID` = C.`PackageSizeID`)
WHERE A.`ChallanReturnInvoice` = '$fetch[ChallanReturnInvoice]' $SupplierID $ItemCategoryID ORDER BY B.`Name`,C.`Thickness` ASC");
$query2->execute();

$fetch2 = $query2->fetchAll(PDO::FETCH_ASSOC);

foreach($fetch2 AS $fetch2) {

?>

    <td style="text-align:left;"> <?php print $fetch2['ItemCategory']; ?> &times;  <?php print $fetch2['Thickness']; ?> </td>
    <td style="text-align:right;"> <?php print $fetch2['ReturnQuantity']; ?> <?php print $fetch2['Size']; ?></td>
    <td style="text-align:right;"> <?php print number_format($fetch2['ReturnRate'],2,'.',''); ?> </td>
    <td style="text-align:right;"> <?php print number_format($fetch2['ReturnAmount'],2,'.',''); ?> </td>
</tr>

<?php
} //foreach
?>
<tr>
    <th style="text-align:center;" colspan="5"> TOTAL </th>
    <th style="text-align:right;"><?php print number_format($fetch['total_ReturnQuantity'],2,'.',''); ?></th>
    <th style="text-align:right;"  colspan="" >&nbsp;</th>
    <th style="text-align:right;"><?php print number_format($fetch['TotalReturnAmount'],2,'.',''); ?></th>
</tr>

<?php	
$ChallanReturnReturnAmount += $fetch['TotalReturnAmount'];

} //while 
?>

<tfoot>
<tr>
	<th style="text-align:center;" colspan="7"> TOTAL </th>
	<th style="text-align:right;"><?php print number_format($ChallanReturnReturnAmount,2,'.',''); ?></th>
</tr>
</tfoot>
</tbody>
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
			htmlToCSV(html, "Challan Return Summary Report.csv");
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