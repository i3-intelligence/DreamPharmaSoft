<?php
require_once '../includes/Auth.php'; // Session Starting file
include '../config/Database.php'; // Database connection file
?>
<script>
    
              //Auto Logout
        if (typeof (EventSource) !== "undefined") {
            var source = new EventSource("../actions/DuplicateLoginCheck.php?SessionID=<?php print $SessionID; ?>", {
                withCredentials: true
            });

            source.onmessage = function (event) {
                if (event.data == 'logout') {
                    window.location.href = "../actions/Logout.php";
                    // alert(event.data);    
                }else{
                    // alert(event.data);    
                }
            };

        } 

</script>

<?php
require('../actions/UserInformation.php');

 $get_ip =  UserInfo::get_ip();

$get_os = UserInfo::get_os();

$get_browser = UserInfo::get_browser();

$get_device= UserInfo::get_device();

//Php Ip Curl
$url ="http://ip-api.com/json/$get_ip";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$ip_json = curl_exec($ch);
// curl_close($ch);
$ip_array = json_decode($ip_json, true);

$ip_country = !empty($ip_array['country']) ? $ip_array['country'] : 'Bangladesh';
$ip_city = !empty($ip_array['city']) ? $ip_array['city'] : 'Dhaka';
$ip_isp = !empty($ip_array['isp']) ? $ip_array['isp'] : 'Local ISP';
$acces_query = $conn->prepare("SELECT * FROM `access_log` 
WHERE 
`date` = '".$CurrentDate."' 
AND `UserId` = '".$SessionID."' 
AND `AccessPage` = '$PageLevel' 
AND `os` = '$get_os' 
AND `browser` = '$get_browser' 
AND `device` = '$get_device' 
AND `IP` = '$get_ip'
AND `Country` = '$ip_country'
AND `City` = '$ip_city'
AND `ISP` = '$ip_isp'
AND `ShopId` = '".$ShopId."' "); 
$acces_query->execute();
$duplicate_access = $acces_query->rowCount();

if($duplicate_access >= 1){ 

    $fetch_access = $acces_query->fetch(PDO::FETCH_ASSOC);
    $AccessCount = ($fetch_access['AccessCount'] + 1);

    $access_update = $conn->prepare("UPDATE `access_log` 
    SET  
    `time` =  '$CurrentTime',
    `IP`='$get_ip',
    `os`='$get_os',
    `browser`='$get_browser',
    `AccessCount`='$AccessCount', 
    `device`='$get_device' 
    WHERE 
    `date` = '".$CurrentDate."' 
    AND `UserId` = '".$SessionID."' 
    AND `AccessPage` = '$PageLevel' 
    AND `os` = '$get_os' 
    AND `browser` = '$get_browser' 
    AND `device` = '$get_device' 
    AND `IP` = '$get_ip'
    AND `Country` = '$ip_country'
    AND `City` = '$ip_city'
    AND `ISP` = '$ip_isp'
    AND `ShopId` = '".$ShopId."'  "); 
    $access_update->execute();

    $LastLogin = $conn->prepare("UPDATE `user_information`
    SET
    `LastLogin` = '$CurrentDateTime'
    WHERE id = '".$SessionID."' ");
    $LastLogin->execute();

 }else{

  $access_insert = $conn->exec("INSERT INTO `access_log`
  (
        `Id`, 
        `UserId`, 
        `AccessPage`, 
        `AccessCount`, 
        `CurrentDateTime`, 
        `date`, 
        `time`,
        `IP`, 
        `os`, 
        `browser`, 
        `device`,
        `Country`,
        `City`,
        `ISP`,
        `ShopId`
      ) 
      VALUES 
      (
        '0',
        '".$SessionID."',
        '$PageLevel',
        '1',
        '$CurrentDateTime',
        '$CurrentDate',
        '$CurrentTime',
        '$get_ip',
        '$get_os',
        '$get_browser',
        '$get_device',
        '$ip_country',
        '$ip_city',
        '$ip_isp',
        '".$ShopId."'
        )");

    $LastLogin = $conn->prepare("UPDATE `user_information`
    SET
    `LastLogin` = '$CurrentDateTime'
    WHERE id = '".$SessionID."' ");
    $LastLogin->execute();

 }	

?>