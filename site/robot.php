<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//Function to sanitize values received from the form. Prevents SQL injection
function clean($str)
{ 
  // $str = trim($str);

  while(substr($str, 0,1)==" ") 
    {
        $str = substr($str, 1);
        clean($str);
    }
    while(substr($str, -1)==" ")
    {
        $str = substr($str, 0, -1);
        clean($str);
    }

  // Convert the first character of "hello" to uppercase:
  $str = ucfirst($str);

  // Convert the first character of each word in a string to uppercase: 
  $str = stripslashes($str);


  return addslashes(strip_tags(htmlspecialchars(htmlentities($str))));
}


	## FOR ONLINE
	$prefix = "mwsbdco";
	$servername = "localhost";
	$username = $prefix."_parma";
	$Password = "vqNP5skZmaODBNeT";
	$database = $prefix."_parma_admin";

try {
	$conn = new PDO ("mysql:host=$servername;dbname=$database", "$username", "$Password", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //Print "Connected successfully"; 
    }
catch(PDOException $e)
{
Print "Connection failed: " . $e->getMessage();
}



$sl= 1;
$query = $conn->prepare("SELECT *,COUNT(*),MIN(Id) As `GetId`,MAX(Id) as `DeleteId` FROM `Medicine` GROUP BY MedicineName,Company,Generic,PurchasePrice,SalePrice HAVING COUNT(*) >=2  
ORDER BY `COUNT(*)`  DESC;");
$query->execute();
$fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);
foreach($fetch_list AS $fetch){

        $MedicineName = ucwords(clean($fetch['MedicineName']));
        $Company = ucwords(clean($fetch['Company']));
        $Generic = ucwords(clean($fetch['Generic']));
        

        ## ready to delete
        $delete = $conn->prepare("DELETE FROM `Medicine` WHERE `Id` = '".$fetch['DeleteId']."' ");
        $delete->execute();

        print $sl++." - ".$fetch['GetId']." - ".$fetch['DeleteId']." - ".$MedicineName." - ".$Company." - ".$Generic;
        print "<br>";
}
?>