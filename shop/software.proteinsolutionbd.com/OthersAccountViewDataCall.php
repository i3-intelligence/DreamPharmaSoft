<?php 
require_once("auth.php");
include("db.php");

$output= array();
$sql = "SELECT 
			`OthersAccountID`,
			`SectorName`,
			`OthersAccountName`,
			`MobileNo`,
			`CreditLimit`,
			`Category`,
            `OpeningBalance`, 
			`Status` 
		FROM `OthersAccount`";
$count = $conn->prepare($sql);
$count->execute();
$total_all_rows = $count->rowCount();

$columns = array(
	0 => 'OthersAccountID',
	1 => 'SectorName',
	2 => 'OthersAccountName',
	3 => 'MobileNo',
	4 => 'CreditLimit',
	5 => 'Category',
	6 => 'OpeningBalance',
	7 => 'Status'
);

if(isset($_POST['search']['value']))
{
	$search_value = $_POST['search']['value'];
	$sql .= " WHERE 
	`OthersAccountID` like '%".$search_value."%'";
    $sql .= " OR `SectorName` like '%".$search_value."%'";
    $sql .= " OR `OthersAccountName` like '%".$search_value."%'";
    $sql .= " OR `MobileNo` like '%".$search_value."%'";
    $sql .= " OR `CreditLimit` like '%".$search_value."%'";
    $sql .= " OR `Category` like '%".$search_value."%'";
    $sql .= " OR `OpeningBalance` like '%".$search_value."%'";
    $sql .= " OR `Status` like '%".$search_value."%'";
}

if(isset($_POST['order']))
{
	$column_name = $_POST['order'][0]['column'];
	$order = $_POST['order'][0]['dir'];
	$sql .= " ORDER BY ".$columns[$column_name]." ".$order."";
}
else
{
    $sql .= " ORDER BY `SectorName`,`OthersAccountName`,LPAD(`OthersAccountID`, 3, '0') ASC";
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
    $sub_array[] = html_entity_decode(sprintf("%03d",$fetch["OthersAccountID"]));
    $sub_array[] = html_entity_decode($fetch["SectorName"]);
    $sub_array[] = html_entity_decode($fetch["OthersAccountName"]);
    $sub_array[] = html_entity_decode($fetch["MobileNo"]);
    $sub_array[] = html_entity_decode($fetch["CreditLimit"]);
    $sub_array[] = html_entity_decode($fetch["Category"]);
    $sub_array[] = html_entity_decode($fetch["OpeningBalance"]);
	$sub_array[] = "<span class=\"$status_span\">$fetch[Status]</span>";
						$sub_array[] = "<a class=\"btn btn-warning\" data-toggle=\"modal\" data-target=\"#modal-default1\"
						data-whatever=\"$fetch[OthersAccountID]\">
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
