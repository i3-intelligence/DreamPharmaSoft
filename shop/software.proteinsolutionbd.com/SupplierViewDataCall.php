<?php 
require_once("auth.php");
include("db.php");

$output= array();
$sql = "SELECT 	
				A.*,
				B.`Name` AS `SupplierCategory` 
		FROM `Supplier` A 
		LEFT JOIN `SupplierCategory` B ON (A.`SupplierCategoryID` = B.`SupplierCategoryID`) ";
$count = $conn->prepare($sql);
$count->execute();
$total_all_rows = $count->rowCount();

$columns = array(
	0 => 'SupplierID',
	1 => 'Name',
	2 => 'ColorCode',
	3 => 'SupplierCategory',
	4 => 'MobileNo',
	5 => 'Address',
	6 => 'ContactPersonInfo',
    7 => 'OpeningBalance',
	8 => 'Status',

);

if(isset($_POST['search']['value']))
{
	$search_value = $_POST['search']['value'];
	$sql .= " WHERE 
	A.`SupplierID` like '%".$search_value."%'";
    $sql .= " OR A.`ColorCode` like '%".$search_value."%'";
	$sql .= " OR A.`Name` like '%".$search_value."%'";
	$sql .= " OR B.`Name` like '%".$search_value."%'";
    $sql .= " OR A.`MobileNo` like '%".$search_value."%'";
    $sql .= " OR A.`Address` like '%".$search_value."%'";
	$sql .= " OR A.`ContactPersonInfo` like '%".$search_value."%'";
    $sql .= " OR A.`OpeningBalance` like '%".$search_value."%'";
    $sql .= " OR A.`Status` like '%".$search_value."%'";
}

if(isset($_POST['order']))
{
	$column_name = $_POST['order'][0]['column'];
	$order = $_POST['order'][0]['dir'];
	$sql .= " ORDER BY ".$columns[$column_name]." ".$order."";
}
else
{
    $sql .= " ORDER BY A.`Name`,A.`ColorCode`,A.`MobileNo`,LPAD(A.`SupplierID`, 3, '0') ASC";
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

	if($fetch['Status']=='Active'){ $status_span = "badge badge-success"; }else{ $status_span = "badge badge-danger"; }
    $sub_array[] = html_entity_decode(sprintf("%03d",$fetch["SupplierID"]));
    $sub_array[] = "<b style=\"color:$fetch[ColorCode]\">$fetch[ColorCode]</b>";
    $sub_array[] = html_entity_decode($fetch["Name"]);
    $sub_array[] = html_entity_decode($fetch["SupplierCategory"]);
    $sub_array[] = html_entity_decode($fetch["MobileNo"]);
    $sub_array[] = html_entity_decode($fetch["Address"]);
    $sub_array[] = html_entity_decode($fetch["ContactPersonInfo"]);
    $sub_array[] = html_entity_decode($fetch["OpeningBalance"]);
	$sub_array[] = "<span class=\"$status_span\">$fetch[Status]</span>";
						$sub_array[] = "<a class=\"btn btn-warning\" data-toggle=\"modal\" data-target=\"#modal-default1\"
						data-whatever=\"$fetch[SupplierID]\">
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
