<?php
include 'Database.php'; // Database connection file
include 'Session.php'; // Session Starting file

date_default_timezone_set('Asia/Dhaka');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Sanitize the POST values
$Phone = $_POST['Phone'];
$Password = $_POST['Password'];

if ($_POST['CSRF_token'] !== $_SESSION['CSRF']) {
    die("CSRF token mismatch!");
}

//Check query
$query = $conn->prepare("SELECT `Id`,`Phone`,`Password` FROM `user_information`
WHERE `Phone` = '$Phone' AND `block` = 'No'"); 
$query->execute();

//Check whether the query was successful or not
if($query->rowCount()==1){
$FetchLoginData = $query->fetch(PDO::FETCH_ASSOC);

//Check whether the password is correct or not
if($FetchLoginData['Password'] === md5($Password)){ 

#Login Successful
session_regenerate_id(true);
$_SESSION['DPS_SHOP_SSN_ID'] = $FetchLoginData['Id'];
$_SESSION['Token'] = sha1(rand(10,100000));

if(!empty($_POST['reFetchLoginData'])){
 //set cookie for 365 days
 setcookie('Phone',$Phone,time()+60*60*24*365);
 setcookie('Password',$Password,time()+60*60*24*365);
//  print $_COOKIE['Phone'];
//  print $_COOKIE['Password'];
}else{
    //destroy any previously set cookie
    setcookie('Phone','',time()-1);
    setcookie('Password','',time()-1);
    // print "Cookie Destroy";
}

//Update Last Login
$query = $conn->prepare("UPDATE `user_information` SET `LastLogin` = '$CurrentDateTime',`Token` = '$_SESSION[Token]'  WHERE `Id` = '".$_SESSION['DPS_SHOP_SSN_ID']."'");
$query->execute();

session_write_close();
header("location: Dashboard.php");

}else{
    //Login failed
    header("location:Login.php?notify=login_faield");

}

}
else{

//Phone is blocked
$query = $conn->prepare("SELECT A.* FROM `user_information` A
WHERE A.`Phone` = '$Phone' AND A.`Password` = '".md5($Password)."' AND A.`block` = 'Yes'"); 
$query->execute();

//Check whether the query was successful or not

if($query->rowCount()==1){

//Login failed
header("location:Login.php?notify=blocked");
exit();
}else{
//Login failed
header("location:Login.php?notify=login_faield");
exit();
}



}

### END 



?>