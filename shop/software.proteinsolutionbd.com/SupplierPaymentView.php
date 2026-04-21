<?php
require_once('auth.php');
include("db.php");
include("NumberToWordFunction.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset='UTF-8'>
	<title>MONEY RECEIPT</title>
	<link rel='stylesheet' href='style1.css'>
	<link rel='stylesheet' href='print.css' media="print">
	<style>
	@media print {
  body {
    zoom: 70%;
  }

  #page-wrap {
    width: 65%;
  }
}
	</style>
</head>

<body>

<?php
$discount = 0;
$query = $conn->prepare("SELECT * FROM `Payment`  
WHERE `SupplierPaymentInvoice` = '$_GET[SupplierPaymentInvoice]'"); 
$query->execute();
$fetch = $query->fetch(PDO::FETCH_ASSOC);

$query1 = $conn->prepare("SELECT CONCAT('Supplier ID: 00',SupplierID,'<br> ','Supplier Name: ',`Name`,'<br> ','Address: ',`Address`,'<br> ','Mobile: ',`MobileNo`) AS `cust_info` FROM `Supplier` WHERE `SupplierID` = '$fetch[SupplierID]'"); 
$query1->execute();
$fetch_cust = $query1->fetch(PDO::FETCH_ASSOC);

$query2 = $conn->prepare("SELECT * FROM `UserInformation` WHERE `Id` = '$fetch[EntryID]'"); 
$query2->execute();
$fetch_logerh = $query2->fetch(PDO::FETCH_ASSOC);


?>

	<div id="page-wrap">
		


			<style>

				.container {
					display: flex;
					margin-top: 30px;
				}

				.container img {
					float: left;
					margin-right: 5px;
					margin-top: 30px;
					margin-bottom: 5px;
				}
 
				#items td.total-line{
					border-right: solid 1px;
				}
				#header {
					width: 30%;
				}

				#sign5 {
					text-align: right;
					margin: -17px 359px 0 0;
					float: right;
				}
			</style>
 
			
		<div class="container">
		
			<p><font style="font-size:16px;">বিসমিল্লাহির রাহমানির রাহীম</font><br><font style="font-size:30px;"> <b><?php print $company; ?> </b></font><br>
				<font style="font-size:13px;"> <b><?php print $c_address; ?> <br> <?php print $c_mobile; ?>. <?php print $c_email; ?></b></font></p>
				<font style="margin-top:4%;margin-left: -4%;"> <b>Supplier Copy</b> </font>
		</div>	

		<center> <h2>SUPPLIER PAYMENT</h2> </center>
		
		<div id="identity" style="border:0px solid; width:100%; float:left;">
        
		   <div style="float:left;">
		   
            <b> <font size="font-size:16px;"> <?php print $fetch_cust['cust_info']; ?></font>  </b>
            </b> 
           </div>
            
           <table id="meta" style="width: 250px;">
                
                <tr>
                    <td style="border: none;text-align: left;font-size:15px;padding: 0px;"><b>Date:</b></td>
                    <td style="border: none;text-align: left;font-size:15px;padding: 0px;"><b><?php print $fetch['PaymentDate']; ?></b></td>
                </tr>
                
                <tr>
                    <td style="border: none;text-align: left;font-size:15px;padding: 0px;"><b>Time:</b></td>
                    <td style="border: none;text-align: left;font-size:15px;padding: 0px;"> <b><?php  print date("h:i:s a",strtotime($fetch['CreateDate'])); ?></b></td>
                </tr>
                
                <tr>
                    <td style="border: none;text-align: left;font-size:15px;padding: 0px;"><b>MR No:</b></td>
                    <td style="border: none;text-align: left;font-size:15px;padding: 0px;"><b><?php print $fetch['SupplierPaymentInvoice']; ?></b></td>
                </tr>
                
                <tr>
                    <td style="border: none;text-align: left;font-size:15px;padding: 0px;"><b>User:</b></td>
                    <td style="border: none;text-align: left;font-size:15px;padding: 0px;"><div class="due"> <b><?php print "$fetch_logerh[UserName]"; ?></b> </div></td>
                </tr>

            </table>
		</div>
		
		<div style="clear:both"></div>
			
		<table id="items">

		 <tr>
		      <td colspan="2" class="total-line balance" style="text-align:center;width:80%;"><b>Particular</b></td>
		      <td style="text-align:center;width:20%;" class="total-value balance"><div class="due"> <b>Amount</b></div></td>
		  </tr>
		

		  <tr>
		      <td colspan="2" class="total-line balance" style="text-align:center;width:80%;"><b>Payment</b> <?php print $fetch['PaymentName']; ?>  </td>
		      <td style="text-align:center;width:20%;" class="total-value balance"><div class="due"> <b><?php print $fetch['PaymentAmount']; ?></b> </div></td>
		  </tr>

          
		  <!-- <tr>
	    	 <th colspan="5" class="blank" style="text-align:Left; font-size: 14px; font-weight: normal; text-transform: capitalize;"> 
			 <b>In Words:   <?php
            // $PaymentAmount = number_format($fetch['PaymentAmount'], ((int) $fetch['PaymentAmount'] == $fetch['PaymentAmount'] ? 0 : 2), '.', ','); 
	
			// 		print convert_number_to_words((int)$PaymentAmount);
				
			?>  only</b></th>
		 </tr> -->

		</table>
		
        <div id="terms" style="margin-top: 5px; margin-bottom: 70px; font-size: 12px;">
		  <b>Remarks: <?php print $fetch['PaymentNote']; ?></b>
		</div>
	
        <style>
		#sign3{
			text-align: center;
			margin: 20px 0 0 0;
		}
		</style>

<div style="width: 33%; height: 50%; float:left;text-decoration: overline;"><b>Prepared By</b></div>
<div style="width: 33%; height: 50%; float:right;text-align: right;text-decoration: overline;"><b>Authorized By</b></div>
<div style="width: 33%; height: 50%; float:right;text-align: center;text-decoration: overline;"><b>Checked By</b></div>

<!-- <div style="width: 100%; height: 50%; clear:both;text-align: center;margin-top: 20%;font-size:13px;">
Powered By <b>Islam Poultry</b> || Design & Developed By <a href="https://www.i3intelligence.com/" style="color:black;text-decoration: none;"><b>i3 intelligence</b></a>.
</div> -->

	</div>
	
</body>

</html>