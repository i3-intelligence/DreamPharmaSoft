<?php
if($_POST['PackageId'] == '1'){ 
header("location: Registration.php");

}else{

/* PHP */
$post_data = array();
$URL = "https://www.mwsbd.com/site";
$post_data['store_id'] = "shahe631848c754133";
$post_data['store_passwd'] = "shahe631848c754133@ssl";
$post_data['total_amount'] = "$_POST[PayemntAmount]";
$PackageName = $_POST['PackageName'];
$PacakageAmount = $_POST['PacakageAmount'];
$post_data['currency'] = "BDT";
$post_data['tran_id'] = "SSLCZ_TEST_".uniqid();
$token = md5($post_data['store_passwd'] . $post_data['tran_id'] . $post_data['total_amount'] . $post_data['currency']);
$post_data['success_url'] = "$URL/PaymentSuccess.php?status=success&token=$token&tran_id=$post_data[tran_id]";
$post_data['fail_url'] = "$URL/fail.php";
$post_data['cancel_url'] = "$URL/cancel.php";
# $post_data['multi_card_name'] = "mastercard,visacard,amexcard";  # DISABLE TO DISPLAY ALL AVAILABLE

# EMI INFO
$post_data['emi_option'] = "1";
$post_data['emi_max_inst_option'] = "9";
$post_data['emi_selected_inst'] = "9";

# CUSTOMER INFORMATION
$post_data['cus_name'] = "$PackageName User";
$post_data['cus_email'] = "";
$post_data['cus_add1'] = "";
$post_data['cus_add2'] = "";
$post_data['cus_city'] = "";
$post_data['cus_state'] = "";
$post_data['cus_postcode'] = "1000";
$post_data['cus_country'] = "Bangladesh";
$post_data['cus_phone'] = "";
$post_data['cus_fax'] = "";

# SHIPMENT INFORMATION
$post_data['ship_name'] = "testshahekus6";
$post_data['ship_add1 '] = "Dhaka";
$post_data['ship_add2'] = "Dhaka";
$post_data['ship_city'] = "Dhaka";
$post_data['ship_state'] = "Dhaka";
$post_data['ship_postcode'] = "1000";
$post_data['ship_country'] = "Bangladesh";

# OPTIONAL PARAMETERS
$post_data['value_a'] =  $_POST['PackageId'];
$post_data['value_b'] = date("Y-m-01",strtotime($_POST['StartDate']));
$post_data['value_c'] = date("Y-m-t",strtotime($_POST['ExpiryDate']));
$post_data['value_d'] = $_POST['TotalMonth'];

# CART PARAMETERS
$post_data['cart'] = json_encode(array(
    array("product"=>"DHK TO BRS AC A1","amount"=>"200.00"),
    array("product"=>"DHK TO BRS AC A2","amount"=>"200.00"),
    array("product"=>"DHK TO BRS AC A3","amount"=>"200.00"),
    array("product"=>"DHK TO BRS AC A4","amount"=>"200.00")
));
$post_data['product_amount'] = "100";
$post_data['vat'] = "5";
$post_data['discount_amount'] = "5";
$post_data['convenience_fee'] = "3";

// API Endpoint (Sandbox/Test Environment): https://sandbox.sslcommerz.com/gwprocess/v4/api.php

// API Endpoint (Live Environment): https://securepay.sslcommerz.com/gwprocess/v4/api.php

// Method: POST ( CURL for PHP, httpwebrequest for .NET and etc)


# REQUEST SEND TO SSLCOMMERZ
$direct_api_url = "https://sandbox.sslcommerz.com/gwprocess/v3/api.php";

$handle = curl_init();
curl_setopt($handle, CURLOPT_URL, $direct_api_url );
curl_setopt($handle, CURLOPT_TIMEOUT, 30);
curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($handle, CURLOPT_POST, 1 );
curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE); # KEEP IT FALSE IF YOU RUN FROM LOCAL PC


$content = curl_exec($handle );

$code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

if($code == 200 && !( curl_errno($handle))) {
	curl_close( $handle);
	$sslcommerzResponse = $content;
} else {
	curl_close( $handle);
	echo "FAILED TO CONNECT WITH SSLCOMMERZ API";
	exit;
}

# PARSE THE JSON RESPONSE
$sslcz = json_decode($sslcommerzResponse, true );

if(isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL']!="" ) {
        # THERE ARE MANY WAYS TO REDIRECT - Javascript, Meta Tag or Php Header Redirect or Other
        # echo "<script>window.location.href = '". $sslcz['GatewayPageURL'] ."';</script>";
	echo "<meta http-equiv='refresh' content='0;url=".$sslcz['GatewayPageURL']."'>";
	# header("Location: ". $sslcz['GatewayPageURL']);
	exit;
} else {
	echo "JSON Data parsing error!";
}

}
?>