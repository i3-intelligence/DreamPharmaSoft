<?php
require_once '../includes/Auth.php'; // Session Starting file
include '../config/Database.php'; // Database connection file
include('Function.php');

$output= array();
$sql = "SELECT 
                A.`Id`,
                A.`ShopName`,
                A.`ShopContact`,
                A.`ShopAddress`,
                CONCAT(C.`PackageName`, '/' ,C.`PacakageDuration`, '/' ,C.`PacakageAmount` , 'Tk/' ,C.`NumberOfUser`,' Users') AS PackageInfo,
                DATE_FORMAT(A.`SubscriptionStartDate`, '%d/%m/%Y') AS SubscriptionStartDate,
                DATE_FORMAT(A.`SubscriptionEndDate`, '%d/%m/%Y') AS SubscriptionEndDate,
                A.`Status`,
                A.`CreateDate`

FROM `shop` A
LEFT JOIN `package` C ON A.`PackageId`=C.`Id`";
$total_all_rows = GetOwnerAllRecords($conn);

$columns = array(
	0 => 'Id',
    1 => 'ShopName',
    3 => 'ShopContact',
    4 => 'ShopAddress',
    5 => 'PackageInfo',
    6 => 'SubscriptionStartDate',
    7 => 'SubscriptionEndDate',
    8 => 'Status',
    9 => 'CreateDate',
);

if(isset($_POST['search']['value']))
{
	$search_value = $_POST['search']['value'];
	$sql .= "WHERE A.`ShopName` like '%".$search_value."%'";
    $sql .= " OR A.ShopContact like '%".$search_value."%'";
    $sql .= " OR A.ShopAddress like '%".$search_value."%'";
    $sql .= " OR C.PackageName like '%".$search_value."%'";
    $sql .= " OR C.PacakageDuration like '%".$search_value."%'";
    $sql .= " OR C.PacakageAmount like '%".$search_value."%'";
    $sql .= " OR C.NumberOfUser like '%".$search_value."%'";
    $sql .= " OR DATE_FORMAT(A.`SubscriptionStartDate`, '%d/%m/%Y') like '%".$search_value."%'";
    $sql .= " OR DATE_FORMAT(A.`SubscriptionEndDate`, '%d/%m/%Y') like '%".$search_value."%'";
    $sql .= " OR DATE_FORMAT(A.`CreateDate`, '%d/%m/%Y - %h:%i:%s %p') like '%".$search_value."%'";
    $sql .= " OR A.Status like '%".$search_value."%'";

}

if(isset($_POST['order']))
{
	$column_name = $_POST['order'][0]['column'];
	$order = $_POST['order'][0]['dir'];
	$sql .= " ORDER BY ".$columns[$column_name]." ".$order."";
}
else
{
	$sql .= " ORDER BY Id desc";
}

if($_POST['length'] != -1)
{
	$start = $_POST['start'];
	$length = $_POST['length'];
	$sql .= " LIMIT  ".$start.", ".$length;
}	

$statement = $conn->prepare($sql);
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
$count_rows = $statement->rowCount();
$data = array();
$Sl = 1;
foreach($result as $fetch)
{
	$sub_array = array();
	$sub_array[] = $Sl++;
	
	$CreateDate = date("d/m/Y - h:i:s a",strtotime($fetch['CreateDate']));
	if($fetch['Status']=='Active'){ $status_span = "badge badge-success"; }else{ $status_span = "badge badge-danger"; }
    $sub_array[] = html_entity_decode($fetch["ShopName"]);
    $sub_array[] = html_entity_decode($fetch["ShopContact"]);
    $sub_array[] = html_entity_decode($fetch["ShopAddress"]);
    $sub_array[] = html_entity_decode($fetch["PackageInfo"]);
    $sub_array[] = html_entity_decode($fetch["SubscriptionStartDate"]);
    $sub_array[] = html_entity_decode($fetch["SubscriptionEndDate"]);


	$sub_array[] = "<span class=\"$status_span\">$fetch[Status]</span>";
	$sub_array[] = "$CreateDate";
						$sub_array[] = "<a data-title=\"View To More Details\" class=\"btn btn-warning\" data-toggle=\"modal\" data-target=\"#modal-default1\"
						data-whatever=\"$fetch[Id]\">
						<i class=\"fas fa-pencil-alt\"></i>
						Edit
					  </a>";
		
	$data[] = $sub_array;
}

$output = array(
	'draw'=> intval($_POST['draw']),
	'recordsTotal' =>$count_rows ,
	'recordsFiltered'=>   $total_all_rows,
	'data'=>$data,
);
echo  json_encode($output);
