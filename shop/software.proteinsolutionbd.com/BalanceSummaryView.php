<?php
include("auth.php");
include("db.php");
?>
<html>
<head>
<title>Balance Summary Report >> <?php print $_GET['type']; ?></title>
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



            
?>


<table class="table table-hover table-condensed table-striped table-bordered"  style="white-space: nowrap;">

<tr>
	<th style="text-align:center; font-size:18px;"> <?php print $company; ?> </th>
</tr>

<tr>
	<th style="text-align:center;"><?php print $c_address; ?></th>
</tr>		

<tr>
	<th style="text-align:center; font-size:18px;"> Balance Summary Report </th>
</tr>
<tr>
</tr>
</table>

<?php
## Balance Summary Report Invoice Wise
if(!empty($_GET['end_date'])){
    //GET START DATE
    $datestring_end_date =$_GET['end_date'];
    list($day, $month, $year) = explode('/', $datestring_end_date);
    $get_end_date = DateTime::createFromFormat('Ymd', $year . $month . $day);
	// include("BalanceSummaryPreviousday.php");	
	include("BalanceSummaryToday.php");	

?>



<table class="table table-hover table-condensed table-striped table-bordered"  style="white-space: nowrap;">

<tr>
<th style="font-size:14px; text-align :center">Statement : <?php print $statement_end_date = $get_end_date->format('d-m-Y');  ?></th>
</tr>



</table>


<table id="table" class="table table-hover table-condensed table-striped table-bordered"  style="white-space: nowrap;">

<thead>
    <tr>
<tr>
	<th colspan="2" style="Background-Color:Orange; text-align :left; font-size:18px;"> Assets </th>
	<th colspan="2"  style="Background-Color:BlanchedAlmond; text-align :left; font-size:18px;"> Liabilities </th>
</tr>
<tr>
     <th style="Background-Color:Orange; text-align :left; font-size:18px;">Customer Due</th>
	<th style="Background-Color:Orange; font-size:18px;  text-align :right; "><?php print number_format($CustomerBalance,2,'.',''); ?></th>
	<th style="Background-Color:BlanchedAlmond; text-align :left; font-size:18px;">Supplier Due</th>
	<th style="Background-Color:BlanchedAlmond; font-size:18px;  text-align :right; "><?php print number_format($SupplierBalance,2,'.',''); ?></th>
</tr>
<tr>
    <th  style="Background-Color:Orange; text-align :left; font-size:18px;">Cash </th>
	<th style="Background-Color:Orange; font-size:18px;  text-align :right; "><?php print number_format($WalletBalance,2,'.',''); ?></th>
	<th colspan="2" rowspan="2" style="Background-Color:BlanchedAlmond; font-size:18px;"></th>
</tr>
<tr>
	<th  style="Background-Color:Orange; text-align :left; font-size:18px;">Stock</th>
	<th style="Background-Color:Orange; font-size:18px;  text-align :right; "><?php print number_format($ClosingBalance,2,'.',''); ?></th>
</tr>

<tr>
	<th  style="Background-Color:Orange; text-align :left; font-size:18px;">Total Assets</th>
	<th style="Background-Color:Orange; font-size:18px;  text-align :right; "><?php print $Assets = number_format($CustomerBalance + $WalletBalance + $ClosingBalance,2,'.',''); ?></th>
	<th  style="Background-Color:BlanchedAlmond; text-align :left; font-size:18px;">Total Liabilities</th>
	<th style="Background-Color:BlanchedAlmond; font-size:18px;"><?php print number_format($SupplierBalance,2,'.',''); ?> </th>
</tr>
<tr>
	<th colspan="4"></th>
</tr>
<tr>
	<th  colspan="2" style="Background-Color:Orange; text-align :left; font-size:18px;">Balance (<?php print $statement_end_date; ?>)</th>
	<th  colspan="2" style="Background-Color:Orange; font-size:18px;"><?php print number_format($Assets - abs($SupplierBalance),2,'.',''); ?></th>
</tr>


</thead>
<tbody>

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
			htmlToCSV(html, "Cash Memo Summary Report.csv");
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