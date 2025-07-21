<?php
include("db.php");
// header('Content-Type: application/json');
$val_id=urlencode($_POST['val_id']);
$store_id=urlencode("shahe631848c754133");
$store_passwd=urlencode("shahe631848c754133@ssl");
$requested_url = ("https://sandbox.sslcommerz.com/validator/api/validationserverAPI.php?val_id=".$val_id."&store_id=".$store_id."&store_passwd=".$store_passwd."&v=1&format=json");

$handle = curl_init();
curl_setopt($handle, CURLOPT_URL, $requested_url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false); # IF YOU RUN FROM LOCAL PC
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false); # IF YOU RUN FROM LOCAL PC

$result = curl_exec($handle);

$code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

if($code == 200 && !( curl_errno($handle)))
{

	# TO CONVERT AS ARRAY
	# $result = json_decode($result, true);
	# $status = $result['status'];

	# TO CONVERT AS OBJECT
	$result = json_decode($result);

    // print_r($result);


	# TRANSACTION INFO
	$status = $result->status;
	$tran_date = $result->tran_date;
	$tran_id = $result->tran_id;
	$val_id = $result->val_id;
	$amount = $result->amount;
	$store_amount = $result->store_amount;
	$bank_tran_id = $result->bank_tran_id;
	$card_type = $result->card_type;

	# CARD INFO
    $card_category = $result->card_category;
    $card_sub_brand = $result->card_sub_brand;
    $currency_type = $result->currency_type;
    $currency_amount = $result->currency_amount;
    $currency_rate = $result->currency_rate;
    $base_fair = $result->base_fair;
    $account_details = $result->account_details;
    $risk_title = $result->risk_title;
    $risk_level = $result->risk_level;
    $discount_percentage = $result->discount_percentage;
    $discount_amount = $result->discount_amount;
    $discount_remarks = $result->discount_remarks;
    $offer_avail = $result->offer_avail;
    $card_ref_id = $result->card_ref_id;
    $isTokeizeSuccess = $result->isTokeizeSuccess;
    $campaign_code = $result->campaign_code;

	# EMI INFO
	$emi_instalment = $result->emi_instalment;
	$emi_amount = $result->emi_amount;
	$emi_description = $result->emi_description;
	$emi_issuer = $result->emi_issuer;

	# ISSUER INFO
	$card_no = $result->card_no;
	$card_issuer = $result->card_issuer;
	$card_brand = $result->card_brand;
	$card_issuer_country = $result->card_issuer_country;
	$card_issuer_country_code = $result->card_issuer_country_code;

	# API AUTHENTICATION
	$APIConnect = $result->APIConnect;
	$validated_on = $result->validated_on;
	$gw_version = $result->gw_version;

    # OPTIONAL PARAMETERS
    $currency = $result->currency;
    $value_a = $result->value_a;
    $value_b = $result->value_b;
    $value_c = $result->value_c;
    $value_d = $result->value_d;
    
    $QuaryCheck = $conn->prepare("SELECT * FROM `SslTransaction` 
	WHERE  `tran_id` = '$tran_id'  "); 
    $QuaryCheck->execute();

    if($QuaryCheck->rowCount() == 0){

    $Quary = $conn->exec("INSERT INTO `SslTransaction` 
                            (
                                `value_a`, 
                                `value_b`, 
                                `value_c`, 
                                `value_d`, 
                                `status`, 
                                `val_id`, 
                                `tran_date`, 
                                `tran_id`, 
                                `amount`, 
                                `store_amount`, 
                                `currency`, 
                                `bank_tran_id`, 
                                `card_type`, 
                                `card_no`, 
                                `card_issuer`, 
                                `card_brand`, 
                                `card_category`, 
                                `card_sub_brand`, 
                                `card_issuer_country`, 
                                `currency_type`, 
                                `currency_amount`, 
                                `currency_rate`, 
                                `base_fair`, 
                                `emi_instalment`, 
                                `emi_amount`, 
                                `emi_description`, 
                                `emi_issuer`, 
                                `account_details`, 
                                `risk_title`, 
                                `risk_level`, 
                                `discount_percentage`, 
                                `discount_amount`, 
                                `discount_remarks`, 
                                `APIConnect`, 
                                `validated_on`, 
                                `gw_version`, 
                                `offer_avail`, 
                                `card_ref_id`, 
                                `isTokeizeSuccess`, 
                                `campaign_code`
                            ) 
                            VALUES
                            (
                                '$value_a',
                                '$value_b',
                                '$value_c',
                                '$value_d',
                                '$status',
                                '$val_id',
                                '$tran_date',
                                '$tran_id',
                                '$amount',
                                '$store_amount',
                                '$currency',
                                '$bank_tran_id',
                                '$card_type',
                                '$card_no',
                                '$card_issuer',
                                '$card_brand',
                                '$card_category',
                                '$card_sub_brand',
                                '$card_issuer_country',
                                '$currency_type',
                                '$currency_amount',
                                '$currency_rate',
                                '$base_fair',
                                '$emi_instalment',
                                '$emi_amount',
                                '$emi_description',
                                '$emi_issuer',
                                '$account_details',
                                '$risk_title',
                                '$risk_level',
                                '$discount_percentage',
                                '$discount_amount',
                                '$discount_remarks',
                                '$APIConnect',
                                '$validated_on',
                                '$gw_version',
                                '$offer_avail',
                                '$card_ref_id',
                                '$isTokeizeSuccess',
                                '$campaign_code'
                            )
                        ");
    header("location: AccountStatus.php?val_id=$val_id");
    }

} else {

	echo "Failed to connect with SSLCOMMERZ";
}
?>