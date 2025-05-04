<?php
include '../config/database.php'; // Database connection file
include '../includes/session.php'; // Session Starting file

date_default_timezone_set('Asia/Dhaka');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Sanitize the POST values
$User = $_POST['User'];
$Password = $_POST['Password'];


if ($_POST['CSRF_token'] !== $_SESSION['CSRF']) {
    die("CSRF token mismatch!");
}

//Check query
$query = $conn->prepare("SELECT `Id`,`User`,`Password` FROM `controller_information`
WHERE `User` = '$User' AND `block` = 'No'"); 
$query->execute();

//Check whether the query was successful or not
if($query->rowCount()==1){
$FetchLoginData = $query->fetch(PDO::FETCH_ASSOC);

//Check whether the password is correct or not
if (password_verify($Password, $FetchLoginData['Password'])) {

#Login Successful
session_regenerate_id(true);
$_SESSION['DPS_ADMIN_SSN_ID'] = $FetchLoginData['Id'];
$_SESSION['Token'] = sha1(rand(10,100000));

if(!empty($_POST['reFetchLoginData'])){
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
$query = $conn->prepare("UPDATE `controller_information` SET `LastLogin` = '$CurrentDateTime',`Token` = '$_SESSION[Token]'  WHERE `Id` = '".$_SESSION['DPS_ADMIN_SSN_ID']."'");
$query->execute();

session_write_close();
header("location: ../views/Dashboard.php");
exit();

}else{
    //Login failed
    header("location:../views/login.php?notify=login_faield");
    // print "<br>Password User: ".$hashedPassword = password_hash($Password, PASSWORD_ARGON2I);

}

}
else{

//User is blocked
$query = $conn->prepare("SELECT A.* FROM `controller_information` A
WHERE A.`User` = '$User' AND A.`Password` = '".md5($Password)."' AND A.`block` = 'Yes'"); 
$query->execute();

//Check whether the query was successful or not

if($query->rowCount()==1){

//Login failed
header("location:../views/login.php?notify=blocked");
exit();
}else{
//Login failed
header("location:../views/login.php?notify=login_faield");
exit();
}



}

### END 



?>