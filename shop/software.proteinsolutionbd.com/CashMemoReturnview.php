<?php
require_once('auth.php');
include("db.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset='UTF-8'>
	<title>CASH MEMO Return</title>
	<link rel='stylesheet' href='style1.css'>
	<link rel='stylesheet' href='print.css' media="print">
</head>

<body>

<?php		
$QurryInvoice = $conn->prepare("SELECT * FROM `CashMemoReturn` WHERE `CashMemoReturnInvoice` = '$_GET[CashMemoReturnInvoice]' ");
$QurryInvoice->execute();
$Fetch = $QurryInvoice->fetch(PDO::FETCH_ASSOC);

$CashMemoReturnInvoice = $_GET['CashMemoReturnInvoice'];

$QurryCustomer = $conn->prepare("SELECT CONCAT(`Name`,' - ' , `MobileNo` , ' - ',`Address`) AS `CustomerInfo` FROM `Customer` WHERE `CustomerID` = '$Fetch[CustomerID]' ");
$QurryCustomer->execute();
$FetchCustomer = $QurryCustomer->fetch(PDO::FETCH_ASSOC);

$QurryOperator = $conn->prepare("SELECT `UserName` FROM `UserInformation` WHERE `Id` = '$Fetch[EntryID]' ");
$QurryOperator->execute();
$FetchOperator = $QurryOperator->fetch(PDO::FETCH_ASSOC);

?>

	<div id="page-wrap">
		
        <p style="margin-top:10px; font-size:16px; text-align:center;"><u> বিসমিল্লাহির রাহমানির রাহিম </u> </p>
        
		<textarea readonly="readonly" id="header"> CASH MEMO RETURN</textarea>
		
		<div id="identity" style="border:0px solid; width:800px; float:left;">
        	
           <div style="float:left;">
               <font size="+2"> <b><?php print $company; ?> </b></font><br>
               <?php print $c_address; ?><br>
               <?php print $c_mobile; ?>
           
            <hr>
              
              <br>
               
            <?php if($Fetch['SalesType'] == 'Due'){ ?>
            <b> Bill To: </b> <br> <font size="-1"> <?php print $FetchCustomer['CustomerInfo']; ?></font>
			<?php }else{ ?>
            <b> Bill To: </b> <br><font size="-1"><?php print $Fetch['CustomerName']; ?>-<?php print $Fetch['CustomerAddress']; ?></font>
			<?php } ?>
            
           </div>
            
           <table id="meta">
                
                <tr>
                    <td class="meta-head">Date</td>
                    <td><?php Print date("d-m-Y",strtotime($Fetch['CashMemoReturnDate'])); ?></td>
                </tr>
                
                <tr>
                    <td class="meta-head">Time</td>
                    <td> <?php print date("h:i:s a",strtotime($Fetch['CreateDate'])); ?></td>
                </tr>
                
                <tr>
                    <td class="meta-head">Memo No</td>
                    <td><b><?php print $CashMemoReturnInvoice; ?></b></td>
                </tr>
                
                <tr>
                    <td class="meta-head">Return Person</td>
                    <td><div class="due"> <?php print $FetchOperator['UserName']; ?> </div></td>
                </tr>

            </table>
		</div>
		
        
		<div style="clear:both"></div>
		

		
		<table id="items">
		
		  <tr>
		      <th>SL</th>
		      <th>Description</th>
		      <th>Qty</th>
		      <th>Unit Price</th>
		      <th>Total</th>
		  </tr>
          
          
		  
<?php
$sl=1;
$ReturnAmount = 0;
$QueryInvoiceData = $conn->prepare("SELECT 
        A.*,
        B.`Name` AS `ItemCategory`,
        C.`Thickness`,
        C.`Size`
FROM `CashMemoReturn` A 
LEFT JOIN `ItemCategory` B ON (A.`ItemCategoryID` = B.`ItemCategoryID`)
LEFT JOIN `PackageSize` C ON (A.`PackageSizeID` = C.`PackageSizeID`)
WHERE A.`CashMemoReturnInvoice`='$CashMemoReturnInvoice' ORDER BY `CashMemoReturnID` ASC ");
$QueryInvoiceData->execute();
$FetchInvoice = $QueryInvoiceData->FetchAll(PDO::FETCH_ASSOC);
foreach($FetchInvoice AS $Fetch) {
?>		  
		  
		  <tr class="item-row">
		      <td><div class="delete-wpr"><?php print $sl++; ?> <a class="delete" href="javascript:;" title="Remove row">&radic;</a></div></td>
		      <td class="description"><?php print $Fetch['ItemCategory']; ?> &times;  <?php print $Fetch['Thickness']; ?>&times; <?php print $Fetch['Size']; ?></td>
              
		      <td style="text-align:right;"><?php print $Fetch['ReturnQuantity']; ?></td>
		      <td style="text-align:right;"><?php print $Fetch['ReturnRate']; ?></td>
		      <td style="text-align:right;"><span class="price">  <?php print $Fetch['ReturnAmount']; ?> </span></td>
		  </tr>
		  
<?php  
$ReturnAmount += $Fetch['ReturnAmount'];
} // WHILE ?>		  
		  
		  <tr id="hiderow">
		    <td colspan="5"> </td>
		  </tr>
		  
		  <?php /*<tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">লেভার:</td>
		      <td class="total-value"><div id="subtotal"> <?php print $Fetch['labour']; ?></div></td>
		  </tr>*/?>
	

		  
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Net Total:</td>
		      <td style="text-align:right;" class="total-value"><div id="total"> <?php print number_format($ReturnAmount,2,'.',''); ?> </div></td>
		  </tr>
		  

		</table>
		
        <div id="terms">
		  <textarea> Remarks: <?php print $Fetch['Remarks']; ?> </textarea>
		</div>
        
		<div id="sign">
		  <h5><u> Customer Signature </u></h5>
		</div>
		
		<div id="sign1">
		  <h5><u> Authorized Signature </u></h5>
		</div>
		
		
	
	</div>
	
</body>

</html>