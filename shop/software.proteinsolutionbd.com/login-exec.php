<?php
//Start session
session_start();

date_default_timezone_set('Asia/Dhaka');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Include database connection details
require_once('db.php');

//Function to sanitize values received from the form. Prevents SQL injection
function clean($str) {
$str = trim($str);
// if(get_magic_quotes_gpc()) {
$str = stripslashes($str);
// }
return addslashes(strip_tags($str));
}

//Sanitize the POST values

$User = clean($_POST['User']);
$Password = clean($_POST['Password']);

$verification_code = (rand(111111,999999));

//Create query

$query = $conn->prepare("SELECT A.* FROM `UserInformation` A
JOIN `Shop` B ON (A.`ShopId` = B.`Id`)
WHERE A.`User` = '$User' AND A.`Password` = '".md5($Password)."' AND A.`block` = 'No' AND B.`Status` = 'Active' "); 
$query->execute();

//Check whether the query was successful or not
if($query->rowCount()==1){


#Login Successful
session_regenerate_id();
$member = $query->fetch(PDO::FETCH_ASSOC);

$_SESSION['PS_SESS_MEMBER_ID'] = $member['Id'];
$verify_id = $member['Id'];
$_SESSION['Token'] = sha1(rand(10,100000));

$message = "
<b>🔐 Secure Verification</b>
━━━━━━━━━━━━━━━━━━
👤 <b>User: 🟢 $User</b> 
📩 <b>Your One-Time Password (OTP)</b>

🔴🔑 <code><b>$verification_code</b></code>🔴

⏳ This code will expire in 5 minutes.

⚠️ <b>Security Notice:</b>
Do NOT share this code with anyone.
━━━━━━━━━━━━━━━━━━
🏢 <b>$company</b>
";

$api = "https://api.telegram.org/bot6255638604:AAGf-d3O0ZMRbMz0oXU1K2FHGB-b1PgdeNI/sendMessage";

$data = [
    'chat_id' => '-1003505685994',
    'text' => $message,
    'parse_mode' => 'HTML'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

if(!empty($_POST['remember'])){
 //set cookie for 365 days
 setcookie('User',$User,time()+60*60*24*365);
 setcookie('Password',$Password,time()+60*60*24*365);
//  print $_COOKIE['User'];
//  print $_COOKIE['Password'];
}else{
    //destroy any previously set cookie
    setcookie('User','',time()-1);
    setcookie('Password','',time()-1);
    // print "Cookie Destroy";
}
//Update Last Login
$query = $conn->prepare("UPDATE `UserInformation` SET `LastLogin` = '$CurrentDateTime',`Token` = '$_SESSION[Token]',`OTP` = '$verification_code'  WHERE `Id` = '".$_SESSION['PS_SESS_MEMBER_ID']."'");
$query->execute();

session_write_close();
// header("location: home.php");
header("location: login/verification.php?verify_id=" . $verify_id);
exit();

}
else{

//Shop is not active
$query = $conn->prepare("SELECT A.* FROM `UserInformation` A
JOIN `Shop` B ON (A.`ShopId` = B.`Id`)
WHERE A.`User` = '$User' AND A.`Password` = '".md5($Password)."' AND A.`block` = 'No' AND B.`Status` = 'Inactive'"); 
$query->execute();

//Check whether the query was successful or not

if($query->rowCount()==1){

//Login failed
header("location:index.php?notify=inactive");
exit();

}


//User is blocked
$query = $conn->prepare("SELECT A.* FROM `UserInformation` A
JOIN `Shop` B ON (A.`ShopId` = B.`Id`)
WHERE A.`User` = '$User' AND A.`Password` = '".md5($Password)."' AND A.`block` = 'Yes'"); 
$query->execute();

//Check whether the query was successful or not

if($query->rowCount()==1){

//Login failed
header("location:login/index.php?notify=blocked");
exit();
}else{
//Login failed
header("location:login/index.php?notify=login_faield");
exit();
}



}

### END 



?>